<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tapel extends Model
{
    use HasFactory;

    protected $table = 'tapel';
    protected $guarded = [];
    protected $keyType = 'string';
    protected $primaryKey = 'code';

    public $incrementing = false;
}
