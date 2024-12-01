<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Setting;
use App\Models\Kategori;
use App\Models\Reporter;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'nama' => 'admin',
            'username' => 'admin',
            'inisial' => 'ad',
            'password' => bcrypt('password'),
            'level' => 'superadmin',
            'status' => 1,
        ]);

        Setting::create([
            'judul_situs' => 'rhiezkyrach.co',
            'tagline' => 'Portal Berita No. 1',
            'deskripsi' => 'Portal Berita No. 1',
            'logo' => 'rhiezkyrach',
            'darklogo' => 'rhiezkyrach',
            'alamat' => 'Kec. Serpong, Kota Tangerang Selatan, Banten 15311',
            'telepon' => '(021) 53151050',
            'email' => 'admin@rhiezproject.com',
            'facebook' => 'https://www.facebook.com/rhiezkyrach',
            'instagram' => 'https://www.instagram.com/rhiezkyrach/',
            'twitter' => 'https://twitter.com/rhiezkyrach',
            'youtube' => '@rhiezkyrach',
            'tiktok' => '@rhiezkyrach',
            'copyright' => 'rhiezkyrach@2022',
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

        Reporter::create([
            'nama_wartawan' => 'Tim Redaksi',
            'status' => true
        ]);

        // Berita::factory(100)->create();
    }
}
