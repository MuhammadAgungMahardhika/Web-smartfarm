<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DataKandang
 * 
 * @property int $id_data_kandang
 * @property int $id_kandang
 * @property int $hari_ke
 * @property int $pakan
 * @property int $bobot
 * @property int $minum
 * @property Carbon $date
 * @property string $classification
 * @property Carbon $created_at
 * @property int|null $created_by
 * @property Carbon $updated_at
 * @property int|null $updated_by
 * 
 * @property Kandang $kandang
 * @property Collection|DataKematian[] $data_kematians
 *
 * @package App\Models
 */
class DataKandang extends Model
{
	protected $table = 'data_kandang';
	protected $primaryKey = 'id';

	protected $casts = [
		'id_kandang' => 'int',
		'hari_ke' => 'int',
		'pakan' => 'int',
		'minum' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'id_kandang',
		'hari_ke',
		'pakan',
		'minum',
		'date',
		'classification',
		'created_by',
		'updated_by'
	];

	public function kandang()
	{
		return $this->belongsTo(Kandang::class, 'id_kandang');
	}

	public function data_kematians()
	{
		return $this->hasMany(DataKematian::class, 'id_data_kandang');
	}
}
