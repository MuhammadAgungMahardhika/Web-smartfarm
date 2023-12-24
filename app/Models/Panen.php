<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Panen
 * 
 * @property int $id_panen
 * @property int $id_kandang
 * @property Carbon $tanggal_mulai
 * @property Carbon $tanggal_panen
 * @property int $jumlah_panen
 * @property int $bobot_total
 * @property Carbon $created_at
 * @property int|null $created_by
 * @property Carbon $updated_at
 * @property int|null $updated_by
 * 
 * @property Kandang $kandang
 *
 * @package App\Models
 */
class Panen extends Model
{
	protected $table = 'panen';
	protected $primaryKey = 'id';

	protected $casts = [
		'id_kandang' => 'int',
		'jumlah_panen' => 'int',
		'bobot_total' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'id_kandang',
		'tanggal_mulai',
		'tanggal_panen',
		'jumlah_panen',
		'bobot_total',
		'created_by',
		'updated_by'
	];

	public function kandang()
	{
		return $this->belongsTo(Kandang::class, 'id_kandang', 'id');
	}
}
