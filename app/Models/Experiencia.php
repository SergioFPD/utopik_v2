<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Experiencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'descripcion_corta',
        'vip',
        'activa',
        'duracion',
        'precio_adulto',
        'precio_nino',
        'ciudad_id',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tipo()
    {
        return $this->belongsTo(Tipo::class);
    }

    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class);
    }

    public function actividad()
    {
        return $this->hasMany(Actividad::class);
    }

    public function reserva()
    {
        return $this->hasMany(Reserva::class);
    }

    public function exp_fecha()
    {
        return $this->hasMany(Exp_fecha::class);
    }

    public function imagen()
    {
        return $this->hasMany(Imagen::class);
    }

    public function getEncryptedId()
    {
        return Crypt::encryptString($this->id);
    }

    public function firstImage()
    {
        return $this->imagen->first();
    }

    public function getFormatedPrice()
    {

        // Convertir a entero
        $entero = (int)$this->precio_adulto;

        // Dar formato con punto de miles
        $formateado = number_format($entero, 0, '.', '.');

        return $formateado;
    }

    public function getFormatedPriceChild()
    {

        // Convertir a entero
        $entero = (int)$this->precio_nino;

        // Dar formato con punto de miles
        $formateado = number_format($entero, 0, '.', '.');

        return $formateado;
    }
}
