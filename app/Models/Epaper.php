<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;

class Epaper extends Model
{
    use HasFactory, Sluggable;

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

    static public function showAllePaper(){
        $q = Epaper::orderBy('edisi', 'DESC')
                    ->orderBy('created_at', 'DESC');
                
        return $q;
    }

    static public function getPrevePaper($edisi){
        $q = Epaper::where('edisi', '<', $edisi)
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
