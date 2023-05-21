<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Berita;
use App\Models\Kategori;
use App\Models\Reporter;
use App\Models\Setting;
use App\Models\Galeri;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use RealRashid\SweetAlert\Facades\Alert;


class AdminBeritaController extends Controller
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
        
        return view('admin.berita.berita',[
            "judul" => 'List Berita' . ' - ' . $setting->judul_situs,
            "berita" => Berita::showAllBerita()->backendfilter(request(['cari']))->paginate(10),
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
 
       return view('admin.berita.tambah_berita',[
           "judul" => 'Tambah Berita' . ' - ' . $setting->judul_situs,
           "isi" => '',
           "kategori" => Kategori::allKategori(),
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
        $validatedData = $request->validate([
            'id_channel' => 'required',
            'judul_atas' => 'max:255',
            'judul' => 'required|max:255',
            'sub_judul' => 'max:255',
            'isi' => 'required',
            'tag' => 'required',
            'oleh' => 'max:60',
            'foto_penulis' => 'image|max:512',
            'id_wartawan' => 'required',
            'gambar_detail' => 'image|file|max:1024',
            'caption' => 'required|max:255',
            'waktu' => 'required|date_format:H:i',

        ]);

        $wartawan = Reporter::where('id_wartawan', $request->id_wartawan)->first();
        
        $validatedData['penulis'] = auth()->user()->nama;
        $validatedData['wartawan'] = $wartawan->nama_wartawan;
        $validatedData['tanggal_tayang'] = $request->tanggal_tayang;
        $validatedData['headline'] = $request->headline;
        $validatedData['publish'] = $request->publish;
        $validatedData['video'] = $request->video;
        $validatedData['kode_embed'] = $request->kode_embed;

        // Upload Foto Penulis
        if($request->file('foto_penulis')){
            $ekstensiGambar = $request->file('foto_penulis')->extension();

            $date = \Carbon\Carbon::now()->translatedFormat('dmY-His');
            
            $namaGambarBaru = Str::slug($request->oleh) . '-' . $date . '.' .$ekstensiGambar;
            $lokasiGambar = 'gambar/foto/penulis';
                
            $validatedData['foto_penulis'] = $request->file('foto_penulis')->storeAs($lokasiGambar, $namaGambarBaru);
        }

        // Upload Gambar
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

        return redirect('/admin/berita')->withSuccess('Berita Berhasil Ditambahkan');
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Berita $beritum)
    {
        $setting = Setting::first();
        $galeri = Galeri::hasIn('berita')->where('id_berita', $beritum->id_berita)->get();

        // dd($galeri);

        return view('admin.berita.edit_berita',[
            "judul" => 'Edit Berita' . ' - ' . $setting->judul_situs,
            "berita" => $beritum,
            "kategori" => Kategori::allKategori(),
            "wartawan" => Reporter::allWartawan(),
            "setting" => $setting,
            "galeri" => $galeri
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Berita $beritum)
    {
        $validatedData = $request->validate([
            'id_channel' => 'required',
            'judul_atas' => 'max:125',
            'judul' => 'required|max:125',
            'sub_judul' => 'max:125',
            'isi' => 'required',
            'tag' => 'required',
            'oleh' => 'max:60',
            'foto_penulis' => 'image|max:512',
            'id_wartawan' => 'required',
            'gambar_detail' => 'image|file|max:1024',
            'caption' => 'required|max:250',
            'waktu' => 'required|date_format:H:i',

        ]);

        if($request->judul != $beritum->judul){
            $beritum['slug'] = 'required|max:255';
        }

        $wartawan = Reporter::where('id_wartawan', $request->id_wartawan)->first();
        
        $validatedData['penulis'] = $beritum->penulis;
        $validatedData['wartawan'] = $wartawan->nama_wartawan;
        $validatedData['tanggal_tayang'] = $request->tanggal_tayang;
        $validatedData['headline'] = $request->headline;
        $validatedData['publish'] = $request->publish;
        $validatedData['video'] = $request->video;
        $validatedData['kode_embed'] = $request->kode_embed;

        // Upload Foto Penulis
        if($request->file('foto_penulis')){
            $ekstensiGambar = $request->file('foto_penulis')->extension();

            $date = \Carbon\Carbon::now()->translatedFormat('dmY-His');
            
            $namaGambarBaru = Str::slug($request->oleh) . '-' . $date . '.' .$ekstensiGambar;
            $lokasiGambar = 'gambar/foto/penulis';
                
            $validatedData['foto_penulis'] = $request->file('foto_penulis')->storeAs($lokasiGambar, $namaGambarBaru);
        }

        //Upload Jika Gambar Baru
        if($request->file('gambar_detail')){
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

            if($request->gambarLama){
                Storage::delete($request->gambarLama);
            }

            //Simpan Gambar
            $validatedData['gambar_detail'] = $request->file('gambar_detail')->storeAs($lokasiGambar, $namaGambarBaru);
            //Buat Thumbnail
            $thumbnail = Image::make($request->file('gambar_detail'))->resize(null, 250, function ($constraint) {
                            $constraint->aspectRatio();
                        });

            $thumbnail->save($lokasiThumbnail . $namaGambarBaru, 80);
              
        }

        Berita::where('id_berita', $beritum->id_berita)
               ->update($validatedData);

        //Insert ke Table Galeri
        if($request->file('nama_photo')){
            
            $data['id_berita'] = $beritum->id_berita;

            // Upload Gambar
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
        }

        return redirect('/admin/berita')->with('success', 'Berita Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Berita $beritum)
    {
        $galeri = Galeri::hasIn('berita')->where('id_berita', $beritum->id_berita)->get();

        // Hapus Gambar dan Berita
        if($beritum->gambar_detail){
            Storage::delete($beritum->gambar_detail);
        }

        Berita::destroy($beritum->id_berita);

        // Hapus Galeri Foto
        if($galeri->count()){
            foreach($galeri as $g){
                Storage::delete($g->nama_photo);
                Galeri::destroy($g->id);
            }
        }

        return redirect('/admin/berita')->with('success', 'Berita Berhasil Dihapus');
    }

    public function uploadImage(Request $request) {		
	if($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;
            $lokasiGambar = 'gambar/ckeditor/';
        
            $request->file('upload')->storeAs($lokasiGambar, $fileName);
   
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('storage/'.$lokasiGambar.'' .$fileName); 
            $msg = 'Image uploaded successfully'; 
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
               
            @header('Content-type: text/html; charset=utf-8'); 
            echo $response;
        }
    }
}
