<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Guru;

class Prodi extends Model
{
    use HasFactory;

    protected $table = 'prodi';
    protected $guarded = [];
    protected $keyType = 'string';
    protected $primaryKey = 'code';

    public $incrementing = false;

    public function ketua(): BelongsTo
    {
        return $this->belongsTo(Guru::class,'guru_code');
    }
}
