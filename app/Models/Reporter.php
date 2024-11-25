<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reporter extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tbl_wartawan';
    protected $primaryKey = 'id_wartawan';
    protected $guarded = ['id_wartawan'];

    // Eloquent Relations
    public function Berita(){
        return $this->hasMany(Berita::class, 'id_wartawan', 'id_wartawan');
    }

    public function User(){
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function Network(){
        return $this->belongsTo(Network::class, 'id_network');
    }

    static public function showWartawan($id_network)
    {
        $q = Reporter::where('id_network', $id_network)
                    ->orderBy('nama_wartawan', 'asc');

        return $q;
    }

    static public function allWartawan($id_network){
        $q = Reporter::where('status', 1)
                    ->where('id_network', $id_network)
                    ->orderBy('nama_wartawan', 'ASC')
                    ->get();
        
        return $q;
    }

    static public function showAllWartawan($id_network){
        $q = Reporter::orderBy('status', 'DESC')
                    ->where('id_network', $id_network)
                    ->orderBy('nama_wartawan', 'ASC')
                    ->get();
        
        return $q;
    }

    public function hitung(){
        return $this->hasMany(Berita::class, 'id_wartawan', 'id_wartawan');
    }

    static public function beritaWartawan($id_network, $tanggal) {
        $q = Reporter::whereHas('hitung', function ($query) use ($tanggal) {
                        $query->whereDate('tanggal_tayang', $tanggal);
                    })
                    ->withCount([
                        'hitung' => function ($query) use ($tanggal){
                            $query->whereDate('tanggal_tayang', $tanggal);
                        }
                    ])
                    ->where('id_network', $id_network)
                    ->orderBy('hitung_count', 'desc')
                    ->get();
        
        return $q;
    }
}
