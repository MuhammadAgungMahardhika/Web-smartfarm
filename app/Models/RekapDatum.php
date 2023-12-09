<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RekapDatum
 * 
 * @property int $id_rekap_data
 * @property int $id_kandang
 * @property Carbon $hari
 * @property int $rata_rata_amoniak
 * @property int $rata_rata_suhu
 * @property int $kelembapan
 * @property int $pakan
 * @property int $minum
 * @property int $jumlah_kematian
 * @property int $jumlah_kematian_harian
 * @property Carbon $created_at
 * @property int|null $created_by
 * @property Carbon $updated_at
 * @property int|null $updated_by
 * 
 * @property Kandang $kandang
 *
 * @package App\Models
 */
class RekapDatum extends Model
{
	protected $table = 'rekap_data';
	protected $primaryKey = 'id';

	protected $casts = [
		'id_kandang' => 'int',
		'hari_ke' => 'int',
		'date' => 'datetime:Y-m-d',
		'rata_rata_amoniak' => 'int',
		'rata_rata_suhu' => 'int',
		'kelembapan' => 'int',
		'pakan' => 'int',
		'minum' => 'int',
		'bobot' => 'int',
		'jumlah_kematian' => 'int',
		'jumlah_kematian_harian' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'id_kandang',
		'hari_ke',
		'date',
		'rata_rata_amoniak',
		'rata_rata_suhu',
		'kelembapan',
		'pakan',
		'minum',
		'bobot',
		'jumlah_kematian',
		'jumlah_kematian_harian',
		'created_by',
		'updated_by'
	];

	public function kandang()
	{
		return $this->belongsTo(Kandang::class, 'id_kandang');
	}
}
