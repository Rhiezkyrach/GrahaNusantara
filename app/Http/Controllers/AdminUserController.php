<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Setting;
use App\Models\Reporter;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class AdminUserController extends Controller
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

        return view('admin.user.user',[
            'judul' => 'Management User' . ' - ' . $setting->judul_situs,
            'user' => User::orderBy('status', 'DESC')->orderBy('nama', 'ASC')->get(),
            'wartawan' => Reporter::orderBy('status', 'DESC')->orderBy('nama_wartawan', 'ASC')->get(),
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

        return view('admin.user.tambah_user',[
            'judul' => 'Tambah User' . ' - ' . $setting->judul_situs,
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
            'nama' => 'required|max:255',
            'username' => 'required|unique:users|max:255',
            'inisial' => 'required|max:10',
            'password' => 'required|min:6',
            'level' => 'required',
            'status' => 'required',
            'foto' => 'image',
        ]);

        $validatedData['password'] = bcrypt($validatedData['password']);

        // Upload Avatar
        if($request->file('foto')){
            $ekstensiGambar = $request->file('foto')->extension();

            $date = \Carbon\Carbon::now()->translatedFormat('dmY-His');
            
            $namaGambarBaru = Str::slug($request->nama) . '-' . $date . '.' .$ekstensiGambar;
            $lokasiGambar = 'gambar/foto/user';
                
            $validatedData['foto'] = $request->file('foto')->storeAs($lokasiGambar, $namaGambarBaru);
        }

        User::create($validatedData);

        return redirect('/admin/user')->with('success', 'User Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $setting = Setting::first();

        return view('admin.user.edit_user',[
            'judul' => 'Edit User' . ' - ' . $setting->judul_situs,
            'user' => $user,
            "setting" => $setting
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
       $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'inisial' => 'required|max:10',
            'level' => 'required',
            'status' => 'required',
            'foto' => 'image',
        ]);


        if($request->username != $user->username){
            $request->validate([
                'username' => 'required|unique:users|max:255',
            ]);
            $validatedData['username'] = $request->username;
        }

        if($request->input('password')){
            $request->validate([
                'password' => 'required|min:6',
            ]);
            $validatedData['password'] = bcrypt($request->password);
        }

        // Upload Avatar
        if($request->file('foto')){
            $ekstensiGambar = $request->file('foto')->extension();

            $date = \Carbon\Carbon::now()->translatedFormat('dmY-His');
            
            $namaGambarBaru = Str::slug($request->nama) . '-' . $date . '.' .$ekstensiGambar;
            $lokasiGambar = 'gambar/foto/user';

            if($request->fotoLama){
                    Storage::delete($request->fotoLama);
                }
                
            $validatedData['foto'] = $request->file('foto')->storeAs($lokasiGambar, $namaGambarBaru);
        }

        User::where('id', $user->id)
                ->update($validatedData);

        return redirect('/admin/user')->with('success', 'User Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if($user->foto){
                Storage::delete($user->foto);
            }

        User::destroy($user->id);

        return redirect('/admin/user')->with('success', 'User Berhasil Dihapus');
    }
}
