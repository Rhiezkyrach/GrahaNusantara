<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Network extends Model
{
    use HasFactory, Sluggable, SoftDeletes;

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

    //Eloquent Relations
    public function Setting(){
        return $this->belongsTo(Setting::class,'id_network', 'id_network');
    }

    public function NetworkAccess(){
        return $this->hasMany(NetworkAccess::class, 'id_network', 'id_network');
    }

    static public function showAllNetwork(){
        $q = Network::orderBy('id_network', 'DESC');
                
        return $q;
    }

    static public function showAllActiveNetwork(){
        $q = Network::where('status', '1')->orderBy('id_network', 'ASC')->get();
                
        return $q;
    }
}
