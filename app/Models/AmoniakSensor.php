<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AmoniakSensor
 * 
 * @property int $id_amoniak_sensor
 * @property int $id_kandang
 * @property Carbon $date
 * @property int $amoniak
 * 
 * @property Kandang $kandang
 *
 * @package App\Models
 */
class AmoniakSensor extends Model
{
	protected $table = 'amoniak_sensors';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $casts = [
		'id_kandang' => 'int',
		'date' => 'datetime',
		'amoniak' => 'int'
	];

	protected $fillable = [
		'id_kandang',
		'date',
		'amoniak'
	];

	public function kandang()
	{
		return $this->belongsTo(Kandang::class, 'id');
	}
}
