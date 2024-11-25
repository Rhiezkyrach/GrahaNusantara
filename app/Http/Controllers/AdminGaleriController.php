<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Fokus;
use App\Models\Berita;
use App\Models\Galeri;
use App\Models\Setting;
use App\Models\Kategori;
use App\Models\Reporter;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\NetworkAccessTrait;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Intervention\Image\ImageManager as Image;

class AdminGaleriController extends Controller
{
    use NetworkAccessTrait;
    
    public $setting;
    public $user_network;

    public function __construct()
    {
        $this->setting = Setting::where('id_network', auth()->user()->id_network)->first();
        $this->user_network = auth()->user()->id_network;
    }

    // index
    public function index(Request $request)
    {
        if(session('success')){
            Alert::success('Success!', session('success'));
        }

        if (session('error')) {
            Alert::success('error!', session('error'));
        }

        $data = Berita::showAllGaleri($this->user_network);

        if ($request->ajax()) {
            return datatables()->of($data)
                ->editColumn('id_network', function (Berita $berita) {
                    return $berita->Network ? $berita->Network->nama : $berita->id_network;
                })
                ->editColumn('tanggal_tayang', function (Berita $berita) {
                    return Carbon::parse($berita->tanggal_tayang . $berita->waktu)->translatedFormat('d F Y, H:i');
                })
                ->editColumn('headline', function (Berita $berita) {
                    return $berita->headline == '1' ? '<div class="text-sm text-green-800"><i class="fas fa-check-circle"></i></div>' : '';
                })
                ->editColumn('publish', function (Berita $berita) {
                    if ($berita->publish == 0) {
                        return '<div class="inline-flex text-xxs font-semibold text-red-800 bg-red-200 px-2 py-1 rounded-full">Draf</div>';
                    } elseif ($berita->publish == 1 && Carbon::parse($berita->tanggal_tayang . $berita->waktu)->translatedFormat('Y-m-d H:i') >= Carbon::now()) {
                        return '<div class="inline-flex text-xxs font-semibold text-yellow-800 bg-yellow-200 px-2 py-1 rounded-full">Terjadwal</div>';
                    } elseif ($berita->publish == 1 && Carbon::parse($berita->tanggal_tayang . $berita->waktu)->translatedFormat('Y-m-d H:i') <= Carbon::now()) {
                        return '<div class="inline-flex text-xxs font-semibold text-green-800 bg-green-200 px-2 py-1 rounded-full">Tayang</div>';
                    }
                })
                ->addColumn('kategori', function (Berita $berita) {
                    return $berita->Kategori ? $berita->Kategori->nama : '';
                })
                ->addColumn('link', function (Berita $berita) {
                    return '<input class="w-40 px-1 py-0.5 border border-gray-600 rounded" value="' . url('berita/' . $berita->slug) . '"/>';
                })
                ->addColumn('action', function (Berita $berita) {
                    return view('admin.galeri.galeri-action', ['data' => $berita])->render();
                })
                ->rawColumns(['action', 'headline', 'publish', 'link'])
                ->toJson();
        };

        return view('admin.galeri.galeri',[
            'judul' => 'Galeri Foto' . ' - ' . $this->setting->judul_situs,
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
        $checkidGaleri = Kategori::where('nama', 'GALERI')->first();
 
        return view('admin.galeri.tambah_galeri',[
            "judul" => 'Tambah Berita Foto' . ' - ' . $this->setting->judul_situs,
            "isi" => '<b>' . strtoupper($request->getHost()) . '</b> - ',
            "kategoriGaleri" => $checkidGaleri,
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
        try {
            // Insert Ke Table Berita
            $validatedData = $request->validate([
                'judul_atas' => 'max:125',
                'judul' => 'required|max:125',
                'sub_judul' => 'max:125',
                'isi' => 'required',
                'tag' => 'required',
                'oleh' => 'max:60',
                'id_wartawan' => 'required',
                'caption' => 'required|max:255',
                'waktu' => 'required|date_format:H:i',
            ]);

            $wartawan = Reporter::where('id_wartawan', $request->id_wartawan)->first();
            $checkidGaleri = Kategori::where('nama', 'Galeri')->first();

            $validatedData['id_user'] = auth()->user()->id;
            $validatedData['id_network'] = $this->user_network;
            $validatedData['penulis'] = auth()->user()->name;
            $validatedData['id_kategori'] = $checkidGaleri->id;
            $validatedData['wartawan'] = $wartawan->nama_wartawan;
            $validatedData['tanggal_tayang'] = $request->tanggal_tayang;
            $validatedData['waktu'] = $request->waktu;
            $validatedData['headline'] = $request->headline;
            $validatedData['publish'] = $request->publish;
            $validatedData['kode_embed'] = $request->kode_embed;

            // Upload Gambar Utama
            if ($request->gambar_detail_copy) {
                $validatedData['gambar_detail'] = $request->gambar_detail_copy;
            } else if ($request->file('gambar_detail')) {
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
                
                if($request->file('gambar_detail')){
                    //Simpan Gambar
                    $validatedData['gambar_detail'] = $request->file('gambar_detail')->storeAs($lokasiGambar, $namaGambarBaru);
                    //Buat Thumbnail
                    $thumbnail = Image::gd()->read($request->file('gambar_detail'))->scaleDown(width: 400);

                    $thumbnail->save($lokasiThumbnail . $namaGambarBaru, 80);
                }
            }

            $success = Berita::create($validatedData);

            //Insert ke Table Galeri
            $data['id_network'] = $success->id_network;
            $data['id_berita'] = $success->id_berita;
            
            // Upload Gambar Slide
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
        } catch (Exception $e) {
            dd($e);
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
    //  
 
    //     return view('admin.galeri.edit_galeri',[
    //        "judul" => 'Edit Berita Foto' . ' - ' . $this->setting->judul_situs,
    //        "isi" => '<b>SinPo.id - &nbsp</b>',
    //        "berita" => $galeri,
    //        "kategori" => Kategori::where('id', 15)->first(),
    //        "wartawan" => Reporter::allWartawan(),
    //    
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
        
        // $validatedData['penulis'] = auth()->user()->name;
        // $validatedData['id_kategori'] = 15;
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

        return redirect()->back()->with('success', 'Foto Berhasil Dihapus');
    }

}
