<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Statis;
use App\Models\Network;
use App\Models\Setting;
use App\Models\Kategori;
use App\Enum\MyNetworkID;
use Illuminate\Http\Request;
use App\Traits\GetFrontEndSettingTrait;

class SitemapController extends Controller
{
    use GetFrontEndSettingTrait;
    
    public $host;
    public $network_utama;
    public $current_setting;
    public $current_network;

    public function __construct(Request $request)
    {
        $this->host = $request->getHost();
        $this->network_utama = Network::where('id_network', '001')->first();
        $this->current_network = MyNetworkID::ID->value;
        $this->current_setting = $this->get_network_setting();
    }
    
    public function index(){
        $network_utama = Network::where('id_network', '001')->first();
        return response()->view('sitemap', [
            'network_utama' => $network_utama,
            'berita' => Berita::terkini($this->current_network)->limit(500)->get(),
            'setting' =>  $this->current_setting,
            'statis' => Statis::getStatis($this->current_network)
        ])->header('Content-Type', 'text/xml');
    }

    public function feed(){
        $network_utama = Network::where('id_network', '001')->first();
        return response()->view('feedberita', [
            'network_utama' => $network_utama,
            'berita' => Berita::terkini($this->current_network)->limit(50)->get(),
            'setting' => $this->current_setting
        ])->header('Content-Type', 'application/xml');
    }

    public function feedkanal(Kategori $kategori){
        $network_utama = Network::where('id_network', '001')->first();
        $terkiniKanal =  Berita::kategoriTerkini($this->current_network)->where('id_kategori', $kategori->id)->limit(100)->get();

        return response()->view('feedberita', [
            'network_utama' => $network_utama,
            'berita' => $terkiniKanal,
            'setting' => $this->current_setting
        ])->header('Content-Type', 'application/xml');
    }

    public function sitemapKanal(Kategori $kategori){
        $network_utama = Network::where('id_network', '001')->first();
        $terkiniKanal =  Berita::kategoriTerkini($this->current_network)->where('id_kategori', $kategori->id)->limit(100)->get();

        return response()->view('sitemap', [
            'network_utama' => $network_utama,
            'berita' => $terkiniKanal,
            'setting' => $this->current_setting,
            'statis' => Statis::getStatis($this->current_network)
        ])->header('Content-Type', 'text/xml');
    }
}
