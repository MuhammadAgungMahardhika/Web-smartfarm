<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Repositories\RoleRepository;
use App\Repositories\RolesRepository;
use App\Repositories\UserRepository;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Jetstream\Jetstream;

class RolesController extends Controller
{


    protected $roleRepository;
    /**
     * Create a new controller instance.
     */
    public function __construct(RolesRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function index($id = null)
    {
        if ($id != null) {
            $items = Role::findOrFail($id);
        } else {
            $items = Role::get();
        }
        return response(['data' => $items, 'status' => 200]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'id_role' => 'required',
                'name' => 'required',
            ]);

            $role = $this->roleRepository->createRole(
                (object) [
                    "id_role" => $request->id_role,
                    "name" => $request->name,
                ]
            );
            // event(new AddKandangEvent( $this->model->get() ));
            return response()->json([
                'message' => 'success created account',
                'role' => $role
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
            ]);

            $role = $this->roleRepository->updateRole($id, (object) [
                "id_role" => $request->id_role,
                "name" => $request->name,
            ]);
            // event(new AddKandangEvent( $this->model->get() ));
            return response()->json([
                'message' => 'success update account',
                'role' => $role
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
            $role = $this->roleRepository->deleteRole($id);
            return response()->json([
                'message' => 'success delete account',
                'role' => $role
            ], Response::HTTP_OK);
        } catch (QueryException $th) {
            return $th->getMessage();
        }
    }
}
