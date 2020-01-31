<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LibrosPreseleccion extends Model
{
    //
    public function libro (){

        return $this->belongsTo(Libros::class,'libro_id', 'id');

    }
}
