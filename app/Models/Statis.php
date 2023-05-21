<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Statis extends Model
{
    use HasFactory, Sluggable;

    protected $table = 'tbl_statis';
    protected $primaryKey = 'id_statis';
    protected $guarded = ['id_statis'];
    public $timestamps = false;

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

    static public function getStatis(){
        $q = Statis::orderBy('urutan', 'ASC')
                    ->get();

        return $q;
    }
}
