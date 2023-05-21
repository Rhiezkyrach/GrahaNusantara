<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Berita extends Model
{
    use HasFactory, Sluggable;

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
    public function kategori(){
        return $this->belongsTo(Kategori::class, 'id_channel');
    }

    public function reporter(){
        return $this->belongsTo(Reporter::class, 'id_wartawan', 'id_wartawan');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function galeri(){
        return $this->hasMany(Galeri::class, 'id_berita');
    }

    // All Frontend Model
    static public function headlines(){
        $q = Berita::where('headline', 1)
                    ->where('publish', 1)
                    ->whereRaw('TIMESTAMP(tanggal_tayang, waktu) <= NOW()')
                    ->orderBy('tanggal_tayang', 'DESC')
                    ->orderBy('waktu', 'DESC')
                    ->limit(5)
                    ->get();

        return $q;
    }

    static public function terkini(){
        $q = Berita::where('publish', 1)
                    ->whereRaw('TIMESTAMP(tanggal_tayang, waktu) <= NOW()')
                    ->orderBy('tanggal_tayang', 'DESC')
                    ->orderBy('waktu', 'DESC');

        return $q;
    }

    static public function kategoriTerkini(){
        $q = Berita::where('publish', 1)
                    ->whereRaw('TIMESTAMP(tanggal_tayang, waktu) <= NOW()')
                    ->orderBy('tanggal_tayang', 'DESC')
                    ->orderBy('waktu', 'DESC');


        return $q;
    }

    static public function trending(){
        $q = Berita::where('publish', 1)
                    ->whereRaw('TIMESTAMP(tanggal_tayang, waktu) > date_sub(now(), interval 3 day)')
                    ->orderBy('counter', 'DESC')
                    ->limit(5)
                    ->get();

        return $q;
    }

    static public function populer(){
        $q = Berita::where('publish', 1)
                    ->whereRaw('TIMESTAMP(tanggal_tayang, waktu) > date_sub(now(), interval 7 day)')
                    ->orderBy('counter', 'DESC')
                    ->limit(10)
                    ->get();

        return $q;
    }

    static public function beranda($kategori){
        $q = Berita::where('publish', 1)
                    ->whereHas('kategori', function($query) use ($kategori){
                            return $query->where('nama', $kategori);
                        })
                    ->whereRaw('TIMESTAMP(tanggal_tayang, waktu) <= NOW()')
                    ->orderBy('tanggal_tayang', 'DESC')
                    ->orderBy('waktu', 'DESC');

        return $q;
    }

     static public function indeks($tanggal){
        $q = Berita::where('publish', 1)
                    ->whereRaw('TIMESTAMP(tanggal_tayang, waktu) <= NOW()')
                    ->where('tanggal_tayang', $tanggal)
                    ->orderBy('tanggal_tayang', 'DESC')
                    ->orderBy('waktu', 'DESC');

        return $q;
    }

    static public function beritaFoto() {
        $q = Berita::hasIn('galeri')
            ->whereRaw('TIMESTAMP(tanggal_tayang, waktu) <= NOW()')
            ->orderBy('tanggal_tayang', 'DESC')
            ->orderBy('waktu', 'DESC');
        
        return $q;
    }

    static public function beritaPrev($id) {
        $q = Berita::where('publish', 1)
                    ->whereRaw('TIMESTAMP(tanggal_tayang, waktu) <= NOW()')
                    ->where('id_berita', '<' , $id)
                    ->orderBy('id_berita', 'DESC')
                    ->first();
        
        return $q;
    }

    static public function beritaNext($id) {
        $q = Berita::where('publish', 1)
                    ->whereRaw('TIMESTAMP(tanggal_tayang, waktu) <= NOW()')
                    ->where('id_berita', '>' , $id)
                    ->orderBy('id_berita', 'ASC')
                    ->first();
        
        return $q;
    }

    static public function terkait(){
        $q = Berita::where('publish', 1)
                    ->whereRaw('TIMESTAMP(tanggal_tayang, waktu) <= NOW()')
                    ->whereRaw('TIMESTAMP(tanggal_tayang, waktu) > date_sub(now(), interval 6 month)')
                    ->orderBy('tanggal_tayang', 'DESC')
                    ->orderBy('waktu', 'DESC');

        return $q;
    }


    //  static public function pembaca(){
    //     $q = Berita::whereRaw('TIMESTAMP(tanggal_tayang, waktu) > date_sub(now(), interval 7 day)')
    //                 ->selectRaw("SUM(counter) as total_counter")
    //                 ->groupBy('tanggal_tayang')
    //                 ->orderBy('tanggal_tayang', 'DESC')
    //                 ->get();

    //     return $q;
    // }

    // All Backend Model
    static public function showAllBerita(){
        $q = Berita::orderBy('tanggal_tayang', 'DESC')
                    ->orderBy('waktu', 'DESC');

        return $q;
    }

    static public function listTayang(){
        $q = Berita::where('publish', 0)
            // ->whereRaw('TIMESTAMP(tanggal_tayang, waktu) >= NOW()')
            ->orderBy('tanggal_tayang', 'desc')
            ->orderBy('waktu', 'desc')
            ->limit(10)
            ->get();

         return $q;   
    }

    static public function beritaPerTanggal($start, $end){
        $q = Berita::whereBetween('tanggal_tayang', [$start, $end])
                    ->orderBy('tanggal_tayang', 'asc')
                    ->orderBy('waktu', 'asc');
                    
        return $q;
    }

    //scope
    public function scopeFilter($query, array $filters){
        // dd($filters);
        if(isset($filters['cari']) ? $filters['cari'] : false){
            return $query->where('judul', 'like' , '%' . request('cari') . '%')
                        ->orWhere('isi', 'like' , '%' . request('cari') . '%');
        } elseif (isset($filters['tag']) ? $filters['tag'] : false){
            return $query->where('tag', 'like' , '%' . request('tag') . '%')
                        ->orWhere('judul', 'like' , '%' . request('tag') . '%')
                        ->orWhere('isi', 'like' , '%' . request('tag') . '%');
        } else {
            foreach(array_slice($filters, 0, 2) as $filter){
                $q = $query->where('tag', 'like' , '%' . $filter . '%')
                            ->orWhere('judul', 'like' , '%' . $filter . '%');
            }

            return $q;
        }   
    }

    public function scopeBackendFilter($query, array $filters){
        $query->when($filters['cari'] ?? false, function($query, $cari){
            return $query->where('judul', 'like', '%' .$cari. '%');
        });

    }
}
