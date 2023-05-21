<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reporter extends Model
{
    use HasFactory;

    protected $table = 'tbl_wartawan';
    protected $primaryKey = 'id_wartawan';
    protected $guarded = ['id_wartawan'];
    public $timestamps = false;

    // Eloquent Relations
    public function berita(){
        return $this->hasMany(Berita::class, 'id_wartawan', 'id_wartawan');
    }

    static public function allWartawan(){
        $q = Reporter::where('status', 1)
                    ->orderBy('nama_wartawan', 'ASC')
                    ->get();
        
        return $q;
    }

    static public function showAllWartawan(){
        $q = Reporter::orderBy('status', 'DESC')
                    ->orderBy('nama_wartawan', 'ASC')
                    ->get();
        
        return $q;
    }

    public function hitung(){
        return $this->hasMany(Berita::class, 'id_wartawan', 'id_wartawan');
    }

    static public function beritaWartawan($tanggal) {
        $q = Reporter::whereHas('hitung', function ($query) use ($tanggal) {
                        $query->whereDate('tanggal_tayang', $tanggal);
                    })
                    ->withCount([
                        'hitung' => function ($query) use ($tanggal){
                            $query->whereDate('tanggal_tayang', $tanggal);
                        }
                    ])
                    ->orderBy('hitung_count', 'desc')
                    ->get();
        
        return $q;
    }
}
