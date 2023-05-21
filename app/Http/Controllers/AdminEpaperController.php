<?php

namespace App\Http\Controllers;

use App\Models\Epaper;
use App\Models\Setting;

use Illuminate\Support\Str;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Intervention\Image\ImageManagerStatic as Image;

class AdminEpaperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = Setting::first();

        if(session('success')){
            Alert::success('Success!', session('success'));
        }

        return view('admin.epaper.epaper',[
            "judul" => 'Management ePaper' . ' - ' . $setting->judul_situs,
            "epaper" => Epaper::showAllePaper()->filterepaper(request(['cari']))->paginate(10),
            "setting" => $setting
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $setting = Setting::first();
 
       return view('admin.epaper.tambah_epaper',[
           "judul" => 'Tambah ePaper' . ' - ' . $setting->judul_situs,
           "setting" => $setting
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

        // Upload Gambar
        $ekstensiGambar = $request->file('cover')->extension();

        $getTahun = \Carbon\Carbon::now()->translatedFormat('Y');
        $getBulan = \Carbon\Carbon::now()->translatedFormat('m');
        $getWaktu = \Carbon\Carbon::now()->translatedFormat('dmY-His');

        $namaGambarBaru = 'epaper-edisi-'. Str::slug($request->edisi) . '-'. $getWaktu. '.' .$ekstensiGambar;
        $lokasiGambar = 'epaper/cover/' . $getTahun . '/' . $getBulan;
        $lokasiThumbnail = 'thumbnail/' . $lokasiGambar . '/';

        //Check jika ada folder thumbnail
        if (!file_exists($lokasiThumbnail)) {
            mkdir($lokasiThumbnail, 0755, true);
        }
        
        if($request->file('cover')){
            //Simpan Gambar Cover
            $validatedData['cover'] = $request->file('cover')->storeAs($lokasiGambar, $namaGambarBaru);
            //Buat Thumbnail
            $thumbnail = Image::make($request->file('cover'))->resize(720, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });

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
    public function show(Epaper $epaper)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Epaper  $epaper
     * @return \Illuminate\Http\Response
     */
    public function edit(Epaper $epaper)
    {
        $setting = Setting::first();
 
       return view('admin.epaper.edit_epaper',[
           "judul" => 'Edit ePaper' . ' - ' . $setting->judul_situs,
           "setting" => $setting,
           "epaper" => $epaper
       ]);
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
            $lokasiGambar = 'epaper/cover/' . $getTahun . '/' . $getBulan;
            $lokasiThumbnail = 'thumbnail/' . $lokasiGambar . '/';

            //Check jika ada folder thumbnail
            if (!file_exists($lokasiThumbnail)) {
                mkdir($lokasiThumbnail, 0755, true);
            }
        
            //Simpan Gambar Cover
            $validatedData['cover'] = $request->file('cover')->storeAs($lokasiGambar, $namaGambarBaru);
            //Buat Thumbnail
            $thumbnail = Image::make($request->file('cover'))->resize(720, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });

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
