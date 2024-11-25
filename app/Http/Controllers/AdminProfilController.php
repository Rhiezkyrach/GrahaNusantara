<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Berita;
use App\Models\Setting;
use App\Models\Reporter;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\NetworkAccess;
use App\Traits\NetworkAccessTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class AdminProfilController extends Controller
{
    use NetworkAccessTrait;

    public $setting;
    public $user_network;

    public function __construct()
    {
        $this->setting = Setting::where('id_network', auth()->user()->id_network)->first();
        $this->user_network = auth()->user()->id_network;
    }
    
    public function index()
    {
        if (session()->has('success')) {
            Alert::toast(session('success'), 'success');
        }

        if (session()->has('error')) {
            Alert::toast(session('error'), 'error');
        }
        
        return view('admin.profile.profile', [
            "judul" => 'Profil Saya' . ' - ' . $this->setting->judul_situs,
            'jumlah_berita' => Berita::where('publish', '1')->where('id_user', auth()->user()->id)->count(),
            'list_tayang' => $this->list_tayang(),
            'id_setting' => $this->setting->id,
            'user' => User::find(auth()->user()->id),
            'setting' => $this->setting,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {

        if ($request->password_lama && $request->password_baru && $request->confirm_password_baru) {
            if (Hash::check($request->password_lama, $user->password)) {
                if ($request->password_baru == $request->confirm_password_baru) {
                    
                    $user->update(['password' => Hash::make($request->confirm_password_baru)]);
                } else {
                    return redirect()->back()->with('error', 'Konfirmasi Password Tidak Sama!');
                }
            } else {
                return redirect()->back()->with('error', 'Password Lama Salah!');
            }
        }

        // Upload Avatar
        if ($request->file('foto')) {
            $ekstensiGambar = $request->file('foto')->extension();

            $date = \Carbon\Carbon::now()->translatedFormat('dmY-His');

            $namaGambarBaru = Str::slug($request->name) . '-' . $date . '.' . $ekstensiGambar;
            $lokasiGambar = $this->user_network . '/gambar/foto/user';

            if ($request->fotoLamaWartawan) {
                Storage::delete($request->fotoLamaWartawan);
            }
            if ($request->fotoLamaUser) {
                Storage::delete($request->fotoLamaUser);
            }

            $validatedData['profile_photo_path'] = $request->file('foto')->storeAs($lokasiGambar, $namaGambarBaru);
        
            // Update Table User
            User::where('id', $user->id)->update($validatedData);
            $updated_user = User::where('id', $user->id)->first();

            // Update Table Wartawan
            if ($updated_user->level == 'wartawan') {
                $lokasiGambarWartawan = $this->user_network . '/gambar/foto/wartawan';
                $wartawan = Reporter::where('id_user', $updated_user->id)->first();
                $wartawan->update([
                    'nama_wartawan' => $updated_user->name,
                    'alamat' => $request->alamat,
                    'kontak' => $request->kontak,
                    'about_me' => $request->about_me,
                    'status' => $updated_user->status,
                    'foto' => $request->file('foto') ? $request->file('foto')->storeAs($lokasiGambarWartawan, $namaGambarBaru) : $wartawan->foto,
                ]);
            }
        }

        // Delete Access id Status User Set to Inactive
        if ($updated_user->status == '0') {
            NetworkAccess::where('id_user', $updated_user->id)
                ->where('id_network', $updated_user->id_network)
                ->delete();
        }

        return redirect()->back()->with('success', 'Profil Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
