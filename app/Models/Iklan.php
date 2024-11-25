<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Iklan extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'tbl_iklan';
    protected $guarded = ['id'];

    // Eloquent Relations
    public function Network(){
        return $this->belongsTo(Network::class, 'id_network');
    }
    
    static public function showIklan($id_network, $posisi){
        $q = Iklan::where('status', 1)
                ->where('id_network', $id_network)
                ->where('posisi', $posisi)
                ->where('jenis', '!=', 'Corong Rakyat')
                ->whereRaw('TIMESTAMP(awal_tayang) <= NOW()')
                ->whereRaw('TIMESTAMP(akhir_tayang) >= NOW()')
                ->orderBy('urutan', 'asc');
                
        return $q;
    }

    static public function showTypeIklan($id_network, $jenis){
        $q = Iklan::where('status', 1)
                ->where('id_network', $id_network)
                ->where('jenis', $jenis)
                ->whereRaw('TIMESTAMP(awal_tayang) <= NOW()')
                ->whereRaw('TIMESTAMP(akhir_tayang) >= NOW()')
                ->orderBy('urutan', 'asc');
                
        return $q;
    }

    static public function getIklan($id_network)
    {
        $q = Iklan::where('status', 1)
                ->where('id_network', $id_network)
                ->orderBy('awal_tayang', 'DESC');

        return $q;
    }
}
