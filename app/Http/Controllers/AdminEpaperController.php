<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Epaper;

use App\Models\Setting;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\NetworkAccessTrait;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Intervention\Image\ImageManager as Image;

class AdminEpaperController extends Controller
{
    use NetworkAccessTrait;

    public $setting;
    public $user_network;

    public function __construct()
    {
        $this->setting = Setting::where('id_network', auth()->user()->id_network)->first();
        $this->user_network = auth()->user()->id_network;
    }

    // Index
    public function index(Request $request)
    {
        if (session()->has('success')) {
            Alert::toast(session('success'), 'success');
        }

        if (session()->has('error')) {
            Alert::toast(session('error'), 'error');
        }

        $data = Epaper::showAllePaper($this->user_network);

        if ($request->ajax()) {
            return datatables()->of($data)
                ->editColumn('id_network', function (Epaper $epaper) {
                    return $epaper->Network ? $epaper->Network->nama : $epaper->id_network;
                })
                ->editColumn('tanggal_tayang', function (Epaper $epaper) {
                    return Carbon::parse($epaper->edisi)->translatedFormat('d F Y');
                })
                ->addColumn('link', function (Epaper $epaper) {
                    return '<input class="w-40 px-1 py-0.5 border border-gray-600 rounded" value="' . url('epaper/' . $epaper->slug) . '"/>';
                })
                ->addColumn('action', function (Epaper $epaper) {
                    return view('admin.epaper.epaper-action', ['data' => $epaper])->render();
                })
                ->rawColumns(['action', 'headline', 'publish', 'link'])
                ->toJson();
        };

        return view('admin.epaper.epaper',[
            "judul" => 'Management ePaper' . ' - ' . $this->setting->judul_situs,
            'list_tayang' => $this->list_tayang(),
            'id_setting' => $this->setting->id,
            'setting' => $this->setting,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('admin.epaper.tambah_epaper',[
           "judul" => 'Tambah ePaper' . ' - ' . $this->setting->judul_situs,
       ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'edisi' => 'required',
            'cover' => 'image|file|max:1024',
            'pdf' => 'mimes:pdf|max:20000',
        ]);

        $validatedData['id_network'] = $this->user_network;
        
        // Upload Gambar
        $ekstensiGambar = $request->file('cover')->extension();

        $getTahun = \Carbon\Carbon::now()->translatedFormat('Y');
        $getBulan = \Carbon\Carbon::now()->translatedFormat('m');
        $getWaktu = \Carbon\Carbon::now()->translatedFormat('dmY-His');

        $namaGambarBaru = 'epaper-edisi-'. Str::slug($request->edisi) . '-'. $getWaktu. '.' .$ekstensiGambar;
        $lokasiGambar = $this->user_network . '/epaper/cover/' . $getTahun . '/' . $getBulan;
        $lokasiThumbnail = 'thumbnail/' . $lokasiGambar . '/';

        //Check jika ada folder thumbnail
        if (!file_exists($lokasiThumbnail)) {
            mkdir($lokasiThumbnail, 0755, true);
        }
        
        if($request->file('cover')){
            //Simpan Gambar Cover
            $validatedData['cover'] = $request->file('cover')->storeAs($lokasiGambar, $namaGambarBaru);
            //Buat Thumbnail
            $thumbnail = Image::gd()->read($request->file('cover'))->scaleDown(width: 720);

            $thumbnail->save($lokasiThumbnail . $namaGambarBaru, 80);
        }

        // Upload PDF
        $ekstensiPDF = $request->file('pdf')->extension();

        $namaPDFBaru = 'epaper-edisi-'. Str::slug($request->edisi) .'-'. $getWaktu .'.' .$ekstensiPDF;
        $lokasiPDF = 'epaper/pdf/' . $getTahun . '/' . $getBulan;

        if($request->file('pdf')){
            //Simpan PDF
            $validatedData['pdf'] = $request->file('pdf')->storeAs($lokasiPDF, $namaPDFBaru);
        }

        Epaper::create($validatedData);

        return redirect('/admin/epaper')->with('success', 'ePaper Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Epaper  $epaper
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Epaper $epaper)
    {
        if ($request->ajax()) {
            return view('admin.epaper.show_epaper', [
                "judul" => 'Detail ePaper' . ' - ' . $this->setting->judul_situs,
                "epaper" => $epaper
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Epaper  $epaper
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Epaper $epaper)
    {   
        if($request->ajax()){
            return view('admin.epaper.edit_epaper',[
                "judul" => 'Edit ePaper' . ' - ' . $this->setting->judul_situs,
                "epaper" => $epaper
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Epaper  $epaper
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Epaper $epaper)
    {
        $validatedData = $request->validate([
            'edisi' => 'required',
            'cover' => 'image|file|max:1024',
            'pdf' => 'mimes:pdf|max:20000',
        ]);

        if($request->edisi != $epaper->edisi){
            $epaper['slug'] = 'required|max:255';
        }

        // Upload Gambar
        if($request->file('cover')){

            if($request->coverLama){
                Storage::delete($request->coverLama);
            }

            $ekstensiGambar = $request->file('cover')->extension();

            $getTahun = \Carbon\Carbon::now()->translatedFormat('Y');
            $getBulan = \Carbon\Carbon::now()->translatedFormat('m');
            $getWaktu = \Carbon\Carbon::now()->translatedFormat('dmY-His');

            $namaGambarBaru = 'epaper-edisi-'. Str::slug($request->edisi) . '-'. $getWaktu. '.' .$ekstensiGambar;
            $lokasiGambar = $this->user_network . '/epaper/cover/' . $getTahun . '/' . $getBulan;
            $lokasiThumbnail = 'thumbnail/' . $lokasiGambar . '/';

            //Check jika ada folder thumbnail
            if (!file_exists($lokasiThumbnail)) {
                mkdir($lokasiThumbnail, 0755, true);
            }
        
            //Simpan Gambar Cover
            $validatedData['cover'] = $request->file('cover')->storeAs($lokasiGambar, $namaGambarBaru);
            //Buat Thumbnail
            $thumbnail = Image::gd()->read($request->file('cover'))->scaleDown(width: 720);

            $thumbnail->save($lokasiThumbnail . $namaGambarBaru, 80);
        }

        // Upload PDF
        if($request->file('pdf')){

            if($request->pdfLama){
                Storage::delete($request->pdfLama);
            }

            $ekstensiPDF = $request->file('pdf')->extension();

            $getTahun = \Carbon\Carbon::now()->translatedFormat('Y');
            $getBulan = \Carbon\Carbon::now()->translatedFormat('m');
            $getWaktu = \Carbon\Carbon::now()->translatedFormat('dmY-His');

            $namaPDFBaru = 'epaper-edisi-'. Str::slug($request->edisi) .'-'. $getWaktu .'.' .$ekstensiPDF;
            $lokasiPDF = 'epaper/pdf/' . $getTahun . '/' . $getBulan;
        
            //Simpan PDF
            $validatedData['pdf'] = $request->file('pdf')->storeAs($lokasiPDF, $namaPDFBaru);
        }

        Epaper::where('id', $epaper->id)
               ->update($validatedData);
        
        return redirect('/admin/epaper')->with('success', 'ePaper Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Epaper  $epaper
     * @return \Illuminate\Http\Response
     */
    public function destroy(Epaper $epaper)
    {
        // Hapus Gambar Cover
        if($epaper->cover){
            Storage::delete($epaper->cover);
        }

        // Hapus File PDF
        if($epaper->pdf){
            Storage::delete($epaper->pdf);
        }

        Epaper::destroy($epaper->id);

        return redirect('/admin/epaper')->with('success', 'ePaper Berhasil Dihapus');
    }
}
