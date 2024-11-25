<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use App\Models\User;
use App\Models\Fokus;
use App\Models\Berita;
use App\Models\Galeri;
use App\Models\Setting;

use App\Models\Kategori;
use App\Models\Reporter;
// use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\NetworkAccessTrait;
use Exception;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Intervention\Image\ImageManager as Image;


class AdminBeritaController extends Controller
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

        $data = Berita::showAllBerita($this->user_network);

        if ($request->ajax()) {
            return datatables()->of($data)
                ->editColumn('id_network', function (Berita $berita) {
                    return $berita->Network ? $berita->Network->nama : $berita->id_network;
                })
                ->editColumn('tanggal_tayang', function (Berita $beritum) {
                    return Carbon::parse($beritum->tanggal_tayang . $beritum->waktu)->translatedFormat('d F Y, H:i');
                })
                ->editColumn('headline', function (Berita $beritum) {
                    return $beritum->headline == '1' ? '<div class="text-sm text-green-800"><i class="fas fa-check-circle"></i></div>' : '';
                })
                ->editColumn('publish', function (Berita $beritum) {
                    if($beritum->publish == 0){
                        return '<div class="inline-flex text-xxs font-semibold text-red-800 bg-red-200 px-2 py-1 rounded-full">Draf</div>';
                    }elseif($beritum->publish == 1 && Carbon::parse($beritum->tanggal_tayang . $beritum->waktu)->translatedFormat('Y-m-d H:i') >= Carbon::now()){
                        return '<div class="inline-flex text-xxs font-semibold text-yellow-800 bg-yellow-200 px-2 py-1 rounded-full">Terjadwal</div>';
                    }elseif($beritum->publish == 1 && Carbon::parse($beritum->tanggal_tayang . $beritum->waktu)->translatedFormat('Y-m-d H:i') <= Carbon::now()){
                        return '<div class="inline-flex text-xxs font-semibold text-green-800 bg-green-200 px-2 py-1 rounded-full">Tayang</div>';                 
                    }
                })
                ->addColumn('kategori', function (Berita $beritum) {
                    return $beritum->Kategori ? $beritum->Kategori->nama : '';
                })
                ->addColumn('fokus', function (Berita $beritum) {
                    return $beritum->Fokus ? $beritum->Fokus->nama : '';
                })
                ->addColumn('link', function (Berita $beritum) {
                    $url = $this->setting->Network ? $this->setting->Network->url . '/berita/' . $beritum->slug : url('berita/' . $beritum->slug);
                    return '<input class="w-40 px-1 py-0.5 border border-gray-600 rounded" value="' . $url . '"/>';
                })
                ->addColumn('action', function (Berita $beritum) {
                    return view('admin.berita.berita-action', [
                        'data' => $beritum,
                        'wartawan' => User::where('id_network', $this->user_network)->where('level', 'wartawan')->pluck('id')->toArray()
                    ])->render();
                })
                ->rawColumns(['action', 'headline', 'publish', 'link'])
                ->toJson();
        };
        
        return view('admin.berita.berita',[
            "judul" => 'List Berita' . ' - ' . $this->setting->judul_situs,
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
    public function create(Request $request)
    {
        if (session()->has('success')) {
            Alert::toast(session('success'), 'success');
        }

        if (session()->has('error')) {
            Alert::toast(session('error'), 'error');
        }

        return view('admin.berita.tambah_berita',[
            "judul" => 'Tambah Berita' . ' - ' . $this->setting->judul_situs,
            "isi" => $this->setting->Network ? '<b>' . strtoupper(parse_url($this->setting->Network->url, PHP_URL_HOST)) . '</b> - ' : '<b>' . strtoupper($request->getHost()) . '</b> - ',
            "kategori" => Kategori::allKategori($this->user_network),
            "fokus" => Fokus::allFokus($this->user_network),
            "wartawan" => Reporter::allWartawan($this->user_network),
            'list_tayang' => $this->list_tayang(),
            'id_setting' => $this->setting->id,
            'setting' => $this->setting,
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
        try{
            $validatedData = $request->validate([
                'id_kategori' => 'required',
                'id_fokus' => 'nullable',
                'judul_atas' => 'max:255',
                'judul' => 'required|max:255',
                'sub_judul' => 'max:255',
                'isi' => 'required',
                'tag' => 'required',
                'oleh' => 'max:60',
                // 'foto_penulis' => 'image|max:512',
                'id_wartawan' => 'required',
                // 'gambar_detail' => 'image|file|max:1024',
                'caption' => 'required|max:255',
                'waktu' => 'required|date_format:H:i',

            ]);

            $wartawan = Reporter::where('id_wartawan', $request->id_wartawan)->first();

            $validatedData['id_user'] = auth()->user()->id;
            $validatedData['id_network'] = $this->user_network;
            $validatedData['penulis'] = auth()->user()->name;
            $validatedData['wartawan'] = $wartawan->nama_wartawan;
            $validatedData['tanggal_tayang'] = $request->tanggal_tayang;
            $validatedData['headline'] = $request->headline;
            $validatedData['publish'] = $request->publish;
            $validatedData['video'] = $request->video;
            $validatedData['kode_embed'] = $request->kode_embed;

            // Upload Foto Penulis
            if ($request->file('foto_penulis')) {
                $ekstensiGambar = $request->file('foto_penulis')->extension();

                $date = \Carbon\Carbon::now()->translatedFormat('dmY-His');

                $namaGambarBaru = Str::slug($request->oleh) . '-' . $date . '.' . $ekstensiGambar;
                $lokasiGambar = $this->user_network . '/gambar/foto/penulis';

                $validatedData['foto_penulis'] = $request->file('foto_penulis')->storeAs($lokasiGambar, $namaGambarBaru);
            }

            // Upload Gambar
            if ($request->gambar_detail_copy) {
                $validatedData['gambar_detail'] = $request->gambar_detail_copy;
            } else if($request->file('gambar_detail')) {
                $ekstensiGambar = $request->file('gambar_detail')->extension();

                $date = \Carbon\Carbon::now()->translatedFormat('dmY-His');
                $getTahun = \Carbon\Carbon::now()->translatedFormat('Y');
                $getBulan = \Carbon\Carbon::now()->translatedFormat('m');

                $namaGambarBaru = Str::slug($request->judul) . '-' . $date . '.' . $ekstensiGambar;
                $lokasiGambar = $this->user_network . '/' . $getTahun . '/' . $getBulan;
                $lokasiThumbnail = 'thumbnail/' . $lokasiGambar . '/';

                //Check jika ada folder thumbnail
                if (!file_exists($lokasiThumbnail)) {
                    mkdir($lokasiThumbnail, 0755, true);
                }

                if ($request->file('gambar_detail')) {
                    //Simpan Gambar
                    $validatedData['gambar_detail'] = $request->file('gambar_detail')->storeAs($lokasiGambar, $namaGambarBaru);
                    //Buat Thumbnail
                    $thumbnail = Image::gd()->read($request->file('gambar_detail'))->scaleDown(width: 400);

                    $thumbnail->save($lokasiThumbnail . $namaGambarBaru, 80);
                }
            }

            Berita::create($validatedData);
            
        } catch(Exception $e){
            dd($e);
        }
        
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
        if (session()->has('success')) {
            Alert::toast(session('success'), 'success');
        }

        if (session()->has('error')) {
            Alert::toast(session('error'), 'error');
        }

        $galeri = Galeri::where('id_berita', $beritum->id_berita)->get();
        return view('admin.berita.edit_berita',[
            "judul" => 'Edit Berita' . ' - ' . $this->setting->judul_situs,
            "berita" => $beritum,
            "kategori" => Kategori::allKategori($this->user_network),
            "fokus" => Fokus::allFokus($this->user_network),
            "wartawan" => Reporter::allWartawan($this->user_network),
            "galeri" => $galeri,
            'list_tayang' => $this->list_tayang(),
            'id_setting' => $this->setting->id,
            'setting' => $this->setting,
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
            'id_kategori' => 'required',
            'id_fokus' => 'nullable',
            'judul_atas' => 'max:125',
            'judul' => 'required|max:125',
            'sub_judul' => 'max:125',
            'isi' => 'required',
            'tag' => 'required',
            'oleh' => 'max:60',
            // 'foto_penulis' => 'image|max:512',
            'id_wartawan' => 'required',
            // 'gambar_detail' => 'image|file|max:1024',
            'caption' => 'required|max:255',
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
            $lokasiGambar = $this->user_network . '/gambar/foto/penulis';

            if ($request->fotoPenulisLama) {
                Storage::delete($request->fotoPenulisLama);
            }

            $validatedData['foto_penulis'] = $request->file('foto_penulis')->storeAs($lokasiGambar, $namaGambarBaru);
        }

        //Upload Jika Gambar Baru
        if ($request->gambar_detail_copy) {
            $validatedData['gambar_detail'] = $request->gambar_detail_copy;
        } else if($request->file('gambar_detail')){
            $ekstensiGambar = $request->file('gambar_detail')->extension();

            $date = \Carbon\Carbon::now()->translatedFormat('dmY-His');
            $getTahun = \Carbon\Carbon::now()->translatedFormat('Y');
            $getBulan = \Carbon\Carbon::now()->translatedFormat('m');

            $namaGambarBaru = Str::slug($request->judul) . '-' . $date . '.' .$ekstensiGambar;
            $lokasiGambar = $this->user_network . '/' . $getTahun. '/' . $getBulan;
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
            $thumbnail = Image::gd()->read($request->file('gambar_detail'))->scaleDown(width: 400);

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
                $lokasiGambar = $this->user_network . '/galeri';

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
        $galeri = Galeri::where('id_berita', $beritum->id_berita)->get();

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
            $lokasiGambar = $this->user_network . '/gambar/ckeditor/';
        
            $request->file('upload')->storeAs($lokasiGambar, $fileName);
   
            $url = asset('storage/'.$lokasiGambar.'' .$fileName); 
            // $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            // $msg = 'Image uploaded successfully';
            // $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            // @header('Content-type: text/html; charset=utf-8'); 
            // echo $response;

            return response()->json([
                'url' => $url
            ]);
        }
    }
}
