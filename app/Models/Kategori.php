<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;


class Kategori extends Model
{
    use HasFactory, Sluggable;

    protected $table = 'tbl_channel';
    protected $guarded = ['id'];
    public $timestamps = false;

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

    public function berita(){
        return $this->hasMany(Berita::class, 'id_channel');
    }

    static public function allKategori(){
        $q =  Kategori::where('status', 1)
                        ->orderBy('nama', 'ASC')
                        ->get();
        
        return $q;
    }

    static public function navKategori(){
        $q =  Kategori::where('status', 1)
                        ->where('navigasi', 1)
                        ->where('urutan', '!=' , 10)
                        ->orderBy('urutan', 'ASC')
                        ->get();
        
        return $q;
    }

    static public function extraNavKategori(){
        $q =  Kategori::where('status', 1)
                        ->where('navigasi', 1)
                        ->where('urutan', '=' , 10)
                        ->get();
        
        return $q;
    }

    //BE Model
    static public function showallKategori(){
        $q =  Kategori::orderBy('status', 'DESC')
                        ->orderBy('urutan', 'DESC')
                        ->orderBy('navigasi', 'DESC')
                        ->get();
        
        return $q;
    }
}
