<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use App\Models\Berita;
use App\Models\Reporter;
use App\Models\Setting;

class DashboardController extends Controller
{
    public function index(){

        $setting = Setting::first();

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

        return view('admin.dashboard',[
            'judul' => 'Admin Dashboard' . ' - ' . $setting->judul_situs,
            'jumlahBerita' => Reporter::beritaWartawan($tanggal),
            'populer' => Berita::populer(),
            'salam' => $salam,
            'trends' => $trends,
            'setting' => $setting
        ]);
    }
}
