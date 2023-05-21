<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iklan extends Model
{
    use HasFactory;
    
    protected $table = 'tbl_iklan';
    protected $guarded = ['id'];

    static public function showIklan($posisi){
        $q = Iklan::where('status', 1)
                ->where('posisi', $posisi)
                ->where('jenis', '!=', 'Corong Rakyat')
                ->whereRaw('TIMESTAMP(awal_tayang) <= NOW()')
                ->whereRaw('TIMESTAMP(akhir_tayang) >= NOW()')
                ->orderBy('urutan', 'asc');
                
        return $q;
    }

    static public function showTypeIklan($jenis){
        $q = Iklan::where('status', 1)
                ->where('jenis', $jenis)
                ->whereRaw('TIMESTAMP(awal_tayang) <= NOW()')
                ->whereRaw('TIMESTAMP(akhir_tayang) >= NOW()')
                ->orderBy('urutan', 'asc');
                
        return $q;
    }
}
