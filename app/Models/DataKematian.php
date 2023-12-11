<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DataKematian
 * 
 * @property int $id_data_kematian
 * @property int $kematian_terbaru
 * @property int $jumlah_kematian
 * @property int $jam
 * @property Carbon $hari
 * @property int $id_data_kandang
 * @property Carbon $created_at
 * @property int|null $created_by
 * @property Carbon $updated_at
 * @property int|null $updated_by
 * 
 * @property DataKandang $data_kandang
 *
 * @package App\Models
 */
class DataKematian extends Model
{
	protected $table = 'data_kematian';
	protected $primaryKey = 'id';

	protected $casts = [
		'kematian_terbaru' => 'int',
		'jumlah_kematian' => 'int',
		'hari' => 'datetime',
		'id_data_kandang' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'kematian_terbaru',
		'jumlah_kematian',
		'jam',
		'hari',
		'id_data_kandang',
		'created_by',
		'updated_by'
	];

	public function data_kandang()
	{
		return $this->belongsTo(DataKandang::class, 'id_data_kandang');
	}
}
