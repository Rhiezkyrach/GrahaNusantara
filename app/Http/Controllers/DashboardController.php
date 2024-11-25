<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Setting;

use App\Models\Visitor;
use App\Models\Reporter;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Traits\NetworkAccessTrait;

class DashboardController extends Controller
{
    use NetworkAccessTrait;
    
    public $setting;
    public $user_network;

    public function __construct()
    {
        $this->setting = Setting::where('id_network', auth()->user()->id_network)->first();
        $this->user_network = auth()->user()->id_network;
    }

    public function index(){
        // Salam
        $jam = date('G');
        $salam = '';
        if ( $jam >= 4 && $jam <= 10 ) {
            $salam = '<i class="fa-solid fa-cloud-sun"></i> Selamat Pagi';
        } else if ( $jam >= 11 && $jam <= 15 ) {
            $salam = '<i class="fa-solid fa-sun"></i> Selamat Siang';
        } else if ( $jam >= 16 && $jam <= 18 ) {
            $salam = '<i class="fa-solid fa-cloud-sun"></i> Selamat Sore';
        } else if ( $jam >= 19 || $jam <= 3 ) {
            $salam = '<i class="fa-solid fa-cloud-moon"></i> Selamat Malam';
        }

        $tanggal = Carbon::now()->translatedFormat('Y-m-d');

        //Google Trends
        $req="https://trends.google.co.id/trends/trendingsearches/daily/rss?geo=ID";
        $temp=file_get_contents($req);
        $trends=simplexml_load_string($temp);

        // Chart Data
        $visitor_daily = [];
        $visitor_monthly = [];
        $hari = [];
        for ($i = 0; $i < 7; $i++) {
            // $counter = Berita::whereDate('created_at', Carbon::today()->subDays(6 - $i))->sum('counter');
            $counter = Visitor::where('id_network', $this->user_network)->whereDate('tanggal', Carbon::today()->subDays(6 - $i))->sum('counter');
            array_push($visitor_daily, (int)$counter);

            $getDay = Carbon::today()->subDays(6 - $i)->translatedFormat('d M');
            array_push($hari, $getDay);
        }

        for ($i = 1; $i <= 12; $i++) {
            // $counter = Berita::whereMonth('created_at', $i)->whereYear('created_at', Carbon::now()->translatedFormat('Y'))->sum('counter');
            $counter = Visitor::where('id_network', $this->user_network)->whereMonth('tanggal', $i)->whereYear('created_at', Carbon::now()->translatedFormat('Y'))->sum('counter');
            array_push($visitor_monthly, (int)$counter);
        }   

        return view('admin.dashboard',[
            'judul' => 'Admin Dashboard' . ' - ' . $this->setting->judul_situs,
            'jumlahBerita' => Reporter::beritaWartawan($this->user_network, $tanggal),
            'populer' => Berita::populer($this->user_network),
            'salam' => $salam,
            'trends' => $trends,
            'visitor_daily' => json_encode($visitor_daily),
            'visitor_monthly' => json_encode($visitor_monthly),
            'hari' => json_encode($hari),
            'setting' => $this->setting,
            'list_tayang' => $this->list_tayang(),
            'id_setting' => $this->setting->id
        ]);
    }
}
