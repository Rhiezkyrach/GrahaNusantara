<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Berita;
use App\Models\Setting;
use App\Models\kategori;
use App\Models\Reporter;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        User::create([
            'nama' => 'admin',
            'username' => 'admin',
            'inisial' => 'ad',
            'password' => bcrypt('Rajaadmin2022'),
            'level' => 'superadmin',
            'status' => 1,
        ]);

        Setting::create([
            'judul_situs' => 'rajamedia.co',
            'tagline' => 'Portal Berita No. 1',
            'deskripsi' => 'Portal Berita No. 1',
            'logo' => 'rajamedia',
            'darklogo' => 'rajamedia',
            'alamat' => 'Kec. Serpong, Kota Tangerang Selatan, Banten 15311',
            'telepon' => '(021) 53151050',
            'email' => 'admin@rhiezproject.com',
            'facebook' => 'https://www.facebook.com/rajamedia',
            'instagram' => 'https://www.instagram.com/rajamedia/',
            'twitter' => 'https://twitter.com/rajamedia',
            'youtube' => '@rajamedia',
            'tiktok' => '@rajamedia',
            'copyright' => 'rajamedia@2022',
        ]);

        Kategori::create([
            'nama' => 'Politik',
            'slug' => 'politik',
            'status' => true,
            'navigasi' => true,
            'urutan' => 1
        ]);

        Kategori::create([
            'nama' => 'Hukum',
            'slug' => 'hukum',
            'status' => true,
            'navigasi' => true,
            'urutan' => 2
        ]);

        Kategori::create([
            'nama' => 'Nasional',
            'slug' => 'nasional',
            'status' => true,
            'navigasi' => true,
            'urutan' => 3
        ]);

        Kategori::create([
            'nama' => 'Galeri',
            'slug' => 'galeri',
            'status' => true,
            'navigasi' => true,
            'urutan' => 4
        ]);

        Kategori::create([
            'nama' => 'Opini',
            'slug' => 'opini',
            'status' => true,
            'navigasi' => true,
            'urutan' => 5
        ]);

        Reporter::create([
            'nama_wartawan' => 'Redaksi',
            'status' => true
        ]);

        // Berita::factory(100)->create();
    }
}
