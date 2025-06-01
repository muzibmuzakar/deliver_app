<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    protected $guarded = [];

    public function kurir()
    {
        return $this->belongsTo(User::class, 'kurir_id');
    }

    public function seksi()
    {
        return $this->belongsTo(Seksi::class, 'seksi_id');
    }

    public function getStatusTextAttribute()
    {
        return match ($this->status) {
            0 => $this->kurir->name . ' Sudah Ditugaskan',
            1 => 'Sedang Dikirim',
            2 => 'Sudah Sampai',
            default => 'Tidak Diketahui',
        };
    }
}
