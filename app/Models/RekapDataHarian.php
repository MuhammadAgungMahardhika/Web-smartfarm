<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RekapDataHarian
 * 
 * @property int $id_rekap_data_harian
 * @property int $id_kandang
 * @property Carbon $date
 * @property int $amoniak
 * @property int $suhu
 * @property int $kelembapan
 * @property Carbon $created_at
 * @property int|null $created_by
 * @property Carbon $updated_at
 * @property int|null $updated_by
 * 
 * @property Kandang $kandang
 *
 * @package App\Models
 */
class RekapDataHarian extends Model
{
	protected $table = 'rekap_data_harian';
	public $incrementing = false;

	protected $casts = [
		'id_rekap_data_harian' => 'int',
		'id_kandang' => 'int',
		'date' => 'datetime:Y-m-d',
		'amoniak' => 'int',
		'suhu' => 'int',
		'kelembapan' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'id_rekap_data_harian',
		'id_kandang',
		'date',
		'amoniak',
		'suhu',
		'kelembapan',
		'created_by',
		'updated_by'
	];

	public function kandang()
	{
		return $this->belongsTo(Kandang::class, 'id_kandang');
	}
}
