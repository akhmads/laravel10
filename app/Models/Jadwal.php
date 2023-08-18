<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Tapel;
use App\Models\Jadwal;
use App\Models\Matpel;
use App\Models\Guru;
use App\Models\Ruangan;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwal';
    protected $guarded = [];

    public function tapel(): BelongsTo
    {
        return $this->belongsTo(Tapel::class,'tapel_code','code');
    }

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Jadwal::class,'kelas_code','code');
    }

    public function matpel(): BelongsTo
    {
        return $this->belongsTo(Matpel::class,'matpel_code','code');
    }

    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class,'guru_code','code');
    }

    public function ruangan(): BelongsTo
    {
        return $this->belongsTo(Ruangan::class,'ruangan_code','code');
    }
}
