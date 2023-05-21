<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $table = 'tbl_setting';
    protected $guarded = ['id'];

    static public function getSetting(){
        $q = Setting::where('id', 1)
            ->first();

        return $q;
    }
}
