<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Kandang
 * 
 * @property int $id_kandang
 * @property int $id_user
 * @property string $nama_kandang
 * @property int $populasi_awal
 * @property string $alamat_kandang
 * @property Carbon $created_at
 * @property int|null $created_by
 * @property Carbon $updated_at
 * @property int|null $updated_by
 * 
 * @property User $user
 * @property Collection|AmoniakSensor[] $amoniak_sensors
 * @property Collection|DataKandang[] $data_kandangs
 * @property Collection|Panen[] $panens
 * @property Collection|RekapDatum[] $rekap_data
 * @property RekapDataHarian $rekap_data_harian
 * @property Collection|SuhuKelembapanSensor[] $suhu_kelembapan_sensors
 *
 * @package App\Models
 */
class Kandang extends Model
{
	protected $table = 'kandang';
	protected $primaryKey = 'id';

	protected $casts = [
		'id_user' => 'int',
		'populasi_awal' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'id_user',
		'nama_kandang',
		'populasi_awal',
		'alamat_kandang',
		'created_by',
		'updated_by'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'id_user');
	}

	public function data_kandangs()
	{
		return $this->hasMany(DataKandang::class, 'id_kandang');
	}

	public function notification()
	{
		return $this->hasMany(Notification::class, 'id_kandang');
	}

	public function panens()
	{
		return $this->hasMany(Panen::class, 'id_kandang');
	}

	public function rekap_data()
	{
		return $this->hasMany(RekapDatum::class, 'id_kandang');
	}

	public function rekap_data_harian()
	{
		return $this->hasOne(RekapDataHarian::class, 'id_kandang');
	}

	public function sensors()
	{
		return $this->hasMany(Sensors::class, 'id_kandang');
	}
}
