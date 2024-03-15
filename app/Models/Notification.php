<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notification';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $casts = [
        'id_kandang' => 'int',
        'pesan' => 'string',
        'waktu' => 'datetime',
    ];

    protected $fillable = [
        'id_kandang',
        'pesan',
        'waktu',
    ];

    public function kandang()
    {
        return $this->belongsTo(Kandang::class, 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, "id");
    }
}
