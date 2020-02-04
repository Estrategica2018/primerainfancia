<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistorialRegistrosLibros extends Model
{
    //
    protected $table = "historial_registros_libros";

    public function libros () {
        return $this->belongsTo(Libros::class,'libro_id', 'id');
    }
}
