<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SuhuKelembapanSensor
 * 
 * @property int $id_suhu_kelembapan_sensor
 * @property int $id_kandang
 * @property int $suhu
 * @property Carbon $date
 * @property int $kelembapan
 * 
 * @property Kandang $kandang
 *
 * @package App\Models
 */
class SuhuKelembapanSensor extends Model
{
	protected $table = 'suhu_kelembapan_sensors';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $casts = [
		'id_kandang' => 'int',
		'suhu' => 'int',
		'date' => 'datetime',
		'kelembapan' => 'int'
	];

	protected $fillable = [
		'id_kandang',
		'suhu',
		'date',
		'kelembapan'
	];

	public function kandang()
	{
		return $this->belongsTo(Kandang::class, 'id_kandang');
	}
}
