<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Crypt;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'email',
        'telefono',
        'ciudad',
        'password',
        'rol'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function reserva()
    {
        return $this->hasMany(Reserva::class);
    }

    public function experiencia()
    {
        return $this->hasMany(Experiencia::class);
    }

    public function dime()
    {
        return $this->user;
    }

    public function getEncryptedId()
    {
        return Crypt::encryptString($this->id);
    }

    public function experienceCount()
    {
        if ($this->rol === 'proveedor') {
            return $this->experiencia()->count();
        }
        return 0; // Si no es proveedor, devuelve 0
    }

    public function reserveCount()
    {
        if ($this->rol === 'proveedor') {
            return Reserva::whereIn(
                'experiencia_id', 
                $this->experiencia()->pluck('id')
            )->count();
        }
        return 0; // Si no es proveedor, devuelve 0
    }
}
