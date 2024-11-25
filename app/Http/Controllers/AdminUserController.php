<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Setting;
use App\Models\Reporter;
use App\Models\Struktur;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\NetworkAccess;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Traits\NetworkAccessTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class AdminUserController extends Controller
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
        if (session()->has('success')) {
            Alert::toast(session('success'), 'success');
        }

        if (session()->has('error')) {
            Alert::toast(session('error'), 'error');
        }

        $data = User::showUser($this->user_network);

        if ($request->ajax()) {
            return datatables()->of($data)
                ->editColumn('id_network', function (User $user) {
                    return $user->Network ? $user->Network->nama : $user->id_network;
                })
                ->editColumn('status', function (User $user) {
                    return $user->status == '0'
                        ? "<td><span class='px-3 py-1 text-xs rounded-full bg-rose-200'>TIDAK AKTIF</span></td>"
                        : "<td><span class='px-3 py-1 text-xs bg-green-200 rounded-full'>AKTIF</span></td>";
                })
                ->addColumn('action', function (User $user) {
                    return view('admin.user.user-action', ['data' => $user])->render();
                })
                ->rawColumns(['action', 'status'])
                ->toJson();
        };

        return view('admin.user.user', [
            'judul' => 'Management User' . ' - ' . $this->setting->judul_situs,
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
        if ($request->ajax()) {
            return view('admin.user.tambah_user', [
                'judul' => 'Tambah User' . ' - ' . $this->setting->judul_situs,
            ]);
        }
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
            'name' => 'required|max:255',
            'username' => 'required|max:255',
            'inisial' => 'required|max:10',
            'password' => 'required|min:6',
            'email' => 'nullable|unique:users,email',
            'level' => 'required',
            'status' => 'required',
            'valid_from' => 'nullable',
            'valid_to' => 'nullable',
        ]);

        $validatedData['id_network'] = $this->user_network;
        $validatedData['password'] = bcrypt($validatedData['password']);

        // Upload Avatar
        if ($request->file('foto')) {
            $ekstensiGambar = $request->file('foto')->extension();

            $date = \Carbon\Carbon::now()->translatedFormat('dmY-His');

            $namaGambarBaru = Str::slug($request->name) . '-' . $date . '.' . $ekstensiGambar;
            $lokasiGambar = $this->user_network . '/gambar/foto/user';

            $validatedData['profile_photo_path'] = $request->file('foto')->storeAs($lokasiGambar, $namaGambarBaru);
        }

        // Create Data User
        $success = User::create($validatedData);

        // Create Data Wartawan
        if ($request->level == 'wartawan') {
            $lokasiGambarWartawan = $this->user_network . '/gambar/foto/wartawan';
            Reporter::create([
                'id_network' => $success->id_network,
                'id_user' => $success->id,
                'nama_wartawan' => $success->name,
                'foto' => $request->file('foto')->storeAs($lokasiGambarWartawan, $namaGambarBaru)
            ]);
        }

        // Create Access
        NetworkAccess::create([
            'id_user' => $success->id,
            'id_network' => $success->id_network
        ]);

        return redirect()->back()->with('success', 'User Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, User $user)
    {
        if ($request->ajax()) {
            return view('admin.user.show_user', [
                'judul' => 'Edit User' . ' - ' . $this->setting->judul_situs,
                'user' => $user,
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, User $user)
    {
        if ($request->ajax()) {
            return view('admin.user.edit_user', [
                'judul' => 'Edit User' . ' - ' . $this->setting->judul_situs,
                'user' => $user,
            ]);
        }
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

        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'inisial' => 'required|max:10',
            'level' => 'required',
            'email' => 'unique:users,email,' . $user->id,
            'status' => 'nullable',
            'valid_from' => 'nullable',
            'valid_to' => 'nullable',
        ]);

        if ($request->username && $request->username != $user->username) {
            $request->validate([
                'username' => 'required|unique:users|max:255',
            ]);
            $validatedData['username'] = $request->username;
        }

        if ($request->password) {
            $request->validate([
                'password' => 'required|min:6',
            ]);
            $validatedData['password'] = bcrypt($request->password);
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
        }

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

        // Delete Access id Status User Set to Inactive
        if ($updated_user->status == '0') {
            NetworkAccess::where('id_user', $updated_user->id)
                ->where('id_network', $updated_user->id_network)
                ->delete();
        }

        return redirect()->back()->with('success', 'User Berhasil Diupdate');
    }

    public function pdf(User $user)
    {
        $pdf = Pdf::loadView('admin.user.idcard', [
            'data' => $user,
            'struktur' => Struktur::where('id_network', $user->id_network)->first(),
            'setting' => Setting::where('id_network', $user->id_network)->first(),
        ]);

        return $pdf->stream('ID_CARD-' . Str::slug($user->name) . '.pdf');
    }

    public function destroy(User $user)
    {
        if ($user->profile_photo_path) {
            Storage::delete($user->profile_photo_path);
        }

        User::destroy($user->id);
        NetworkAccess::where('id_user', $user->id)->delete();

        return redirect('/admin/user')->with('success', 'User Berhasil Dihapus');
    }

    //check unique
    public function checkUnique(Request $request)
    {
        $data = User::where('username', $request->unique)->orWhere('email', $request->email)->get();

        if ($data->count() > 0) {
            return response()->json([
                'data' => $data
            ]);
        }
    }
}
