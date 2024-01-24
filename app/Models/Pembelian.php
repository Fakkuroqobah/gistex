<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    protected $table = 'pembelian_barang';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function barang()
    {
        return $this->belongsTo('App\Models\Barang', 'kode_barang', 'kode_barang');
    }
}