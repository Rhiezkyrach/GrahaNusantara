<?php

namespace App\Traits;

use App\Models\Berita;
use App\Models\Network;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\NetworkAccess;

trait NetworkAccessTrait
{
    public function network_access(){
        $id_network = [];

        if(auth()->user()->level == 'owner'){
            $id_network = NetworkAccess::orderBy('id_network', 'asc')->pluck('id_network')->unique();
        }else{
            $id_network = NetworkAccess::where('id_user', auth()->user()->id)->orderBy('id_network', 'asc')->pluck('id_network')->unique();
        }

        return $id_network;
    }

    public function get_network(){
        return Network::where('status', '1')->whereIn('id_network', $this->network_access())->get();
    }

    public function list_tayang(){
        return Berita::where('publish', '0')->whereIn('id_network', $this->network_access())->count();
    }
}
