<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;

    protected $table = 'presensi';

    protected $fillable = [
        'uuid',
        'user_id',
        'checked_at',
        'status_presensi_id',
        'location',
    ];

    protected $casts = [
        'checked_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function statusPresensi()
    {
        return $this->belongsTo(Status::class, 'status_presensi_id');
    }
}

