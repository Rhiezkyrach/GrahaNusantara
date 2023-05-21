<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Galeri;
use App\Models\Setting;
use App\Models\Kategori;
use App\Models\Reporter;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Intervention\Image\ImageManagerStatic as Image;

class AdminGaleriController extends Controller
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

        return view('admin.galeri.galeri',[
            'judul' => 'Galeri Foto' . ' - ' . $setting->judul_situs,
            'berita' => Berita::beritaFoto()->backendfilter(request(['cari']))->paginate(10),
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
        $checkidGaleri = Kategori::where('nama', 'GALERI')->first();
 
        return view('admin.galeri.tambah_galeri',[
           "judul" => 'Tambah Berita Foto' . ' - ' . $setting->judul_situs,
           "isi" => '',
           "kategoriGaleri" => $checkidGaleri,
           "wartawan" => Reporter::allWartawan(),
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
        // Insert Ke Table Berita
         $validatedData = $request->validate([
            'judul_atas' => 'max:125',
            'judul' => 'required|max:125',
            'sub_judul' => 'max:125',
            'isi' => 'required',
            'tag' => 'required',
            'oleh' => 'max:60',
            'id_wartawan' => 'required',
            'caption' => 'required|max:200',

        ]);

        $wartawan = Reporter::where('id_wartawan', $request->id_wartawan)->first();
        $checkidGaleri = Kategori::where('nama', 'Galeri')->first();
        
        $validatedData['penulis'] = auth()->user()->nama;
        $validatedData['id_channel'] = $checkidGaleri->id;
        $validatedData['wartawan'] = $wartawan->nama_wartawan;
        $validatedData['tanggal_tayang'] = $request->tanggal_tayang;
        $validatedData['waktu'] = $request->waktu;
        $validatedData['headline'] = $request->headline;
        $validatedData['publish'] = $request->publish;
        $validatedData['kode_embed'] = $request->kode_embed;

        // Upload Gambar Utama
        $ekstensiGambar = $request->file('gambar_detail')->extension();

        $date = \Carbon\Carbon::now()->translatedFormat('dmY-His');
        $getTahun = \Carbon\Carbon::now()->translatedFormat('Y');
        $getBulan = \Carbon\Carbon::now()->translatedFormat('m');

        $namaGambarBaru = Str::slug($request->judul) . '-' . $date . '.' .$ekstensiGambar;
        $lokasiGambar = $getTahun. '/' . $getBulan;
        $lokasiThumbnail = 'thumbnail/' . $lokasiGambar . '/';

        //Check jika ada folder thumbnail
        if (!file_exists($lokasiThumbnail)) {
            mkdir($lokasiThumbnail, 0755, true);
        }
        

        if($request->file('gambar_detail')){
            //Simpan Gambar
            $validatedData['gambar_detail'] = $request->file('gambar_detail')->storeAs($lokasiGambar, $namaGambarBaru);
            //Buat Thumbnail
            $thumbnail = Image::make($request->file('gambar_detail'))->resize(null, 250, function ($constraint) {
                            $constraint->aspectRatio();
                        });

            $thumbnail->save($lokasiThumbnail . $namaGambarBaru, 80);
        }

        Berita::create($validatedData);

        //Insert ke Table Galeri
        $galeri = Berita::where('id_channel', $checkidGaleri->id)->orderBy('tanggal_tayang', 'DESC')->orderBy('waktu', 'DESC')->first();

        // dd($galeri);
        $data['id_berita'] = $galeri->id_berita;
        
        // Upload Gambar Slide
        $i = 0;
        foreach($request->nama_photo as $file) {
            
            $ekstensiGambar = $file->getClientOriginalExtension();

            $date = \Carbon\Carbon::now()->translatedFormat('dmY-His');

            $namaGambarBaru = Str::slug($request->judul) . $i .'-' . $date . '.' .$ekstensiGambar;
            $lokasiGambar = 'galeri';

            $data['nama_photo'] = $file->storeAs($lokasiGambar, $namaGambarBaru);
            
            Galeri::create($data);
            $i++;
        }

        return redirect('/admin/galeri')->with('success', 'Berita Foto Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Galeri  $galeri
     * @return \Illuminate\Http\Response
     */
    public function show(Galeri $galeri)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Galeri  $galeri
     * @return \Illuminate\Http\Response
     */
    public function edit(Galeri $galeri)
    {
    //     $setting = Setting::first();
 
    //     return view('admin.galeri.edit_galeri',[
    //        "judul" => 'Edit Berita Foto' . ' - ' . $setting->judul_situs,
    //        "isi" => '<b>SinPo.id - &nbsp</b>',
    //        "berita" => $galeri,
    //        "kategori" => Kategori::where('id', 15)->first(),
    //        "wartawan" => Reporter::allWartawan(),
    //        "setting" => $setting
    //    ]);;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Galeri  $galeri
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Galeri $galeri)
    {
        // Insert Ke Table Berita
        // $validatedData = $request->validate([
        //     'judul' => 'required|max:125',
        //     'isi' => 'required',
        //     'tag' => 'required',
        //     'oleh' => 'max:60',
        //     'id_wartawan' => 'required',
        //     'caption' => 'required',

        // ]);

        // $wartawan = Reporter::where('id_wartawan', $request->id_wartawan)->first();
        
        // $validatedData['penulis'] = auth()->user()->nama;
        // $validatedData['id_channel'] = 15;
        // $validatedData['wartawan'] = $wartawan->nama_wartawan;
        // $validatedData['tanggal_tayang'] = $request->tanggal_tayang;
        // $validatedData['waktu'] = $request->waktu;
        // $validatedData['headline'] = $request->headline;
        // $validatedData['publish'] = $request->publish;

        // Berita::create($validatedData);

        //Insert ke Table Galeri
        // $data['id_berita'] = $request->id_berita;

        // Upload Gambar
        // $i = 0;
        // foreach($request->nama_photo as $file) {
            
        //     $ekstensiGambar = $file->getClientOriginalExtension();

        //     $date = \Carbon\Carbon::now()->translatedFormat('dmY-His');

        //     $namaGambarBaru = Str::slug($request->judul) . $i .'-' . $date . '.' .$ekstensiGambar;
        //     $lokasiGambar = 'galeri';

        //     $data['nama_photo'] = $file->storeAs($lokasiGambar, $namaGambarBaru);
            
        //     Galeri::create($data);
        //     $i++;
        // }

        // return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Galeri  $galeri
     * @return \Illuminate\Http\Response
     */
    public function destroy(Galeri $galeri)
    {
        if($galeri->nama_photo){
            Storage::delete($galeri->nama_photo);
        }

        Galeri::destroy($galeri->id);

        return redirect()->back();
    }

}
