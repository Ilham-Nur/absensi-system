<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Waktu extends Model
{
    use HasFactory;

    protected $fillable = ['status_id', 'starttime', 'endtime'];

    /**
     * Relasi ke model Status
     */
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
