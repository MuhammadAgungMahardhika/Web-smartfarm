<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Str;

class UserController extends Controller
{

    protected $model;
    protected $userRepository;
    /**
     * Create a new controller instance.
     */
    public function __construct(User $user, UserRepository $userRepository)
    {
        $this->model = $user;
        $this->userRepository = $userRepository;
    }

    public function index($id = null)
    {
        if ($id != null) {
            $items = User::with('roles')->where('id', $id)->first();
        } else {
            $items = User::with('roles')->orderBy('id', 'ASC')->get();
        }
        return response(['data' => $items, 'status' => 200]);
    }
    public function userFree()
    {

        $pemilik = DB::table('users')->leftJoin('kandang', 'kandang.id_user', '=', 'users.id')
            ->where('users.id_role', '=', 2)
            ->where('kandang.id_user', '=', null)
            ->select('users.*')
            ->get();
        $peternak = DB::table('users')->leftJoin('kandang', 'kandang.id_peternak', '=', 'users.id')
            ->where('users.id_role', '=', 3)
            ->where('kandang.id_peternak', '=', null)
            ->select('users.*')
            ->get();
        $items = [
            'pemilik' => $pemilik,
            'peternak' => $peternak
        ];
        return response(['data' => $items, 'status' => 200]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'id_role' => 'required',
                'name' => 'required',
                'email' => 'required|string',
                'phone_number' => 'required|string',
                'password' => 'required|string',
                'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
            ]);

            $user = $this->userRepository->createAccount(
                (object) [
                    "id_role" => $request->id_role,
                    "name" => $request->name,
                    "email" => $request->email,
                    "phone_number" => $request->phone_number,
                    "password" => $request->password,
                    "email_verified_at" => now(),
                    'remember_token' => Str::random(10),
                    "created_by" => Auth::user()->id
                ]
            );
            // event(new AddKandangEvent( $this->model->get() ));
            return response()->json([
                'message' => 'success created account',
                'user' => $user
            ], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 422);
        } catch (QueryException $th) {
            return $this->handleQueryException($th);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'id_role' => 'required',
                'name' => 'required',
                'email' => 'required|string',
                'phone_number' => 'required|string',
            ]);

            $user = $this->userRepository->updateAccount($id, (object) [
                "id_role" => $request->id_role,
                "name" => $request->name,
                "email" => $request->email,
                "phone_number" => $request->phone_number,
                "updated_by" => Auth::user()->id
            ]);
            // event(new AddKandangEvent( $this->model->get() ));
            return response()->json([
                'message' => 'success update account',
                'user' => $user
            ], Response::HTTP_OK);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 422);
        } catch (QueryException $th) {
            return $th->getMessage();
        }
    }

    public function delete($id)
    {
        try {
            $user = $this->userRepository->deleteAccount($id);
            return response()->json([
                'message' => 'success delete account',
                'user' => $user
            ], Response::HTTP_OK);
        } catch (QueryException $th) {
            return $th->getMessage();
        }
    }
}
