<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalificacionLibrosPriorizacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calificacion_libros_priorizacions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('libro_priorizacion_id')->unsigned();
            $table->integer('libro_id')->unsigned();
            $table->integer('priorizacion')->unsigned();
            $table->integer('usuario_id')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calificacion_libros_priorizacions');
    }
}
