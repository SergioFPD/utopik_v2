<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    use HasFactory;

    // Tabla a la que se refiere (porque en este caso se añade -es a ciudad)
    protected $table = 'ciudades';

    protected $fillable = [
        'ciudad',
        'latitud',
        'longitud',
        'pais_id'
    ];

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function pais()
    {
        return $this->belongsTo(Pais::class);
    }

    public function experiencia()
    {
        return $this->hasMany(Experiencia::class);
    }
}
