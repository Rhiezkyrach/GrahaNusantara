<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Statis extends Model
{
    use HasFactory, Sluggable, SoftDeletes;

    protected $table = 'tbl_statis';
    protected $primaryKey = 'id_statis';
    protected $guarded = ['id_statis'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'judul'
            ]
        ];
    }

    // Eloquent Relations
    public function Network(){
        return $this->belongsTo(Network::class, 'id_network');
    }

    static public function getStatis($id_network){
        $q = Statis::where('id_network', $id_network)
                    ->orderBy('urutan', 'asc')
                    ->get();

        return $q;
    }

    static public function showStatis($id_network){
        $q = Statis::where('id_network', $id_network)
                    ->orderBy('urutan', 'asc')
                    ->get();

        return $q;
    }
}
