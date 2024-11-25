<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Galeri extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tbl_gallery';
    protected $guarded = ['id'];

    //Eloquent Relations
    public function berita(){
        return $this->belongsTo(Berita::class, 'id_berita');
    }

    public function Network()
    {
        return $this->belongsTo(Network::class, 'id_network');
    }

}
