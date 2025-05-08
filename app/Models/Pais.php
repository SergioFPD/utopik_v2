<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Pais extends Model
{
    use HasFactory;

    protected $table = 'paises';

    protected $fillable = [
        'pais',
        'descripcion',
        'activo',
        'imagen',
    ];

    public function ciudad()
    {
        return $this->hasMany(Ciudad::class);
    }

    public function getEncryptedId()
    {
        return Crypt::encryptString($this->id);
    }
}
