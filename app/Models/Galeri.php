<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    use HasFactory;

    protected $table = 'tbl_gallery';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function berita(){
        return $this->belongsTo(Berita::class, 'id_berita');
    }

}
