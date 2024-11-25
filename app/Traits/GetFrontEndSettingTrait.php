<?php

namespace App\Traits;

use App\Models\Berita;
use App\Models\Network;
use App\Models\Setting;
use App\Enum\MyNetworkID;
use Illuminate\Http\Request;
use App\Models\NetworkAccess;

trait GetFrontEndSettingTrait
{
    public function get_network_setting()
    {
        return Setting::where('id_network', MyNetworkID::ID->value)->first();
    }
}
