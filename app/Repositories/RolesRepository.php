<?php

namespace App\Repositories;

use App\Models\Role;
use Illuminate\Support\Facades\Log;
use stdClass;
use Exception;

class RolesRepository
{

    public function __construct()
    {
    }

    public function createRole(object $data): Role
    {
        try {
            $role = new Role();
            $role->id_role = $data->id_role;
            $role->name = $data->name;
            $role->save();

            return $role;
        } catch (Exception $th) {
            Log::error('Error generating token.');
            Log::error($th->getMessage());
            throw $th;
        }
    }
    public function updateRole(object $data): Role
    {
        try {
            $role = new Role();
            $role->id_role = $data->id_role;
            $role->name = $data->name;
            $role->save();

            return $role;
        } catch (Exception $th) {
            Log::error('Error generating token.');
            Log::error($th->getMessage());
            throw $th;
        }
    }

    public function deleteRole($id): Role
    {
        try {
            $role = Role::findOrFail($id);
            $role->delete();

            return $role;
        } catch (Exception $th) {
            Log::error('Error delete data role.');
            Log::error($th->getMessage());
            throw $th;
        }
    }
}
