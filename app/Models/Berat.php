<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berat extends Model
{
    use HasFactory;
    protected $table = 'berat';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'berat_real',
        'berat_kotor',
        'penerima_id',
        'karat_id',
    ];
}
