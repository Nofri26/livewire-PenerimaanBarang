<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penerima extends Model
{
    protected $table = 'penerima';
    public $timestamps = false;
    protected $fillable = [
        'nama_pengirim',
        'no_penerima',
        'invoice',
        'total_berat_real',
        'total_berat_kotor',
        'berat_timbangan',
        'berat_selisih',
        'tanggal',
        'catatan',
        'supplier_id',
        'user_id',
        'pembayaran_id',
    ];

    public static function generateNomorPenerima()
    {
        $latestNomorPenerima = static::latest('no_penerima')->first();

        if ($latestNomorPenerima) {
            $lastNumber = intval(substr($latestNomorPenerima->no_penerima, 3));
            $newNumber = $lastNumber + 1;
            $newNomorPenerima = 'PO-' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
        } else {
            $newNomorPenerima = 'PO-00001';
        }

        return $newNomorPenerima;
    }
}
