<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Reserva extends Model
{
    use HasFactory;

    protected $fillable = [
        'adultos',
        'menores',
        'confirmado',
        'puntuacion',
        'experiencia_id',
        'exp_fecha_id',
        'user_id'
    ];

    public function dimePrecioTotal(){
        $adultos = $this->adultos;
        $menores = $this->menores;
        $precioAdulto = $this->experiencia->precio_adulto;
        $precioMenor = $this->experiencia->precio_nino;

        $total = ($adultos*$precioAdulto)+($menores*$precioMenor);

        // $formateado = number_format($total, 0, '.', '.');
        return $total;
    }

    public function dimePrecioReserva(){
        $adultos = $this->adultos;
        $menores = $this->menores;
        return ($adultos+$menores)*395;
    }

    public function dimePorPagar(){
        return $this->dimePrecioTotal()-$this->dimePrecioReserva();
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function experiencia()
    {
        return $this->belongsTo(Experiencia::class);
    }

    public function exp_fecha()
    {
        return $this->belongsTo(Exp_fecha::class);
    }

    public function getEncryptedId()
    {
        return Crypt::encryptString($this->id);
    }
}
