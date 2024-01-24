<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'master_barang';
    protected $primaryKey = 'kode_barang';
    protected $guarded = [''];
    public $timestamps = false;
}