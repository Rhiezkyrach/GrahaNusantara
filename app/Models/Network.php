<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Network extends Model
{
    use HasFactory, Sluggable;

    protected $table = 'tbl_network';
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

    static public function showAllNetwork(){
        $q = Network::orderBy('urutan', 'ASC');
                
        return $q;
    }
}
