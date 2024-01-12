<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Repositories\NotificationRepository;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class NotificationController extends Controller
{
    protected $model;
    protected $notificationRepository;
    /**
     * Create a new controller instance.
     */
    public function __construct(Notification $notification, NotificationRepository $notificationRepository)
    {
        $this->model = $notification;
        $this->notificationRepository = $notificationRepository;
    }

    public function index($id = null)
    {
        if ($id != null) {
            $items = $this->model::findOrFail($id)->with('kandang');
        } else {
            $items = $this->model->get();
        }
        return response(['data' => $items, 'status' => 200]);
    }


    public function getNotificationByKandangId($id)
    {
        $items = DB::table('notification')->where('id_kandang', '=', $id)->orderBy('waktu', 'desc')->get();
        return response(['data' => $items, 'status' => 200]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'id_kandang' => 'required',
                'pesan' => 'required',
            ]);

            $notification = $this->notificationRepository->createNotification(
                (object) [
                    "id_kandang" => $request->id_kandang,
                    "pesan" => $request->pesan,
                    "status" => $request->status,
                    "waktu" =>  Carbon::now()->timezone('Asia/Jakarta')
                ]
            );
            // event(new AddKandangEvent( $this->model->get() ));
            return response()->json([
                'message' => 'success created notification',
                'notification' => $notification
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
                'status' => 'required',
            ]);

            $notification = $this->notificationRepository->editNotification($id, (object) [
                "status" => $request->status
            ]);
            // event(new AddKandangEvent( $this->model->get() ));
            return response()->json([
                'message' => 'success update notification',
                'notification' => $notification
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
            $notification = $this->notificationRepository->deleteNotification($id);
            return response()->json([
                'message' => 'success delete account',
                'notification' => $notification
            ], Response::HTTP_OK);
        } catch (QueryException $th) {
            return $th->getMessage();
        }
    }
}
