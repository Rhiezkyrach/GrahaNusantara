<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Fokus extends Model
{
    use HasFactory, Sluggable, SoftDeletes;

    protected $table = 'tbl_fokus';
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
        return $this->hasMany(Berita::class, 'id_fokus')->orderBy('tanggal_tayang', 'desc')->orderBy('waktu', 'desc');
    }

    public function Network(){
        return $this->belongsTo(Network::class, 'id_network');
    }

    static public function allFokus($id_network){
        $q =  Fokus::where('status', 1)
                        ->where('id_network', $id_network)
                        ->orderBy('nama', 'ASC')
                        ->get();
        
        return $q;
    }

    //BE Model
    static public function showFokus($id_network){
        $q =  Fokus::where('id_network', $id_network)
                        ->orderBy('status', 'DESC')
                        ->orderBy('urutan', 'DESC');
        
        return $q;
    }
}
