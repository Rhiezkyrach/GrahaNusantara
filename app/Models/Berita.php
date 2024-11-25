<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Berita extends Model
{
    use HasFactory, Sluggable, SoftDeletes;

    protected $table = 'tbl_berita';
    protected $primaryKey = 'id_berita';
    protected $guarded = ['id_berita'];
    protected $with = ['kategori'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'judul'
            ]
        ];
    }

    //Eloquent Relations
    public function Kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id');
    }

    public function Fokus()
    {
        return $this->belongsTo(Fokus::class, 'id_fokus', 'id');
    }

    public function Reporter()
    {
        return $this->belongsTo(Reporter::class, 'id_wartawan', 'id_wartawan');
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function Galeri()
    {
        return $this->hasMany(Galeri::class, 'id_berita');
    }

    public function Network()
    {
        return $this->belongsTo(Network::class, 'id_network');
    }

    // All Frontend Model
    static public function headlines($id_network)
    {
        $q = Berita::where('headline', 1)
            ->where('publish', 1)
            ->where('id_network', $id_network)
            ->whereRaw('TIMESTAMP(tanggal_tayang, waktu) <= NOW() + INTERVAL 7 HOUR')
            ->orderBy('tanggal_tayang', 'DESC')
            ->orderBy('waktu', 'DESC')
            ->limit(5)
            ->get();

        return $q;
    }

    static public function terkini($id_network)
    {
        $q = Berita::where('publish', 1)
            ->where('id_network', $id_network)
            ->whereRaw('TIMESTAMP(tanggal_tayang, waktu) <= NOW() + INTERVAL 7 HOUR')
            ->orderBy('tanggal_tayang', 'DESC')
            ->orderBy('waktu', 'DESC');

        return $q;
    }

    static public function kategoriTerkini($id_network)
    {
        $q = Berita::where('publish', 1)
            ->where('id_network', $id_network)
            ->whereRaw('TIMESTAMP(tanggal_tayang, waktu) <= NOW() + INTERVAL 7 HOUR')
            ->orderBy('tanggal_tayang', 'DESC')
            ->orderBy('waktu', 'DESC');


        return $q;
    }

    static public function trending($id_network)
    {
        $q = Berita::where('publish', 1)
            ->where('id_network', $id_network)
            ->whereRaw('TIMESTAMP(tanggal_tayang, waktu) > date_sub(now(), interval 3 day)')
            ->orderBy('counter', 'DESC')
            ->limit(5)
            ->get();

        return $q;
    }

    static public function populer($id_network)
    {
        $q = Berita::where('publish', 1)
            ->where('id_network', $id_network)
            ->whereRaw('TIMESTAMP(tanggal_tayang, waktu) > date_sub(now(), interval 7 day)')
            ->orderBy('counter', 'DESC')
            ->limit(10)
            ->get();

        return $q;
    }

    static public function beranda($id_network, $kategori)
    {
        $q = Berita::where('publish', 1)
            ->where('id_network', $id_network)
            ->whereHas('kategori', function ($query) use ($kategori) {
                return $query->where('nama', $kategori);
            })
            ->whereRaw('TIMESTAMP(tanggal_tayang, waktu) <= NOW() + INTERVAL 7 HOUR')
            ->orderBy('tanggal_tayang', 'DESC')
            ->orderBy('waktu', 'DESC');

        return $q;
    }

    static public function indeks($id_network, $tanggal)
    {
        $q = Berita::where('publish', 1)
            ->where('id_network', $id_network)
            ->whereRaw('TIMESTAMP(tanggal_tayang, waktu) <= NOW() + INTERVAL 7 HOUR')
            ->where('tanggal_tayang', $tanggal)
            ->orderBy('tanggal_tayang', 'DESC')
            ->orderBy('waktu', 'DESC');

        return $q;
    }

    // static public function beritaFoto() {
    //     $q = Berita::hasIn('galeri')
    //             ->whereRaw('TIMESTAMP(tanggal_tayang, waktu) <= NOW() + INTERVAL 7 HOUR')
    //             ->orderBy('tanggal_tayang', 'DESC')
    //             ->orderBy('waktu', 'DESC');

    //     return $q;
    // }

    static public function beritaPrev($id_network, $id)
    {
        $q = Berita::where('publish', 1)
            ->where('id_network', $id_network)
            ->whereRaw('TIMESTAMP(tanggal_tayang, waktu) <= NOW() + INTERVAL 7 HOUR')
            ->where('id_berita', '<', $id)
            ->orderBy('id_berita', 'DESC')
            ->first();

        return $q;
    }

    static public function beritaNext($id_network, $id)
    {
        $q = Berita::where('publish', 1)
            ->where('id_network', $id_network)
            ->whereRaw('TIMESTAMP(tanggal_tayang, waktu) <= NOW() + INTERVAL 7 HOUR')
            ->where('id_berita', '>', $id)
            ->orderBy('id_berita', 'ASC')
            ->first();

        return $q;
    }

    static public function terkait($id_network)
    {
        $q = Berita::where('publish', 1)
            ->where('id_network', $id_network)
            ->whereRaw('TIMESTAMP(tanggal_tayang, waktu) <= NOW() + INTERVAL 7 HOUR')
            ->whereRaw('TIMESTAMP(tanggal_tayang, waktu) > date_sub(now(), interval 6 month)')
            ->orderBy('tanggal_tayang', 'DESC')
            ->orderBy('waktu', 'DESC');

        return $q;
    }

    static public function beritaNetwork($id_network)
    {
        $q = Berita::where('publish', 1)
            ->where('id_network', '!=', $id_network)
            ->whereRaw('TIMESTAMP(tanggal_tayang, waktu) <= NOW() + INTERVAL 7 HOUR')
            ->whereRaw('TIMESTAMP(tanggal_tayang, waktu) > date_sub(now(), interval 6 month)')
            ->orderBy('tanggal_tayang', 'DESC')
            ->orderBy('waktu', 'DESC')
            ->first();

        return $q;
    }

    // All Backend Model
    static public function showAllBerita($id_network)
    {
        $q = Berita::where('id_network', $id_network)
            ->orderBy('tanggal_tayang', 'DESC')
            ->orderBy('waktu', 'DESC');

        return $q;
    }

    static public function showAllGaleri($id_network)
    {
        $q = Berita::whereHas('galeri')
            ->where('id_network', $id_network)
            ->orderBy('tanggal_tayang', 'DESC')
            ->orderBy('waktu', 'DESC');

        return $q;
    }

    static public function listTayang($id_network)
    {
        $q = Berita::where('id_network', $id_network)
            ->where('publish', 0)
            // ->whereRaw('TIMESTAMP(tanggal_tayang, waktu) >= NOW()')
            ->orderBy('tanggal_tayang', 'desc')
            ->orderBy('waktu', 'desc');

        return $q;
    }

    static public function beritaPerTanggal($id_network, $start, $end)
    {
        $q = Berita::whereBetween('tanggal_tayang', [$start, $end])
            ->where('id_network', $id_network)
            ->orderBy('tanggal_tayang', 'asc')
            ->orderBy('waktu', 'asc');

        return $q;
    }

    //scope
    public function scopeFilter($query, array $filters)
    {
        // dd($filters);
        if (isset($filters['cari']) ? $filters['cari'] : false) {
            return $query->where('judul', 'like', '%' . request('cari') . '%')
                ->orWhere('isi', 'like', '%' . request('cari') . '%');
        } elseif (isset($filters['tag']) ? $filters['tag'] : false) {
            return $query->where('tag', 'like', '%' . request('tag') . '%')
                ->orWhere('judul', 'like', '%' . request('tag') . '%')
                ->orWhere('isi', 'like', '%' . request('tag') . '%');
        } else {
            foreach (array_slice($filters, 0, 2) as $filter) {
                $q = $query->where('tag', 'like', '%' . $filter . '%')
                    ->orWhere('judul', 'like', '%' . $filter . '%');
            }

            return $q;
        }
    }

    public function scopeBackendFilter($query, array $filters)
    {
        $query->when($filters['cari'] ?? false, function ($query, $cari) {
            return $query->where('judul', 'like', '%' . $cari . '%');
        });
    }
}
