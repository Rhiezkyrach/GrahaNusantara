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

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Traits\GetFrontEndSettingTrait;

class EpaperController extends Controller
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
    
    public function index(Epaper $epaper){

        return view('epaper', [
            'network_utama' => $this->network_utama,
            "judul" => 'ePaper Edisi '. Carbon::parse($epaper->edisi)->translatedFormat('l, d F Y') . " - " . $this->current_setting->judul_situs,
            "epaper" => $epaper,
            "prevEpaper" => Epaper::getPrevePaper($this->host, $epaper->edisi)->limit(5)->get(),
            'counter' => Epaper::where('id', $epaper->id)->increment('counter', 1),
            "foto" => $this->network_utama->url . '/storage/' . $epaper->cover,
            'navKategori' => Kategori::navKategori($this->current_network),
            'extraNavKategori' => Kategori::extraNavKategori($this->current_network),
            'headline' => Berita::headlines($this->current_network),
            "deskripsi" => $this->current_setting->deskripsi,
            "keyword" => "berita politik, video politik",
            "author" => $this->current_setting->judul_situs,
            'populer' => Berita::populer($this->current_network),
            "halstatis" => Statis::getStatis($this->current_network),
            "Network" => Network::showAllActiveNetwork(),
            'beritaNetwork' => Berita::beritaNetwork($this->current_network),
            
            //IKLAN
            "iklanHeader" => Iklan::showIklan($this->current_network, 'Header')->orderBy('created_at', 'desc')->first(),
            "iklanFooter" => Iklan::showIklan($this->current_network, 'Footer')->get(),
        ]);
    }
}
