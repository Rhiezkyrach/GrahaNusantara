<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Epaper extends Model
{
    use HasFactory, Sluggable, SoftDeletes;

    protected $table = 'tbl_epapers';
    protected $guarded = ['id'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'edisi'
            ]
        ];
    }

    // Eloquent Relations
    public function Network(){
        return $this->belongsTo(Network::class, 'id_network');
    }

    static public function showAllePaper($id_network){
        $q = Epaper::orderBy('edisi', 'DESC')
                    ->orderBy('created_at', 'DESC');
                
        return $q;
    }

    static public function getPrevePaper($id_network, $edisi){
        $q = Epaper::where('edisi', '<', $edisi)
                    ->where('id_network', $id_network)
                    ->where('edisi', '>', Carbon::now()->subDay(7))
                    ->orderBy('edisi', 'DESC');
                
        return $q;
    }

    public function scopeFilterePaper($query, array $filters){
        $query->when($filters['cari'] ?? false, function($query, $cari){
            return $query->where('edisi', $cari);
        });

    }
}
