<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Visitor extends Model
{
    use HasFactory;

    protected $table = 'tbl_visitor';
    protected $guarded = ['id'];

    static public function getTodayVisitor($id_network)
    {
        $q = Visitor::where('id_network', $id_network)
                    ->whereDate('tanggal', Carbon::now())
                    ->first();

        return $q;
    }
}
