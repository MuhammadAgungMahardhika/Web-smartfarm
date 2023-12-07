<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 * 
 * @property int $id_role
 * @property string $nama_role
 * 
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Role extends Model
{
	protected $table = 'roles';
	protected $primaryKey = 'id_role';
	public $timestamps = false;

	protected $fillable = [
		'nama_role'
	];

	public function users()
	{
		return $this->hasMany(User::class, 'id_role');
	}
}
