<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Libros extends Model
{
    //
    protected $table = "libros";

    public function generof () {

        return $this->belongsTo(Generos::class,'genero', 'id');
    }

    public function edadf () {

        return $this->belongsTo(EdadLectura::class,'nivel_lectura', 'id');
    }

    public function categoriaf () {
        //dd('ingresa');
        return $this->belongsTo(CategoriaLibros::class,'categoria', 'id');
    }
}
