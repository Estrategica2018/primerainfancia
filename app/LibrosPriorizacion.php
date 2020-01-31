<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LibrosPriorizacion extends Model
{
    //
    protected $table = "libros_priorizacions";

    public function libro (){

        return $this->belongsTo(Libros::class,'libro_id', 'id');

    }
}
