<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Struktur extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tbl_struktur';
    protected $guarded = ['id'];

    //Eloquent Relations
    public function Network(){
        return $this->belongsTo(Network::class, 'id_network', 'id_network');
    }

    public function User(){
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
