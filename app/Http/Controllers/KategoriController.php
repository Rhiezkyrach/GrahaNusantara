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
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Traits\GetFrontEndSettingTrait;


class KategoriController extends Controller
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
    

    public function kategori(Kategori $kategori, Request $request){
        $terkiniKanal =  Berita::kategoriTerkini($this->current_network)->where('id_kategori', $kategori->id)->paginate(20);

        //Category Ajax
        if ($request->ajax()) {
            return view('layouts.partials.category_ajax', [
                'network_utama' => $this->network_utama,
                'terkiniKanal' => $terkiniKanal,
            ])->render();
        }
        
        return view('category',[
            'network_utama' => $this->network_utama, 
            'judul' => 'Berita ' . $kategori->nama . ' - ' .  $this->current_setting->judul_situs,
            'deskripsi' => 'Berita ' . $kategori->nama . ' terkini',
            'keyword' => 'Berita ' . $kategori->nama . ' terkini',
            'author' =>  $this->current_setting->judul_situs,
            'foto' => $this->network_utama->url . '/storage/' . $this->current_setting->logo,
            'navKategori' => Kategori::navKategori($this->current_network),
            'extraNavKategori' => Kategori::extraNavKategori($this->current_network),
            'headline' => Berita::headlines($this->current_network),
            'hlkategori' => Berita::kategoriTerkini($this->current_network)->where('id_kategori', $kategori->id)->where('headline', 1)->limit(5)->get(),
            'kategori' => $terkiniKanal,
            'populer' => Berita::populer($this->current_network),
            'epaper' => Epaper::showAllePaper($this->current_network)->first(),
            "halstatis" => Statis::getStatis($this->current_network),
            "Network" => Network::showAllActiveNetwork(),
            'beritaNetwork' => Berita::beritaNetwork($this->current_network),
            
            //IKLAN
            "iklanHeader" => Iklan::showIklan($this->current_network, 'Header')->orderBy('created_at', 'desc')->first(),
            "iklanHeadline" => Iklan::showIklan($this->current_network, 'Headline')->get(),
            "iklanSidebarA" => Iklan::showIklan($this->current_network, 'Sidebar A')->get(),
            "iklanSidebarB" => Iklan::showIklan($this->current_network, 'Sidebar B')->get(),
            "iklanSidebarC" => Iklan::showIklan($this->current_network, 'Sidebar C')->get(),
            "iklanFooter" => Iklan::showIklan($this->current_network, 'Footer')->get(),
            "corongRakyat" => Iklan::showTypeIklan($this->current_network, 'Corong Rakyat')->first(),

        ]);
    }
}
