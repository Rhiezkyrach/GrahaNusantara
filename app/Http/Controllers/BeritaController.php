<?php

namespace App\Http\Controllers;

use App\Models\Fokus;
use App\Models\Iklan;
use App\Models\Berita;
use App\Models\Epaper;
use App\Models\Galeri;

use App\Models\Statis;
use App\Models\Network;
use App\Models\Setting;
use App\Models\Visitor;
use App\Models\Kategori;
use App\Enum\MyNetworkID;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Traits\GetFrontEndSettingTrait;

class BeritaController extends Controller
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

    public function home(Request $request)
    {

        //Home Ajax
        if ($request->ajax()) {
            $terkini =  Berita::terkini($this->current_network)->paginate(10);
            return view('layouts.partials.home_ajax', [
                'network_utama' => $this->network_utama,
                'terkini' => $terkini,
            ])->render();
        }

        return view('home', [
            'network_utama' => $this->network_utama,
            'judul' => $this->current_setting->judul_situs . ' - ' . $this->current_setting->tagline,
            'deskripsi' => $this->current_setting->deskripsi,
            'keyword' => $this->current_setting->keyword,
            'author' => $this->current_setting->judul_situs,
            'foto' => $this->network_utama->url . '/storage/' . $this->current_setting->logo,
            'navKategori' => Kategori::navKategori($this->current_network),
            'extraNavKategori' => Kategori::extraNavKategori($this->current_network),
            'headline' => Berita::headlines($this->current_network),
            'terkini' => Berita::terkini($this->current_network)->paginate(10),
            'trending' => Berita::trending($this->current_network),
            'populer' => Berita::populer($this->current_network),
            'epaper' => Epaper::showAllePaper($this->current_network)->first(),
            "halstatis" => Statis::getStatis($this->current_network),
            "Network" => Network::showAllActiveNetwork(),
            'Galeri' => Berita::beranda($this->current_network, 'Galeri')->limit(2)->get(),
            'Opini' => Berita::beranda($this->current_network, 'Opini')->limit(3)->get(),
            'beritaNetwork' => Berita::beritaNetwork($this->current_network),

            // KATEGORI
            'Kategori' => Kategori::with(['berita' => function ($query) {
                $query->where('id_network', $this->current_network);
            }])->where('id_network', $this->current_network)
                ->whereNotIn('nama', ['Galeri', 'Opini'])
                ->where('status', '1')->orderBy('urutan', 'asc')
                ->get(),

            // FOKUS
            'Fokus' =>  Fokus::with(['berita' => function ($query) {
                $query->where('id_network', $this->current_network);
            }])->where('id_network', $this->current_network)->where('status', '1')->orderBy('urutan', 'asc')->get(),

            //IKLAN
            "iklanHeader" => Iklan::showIklan($this->current_network, 'Header')->orderBy('created_at', 'desc')->first(),
            "iklanHeadline" => Iklan::showIklan($this->current_network, 'Headline')->get(),
            "iklanHomeA" => Iklan::showIklan($this->current_network, 'Home A')->get(),
            "iklanHomeB" => Iklan::showIklan($this->current_network, 'Home B')->get(),
            "iklanHomeC" => Iklan::showIklan($this->current_network, 'Home C')->get(),
            "iklanSidebarA" => Iklan::showIklan($this->current_network, 'Sidebar A')->get(),
            "iklanSidebarB" => Iklan::showIklan($this->current_network, 'Sidebar B')->get(),
            "iklanSidebarC" => Iklan::showIklan($this->current_network, 'Sidebar C')->get(),
            "iklanFooter" => Iklan::showIklan($this->current_network, 'Footer')->get(),
            "corongRakyat" => Iklan::showTypeIklan($this->current_network, 'Corong Rakyat')->first(),

        ]);
    }

    public function detail(Request $request, Berita $berita)
    {

        $paragraphs = explode('</p>', $berita->isi);
        $deskripsi = html_entity_decode(strip_tags($paragraphs[0]));

        $tags = explode(',', $berita->tag);
        $terkait = Berita::terkait($this->current_network)->filter($tags)->where('id_berita', '!=', $berita->id_berita)->limit(6)->get();
        $sisa = 6 - $terkait->count();
        $terkaitkanal = Berita::terkait($this->current_network)->where('id_kategori', $berita->id_kategori)->where('id_berita', '!=', $berita->id_berita)->limit($sisa)->get();

        // Visitor
        if(!Auth::check()) {
            $visitor = Visitor::getTodayVisitor($this->current_network);
            if ($visitor) {
                $visitor->increment('counter', 1);
            } else {
                Visitor::create([
                    'id_network' => $this->current_network,
                    'tanggal' => Carbon::now(),
                    'counter' => 1
                ]);
            }
        }

        return view('detail', [
            'network_utama' => $this->network_utama,
            'navKategori' => Kategori::navKategori($this->current_network),
            'extraNavKategori' => Kategori::extraNavKategori($this->current_network),
            'headline' => Berita::headlines($this->current_network),
            'berita' => $berita,
            'counter' => Berita::where('id_berita', $berita->id_berita)->increment('counter', 1),
            'berita_prev' => Berita::beritaPrev($this->current_network, $berita->id_berita),
            'berita_next' => Berita::beritaNext($this->current_network, $berita->id_berita),
            'galeri' => Galeri::where('id_berita', $berita->id_berita)->get(),
            'terkini' => Berita::terkini($this->current_network)->limit(5)->get(),
            'populer' => Berita::populer($this->current_network),
            'epaper' => Epaper::showAllePaper($this->current_network)->first(),
            'terkait' => $terkait,
            // "setting" => $setting,
            "halstatis" => Statis::getStatis($this->current_network),
            'terkaitkanal' => $terkaitkanal,
            "Network" => Network::showAllActiveNetwork(),
            'beritaNetwork' => Berita::beritaNetwork($this->current_network),

            //IKLAN
            "iklanHeader" => Iklan::showIklan($this->current_network, 'Header')->orderBy('created_at', 'desc')->first(),
            "iklanNewsA" => Iklan::showIklan($this->current_network, 'News A')->get(),
            "iklanNewsB" => Iklan::showIklan($this->current_network, 'News B')->get(),
            "iklanNewsC" => Iklan::showIklan($this->current_network, 'News C')->get(),
            "iklanSidebarA" => Iklan::showIklan($this->current_network, 'Sidebar A')->get(),
            "iklanSidebarB" => Iklan::showIklan($this->current_network, 'Sidebar B')->get(),
            "iklanSidebarC" => Iklan::showIklan($this->current_network, 'Sidebar C')->get(),
            "iklanFooter" => Iklan::showIklan($this->current_network, 'Footer')->get(),
            "corongRakyat" => Iklan::showTypeIklan($this->current_network, 'Corong Rakyat')->first(),
        ]);
    }

    public function search(Request $request)
    {

        $filter = '';
        if (request(['cari'])) {
            $filter = request(['cari']);
            $data = Str::title($filter['cari']);
        } elseif (request(['tag'])) {
            $filter = request(['tag']);
            $data = Str::title($filter['tag']);
        }

        if ($filter == null || !isset($request)) {
            $terkini = Berita::terkini($this->current_network)->limit(10)->get();
            $judul = 'Berita Terkini ' . $this->current_setting->judul_situs;
        } else {
            $terkini = Berita::terkini($this->current_network)->filter($filter)->limit(10)->get();
            $judul = 'Berita ' . $data . ' - ' . $this->current_setting->judul_situs;
        }

        return view('search', [
            'network_utama' => $this->network_utama,
            'judul' => $judul,
            'deskripsi' => $this->current_setting->deskripsi,
            'keyword' => $this->current_setting->keyword,
            'author' => $this->current_setting->judul_situs,
            'foto' => $this->network_utama->url . '/storage/' . $this->current_setting->logo,
            'navKategori' => Kategori::navKategori($this->current_network),
            'extraNavKategori' => Kategori::extraNavKategori($this->current_network),
            'headline' => Berita::headlines($this->current_network),
            'populer' => Berita::populer($this->current_network),
            'epaper' => Epaper::showAllePaper($this->current_network)->first(),
            'terkini' => $terkini,
            "halstatis" => Statis::getStatis($this->current_network),
            "Network" => Network::showAllActiveNetwork(),
            'beritaNetwork' => Berita::beritaNetwork($this->current_network),

            //IKLAN
            "iklanHeader" => Iklan::showIklan($this->current_network, 'Header')->orderBy('created_at', 'desc')->first(),
            "iklanHomeA" => Iklan::showIklan($this->current_network, 'Home A')->get(),
            "iklanSidebarA" => Iklan::showIklan($this->current_network, 'Sidebar A')->get(),
            "iklanSidebarB" => Iklan::showIklan($this->current_network, 'Sidebar B')->get(),
            "iklanSidebarC" => Iklan::showIklan($this->current_network, 'Sidebar C')->get(),
            "iklanFooter" => Iklan::showIklan($this->current_network, 'Footer')->get(),
            "corongRakyat" => Iklan::showTypeIklan($this->current_network, 'Corong Rakyat')->first(),
        ]);
    }

    public function indeks(Request $request)
    {
        $tanggal = Carbon::now()->translatedFormat('Y-m-d');

        return view('indeks', [
            'network_utama' => $this->network_utama,
            'judul' => 'Indeks Berita - ' . $this->current_setting->judul_situs,
            'deskripsi' => $this->current_setting->deskripsi,
            'keyword' => $this->current_setting->keyword,
            'author' => $this->current_setting->judul_situs,
            'foto' => $this->network_utama->url . '/storage/' . $this->current_setting->logo,
            'navKategori' => Kategori::navKategori($this->current_network),
            'extraNavKategori' => Kategori::extraNavKategori($this->current_network),
            'headline' => Berita::headlines($this->current_network),
            'indeks' => Berita::indeks($this->current_network, $tanggal)->get(),
            'populer' => Berita::populer($this->current_network),
            'epaper' => Epaper::showAllePaper($this->current_network)->first(),
            "halstatis" => Statis::getStatis($this->current_network),
            "Network" => Network::showAllActiveNetwork(),
            'beritaNetwork' => Berita::beritaNetwork($this->current_network),

            //IKLAN
            "iklanHeader" => Iklan::showIklan($this->current_network, 'Header')->orderBy('created_at', 'desc')->first(),
            "iklanHomeA" => Iklan::showIklan($this->current_network, 'Home A')->get(),
            "iklanSidebarA" => Iklan::showIklan($this->current_network, 'Sidebar A')->get(),
            "iklanSidebarB" => Iklan::showIklan($this->current_network, 'Sidebar B')->get(),
            "iklanSidebarC" => Iklan::showIklan($this->current_network, 'Sidebar C')->get(),
            "iklanFooter" => Iklan::showIklan($this->current_network, 'Footer')->get(),
            "corongRakyat" => Iklan::showTypeIklan($this->current_network, 'Corong Rakyat')->first(),
        ]);
    }

    public function indeksFilter(Request $request)
    {
        $tanggal = $request->input('tanggal');

        return view('indeks_filter', [
            'network_utama' => $this->network_utama,
            'judul' => 'Indeks Berita - ' . $this->current_setting->judul_situs,
            'deskripsi' => $this->current_setting->deskripsi,
            'keyword' => $this->current_setting->keyword,
            'author' => $this->current_setting->judul_situs,
            'foto' => $this->network_utama->url . '/storage/' . $this->current_setting->logo,
            'navKategori' => Kategori::navKategori($this->current_network),
            'extraNavKategori' => Kategori::extraNavKategori($this->current_network),
            'headline' => Berita::headlines($this->current_network),
            'indeks' => Berita::indeks($this->current_network, $tanggal)->get(),
            'epaper' => Epaper::showAllePaper($this->current_network)->first(),
            'tanggal' => $tanggal,
            'populer' => Berita::populer($this->current_network),
            "halstatis" => Statis::getStatis($this->current_network),
            "Network" => Network::showAllActiveNetwork(),
            'beritaNetwork' => Berita::beritaNetwork($this->current_network),

            //IKLAN
            "iklanHeader" => Iklan::showIklan($this->current_network, 'Header')->orderBy('created_at', 'desc')->first(),
            "iklanHomeA" => Iklan::showIklan($this->current_network, 'Home A')->get(),
            "iklanSidebarA" => Iklan::showIklan($this->current_network, 'Sidebar A')->get(),
            "iklanSidebarB" => Iklan::showIklan($this->current_network, 'Sidebar B')->get(),
            "iklanSidebarC" => Iklan::showIklan($this->current_network, 'Sidebar C')->get(),
            "iklanFooter" => Iklan::showIklan($this->current_network, 'Footer')->get(),
            "corongRakyat" => Iklan::showTypeIklan($this->current_network, 'Corong Rakyat')->first(),
        ]);
    }
}
