<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'foto_profil',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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

    /**
     * Get the adminlte image for AdminLTE user menu
     */
    public function adminlte_image()
    {
        if ($this->foto_profil) {
            return asset('storage/' . $this->foto_profil);
        }
        return null; // AdminLTE will use default avatar
    }

    /**
     * Get the adminlte desc for AdminLTE user menu
     */
    public function adminlte_desc()
    {
        return ucfirst($this->role);
    }

    /**
     * Get the adminlte profile url for AdminLTE user menu
     */
    public function adminlte_profile_url()
    {
        return route('profile');
    }
}
