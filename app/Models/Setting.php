<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'tbl_setting';
    protected $guarded = ['id'];

    //Eloquent Relations
    public function Network(){
        return $this->belongsTo(Network::class, 'id_network', 'id_network');
    }

    static public function getSetting($id_network){
        $q = Setting::where('id_network', $id_network)
                    ->first();

        return $q;
    }
}
