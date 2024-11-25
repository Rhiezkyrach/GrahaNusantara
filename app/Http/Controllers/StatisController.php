<?php

namespace App\Http\Controllers;

use App\Models\Iklan;
use App\Models\Berita;
use App\Models\Epaper;
use App\Models\Statis;
use App\Models\Network;
use App\Models\Setting;
use App\Models\Kategori;

use App\Enum\MyNetworkID;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\GetFrontEndSettingTrait;


class StatisController extends Controller
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

    public function index(Statis $statis){

        return view('statis', [
            'network_utama' => $this->network_utama,
            "judul" => $statis->judul . " - " . $this->current_setting->judul_situs,
            "statis" => $statis,
            "foto" => $this->network_utama->url . '/storage/' . $this->current_setting->logo,
            "deskripsi" => $this->current_setting->deskripsi,
            "keyword" => "berita politik, video politik",
            "author" => $this->current_setting->judul_situs,
            'navKategori' => Kategori::navKategori($this->current_network),
            'extraNavKategori' => Kategori::extraNavKategori($this->current_network),
            'headline' => Berita::headlines($this->current_network),
            'populer' => Berita::populer($this->current_network),
            'epaper' => Epaper::showAllePaper($this->current_network)->first(),
            "halstatis" => Statis::getStatis($this->current_network),
            "Network" => Network::showAllActiveNetwork(),
            'beritaNetwork' => Berita::beritaNetwork($this->current_network),
            
            //IKLAN
            "iklanHeader" => Iklan::showIklan($this->current_network, 'Header')->orderBy('created_at', 'desc')->first(),
            "iklanSidebarA" => Iklan::showIklan($this->current_network, 'Sidebar A')->get(),
            "iklanSidebarB" => Iklan::showIklan($this->current_network, 'Sidebar B')->get(),
            "iklanSidebarC" => Iklan::showIklan($this->current_network, 'Sidebar C')->get(),
            "iklanFooter" => Iklan::showIklan($this->current_network, 'Footer')->get(),
            "corongRakyat" => Iklan::showTypeIklan($this->current_network, 'Corong Rakyat')->first(),
        ]);
    }
}
