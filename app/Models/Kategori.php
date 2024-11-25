<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Kategori extends Model
{
    use HasFactory, Sluggable, SoftDeletes;

    protected $table = 'tbl_kategori';
    protected $guarded = ['id'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'nama'
            ]
        ];
    }

    //Eloquent Relations
    public function Berita(){
        return $this->hasMany(Berita::class, 'id_kategori')->orderBy('tanggal_tayang', 'desc')->orderBy('waktu', 'desc');
    }

    public function Network(){
        return $this->belongsTo(Network::class, 'id_network');
    }

    static public function allKategori($id_network){
        $q =  Kategori::where('status', 1)
                        ->where('id_network', $id_network)
                        ->orderBy('nama', 'ASC')
                        ->get();
        
        return $q;
    }

    static public function navKategori($id_network){
        $q =  Kategori::where('status', 1)
                        ->where('id_network', $id_network)
                        ->where('navigasi', 1)
                        ->where('urutan', '!=' , 10)
                        ->orderBy('urutan', 'ASC')
                        ->get();
        
        return $q;
    }

    static public function extraNavKategori($id_network){
        $q =  Kategori::where('status', 1)
                        ->where('id_network', $id_network)
                        ->where('navigasi', 1)
                        ->where('urutan', '=' , 10)
                        ->get();
        
        return $q;
    }

    //BE Model
    static public function showKategori($id_network){
        $q =  Kategori::where('id_network', $id_network)
                        ->orderBy('status', 'DESC')
                        ->orderBy('urutan', 'DESC')
                        ->orderBy('navigasi', 'DESC');
        
        return $q;
    }
}
