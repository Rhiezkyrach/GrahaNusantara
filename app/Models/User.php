<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Eloquent Relations
    public function berita(){
        return $this->hasMany(Berita::class);
    }

    public function Network(){
        return $this->belongsTo(Network::class, 'id_network');
    }

    public function Reporter(){
        return $this->belongsTo(Reporter::class, 'id', 'id_user');
    }

    static public function showUser($id_network)
    {
        $q = User::where('id_network', $id_network)
                    ->orderBy('name', 'asc');

        return $q;
    }

    static public function showActiveUser($id_network)
    {
        $q = User::where('status', '1')
                ->where('id_network', $id_network)
                ->orderBy('name', 'asc');

        return $q;
    }

    static public function showAllUser()
    {
        $q = User::orderBy('name', 'asc');

        return $q;
    }

    static public function showAllActiveUser()
    {
        $q = User::where('status', '1')
                ->orderBy('name', 'asc')
                ->get();

        return $q;
    }
}
