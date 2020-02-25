<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
Route::get('/', function () {
    return view('welcome');
});*/

Auth::routes();
Route::group(['middleware' => ['auth']],function (){


    Route::get('/administrador', 'AdministradorController@index')->name('administrador')->middleware('auth', 'role:administrador_plataforma');
    Route::get('usuarios_dt', 'AdministradorController@usuarios_dt')->name('usuarios_dt');
    Route::post('registrar_usuarios', 'AdministradorController@registrar_usuarios')->name('registrar_usuarios');
    Route::post('reiniciar_tablas', 'AdministradorController@reiniciar_tablas')->name('reiniciar_tablas')->middleware('auth', 'role:administrador_plataforma');
    Route::post('editar_usuario', 'AdministradorController@editar_usuario')->name('editar_usuario');
    Route::get('/administrador_priorizacion', 'AdministradorController@index_priorizacion')->name('administrador_priorizacion')->middleware('auth', 'role:administrador_plataforma');;
    Route::post('registrar_libros_administrador_para_priorizacion', 'AdministradorController@registrar_libros_administrador_para_priorizacion')->name('registrar_libros_administrador_para_priorizacion');
    Route::get('/historial_libros_usuario_dt/{userId?}/{tipoRegistro?}', 'AdministradorController@historial_libros_usuario_dt')->name('historial_libros_usuario_dt');


    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('libros_dt', 'HomeController@libros_dt')->name('libros_dt');
    Route::post('registrar_libros_para_comite', 'HomeController@registrar_libros_para_comite')->name('registrar_libros_para_comite');
    Route::post('registrar_cupos_edades_priorizacion', 'HomeController@registrar_cupos_edades_priorizacion')->name('registrar_cupos_edades_priorizacion');
    Route::post('registrar_libros_para_priorizacion', 'HomeController@registrar_libros_para_priorizacion')->name('registrar_libros_para_priorizacion');
    Route::post('registrar_cupos_genero_priorizacion', 'HomeController@registrar_cupos_genero_priorizacion')->name('registrar_cupos_genero_priorizacion');
    Route::post('elminar_libro_preseleccion', 'HomeController@elminar_libro_preseleccion')->name('elminar_libro_preseleccion');


    Route::get('/comite', 'ComiteController@index')->name('comite')->middleware('auth', 'role:administrador_plataforma,comite_educativo');
    Route::get('libros_preseleccion_dt', 'ComiteController@libros_preseleccion_dt')->name('libros_preseleccion_dt');
    Route::get('libros_priorizacion_dt', 'ComiteController@libros_priorizacion_dt')->name('libros_priorizacion_dt');
    Route::get('libros_preseleccion_usuarios_dt/{usuario?}', 'ComiteController@libros_preseleccion_usuarios_dt')->name('libros_preseleccion_usuarios_dt');


    Route::get('/priorizacion', 'PriorizacionController@index')->name('priorizacion')->middleware('auth', 'role:administrador_plataforma,usuario');
    Route::get('/priorizacion_resultado', 'PriorizacionController@priorizacion_resultado')->name('priorizacion_resultado')->middleware('auth', 'role:administrador_plataforma');
    Route::get('consultar_cupos_priorizacion/{tipo}', 'PriorizacionController@consultar_cupos_priorizacion')->name('consultar_cupos_priorizacion');
    Route::post('registrar_calificacion_priorizacion', 'PriorizacionController@registrar_calificacion_priorizacion')->name('registrar_calificacion_priorizacion');
    Route::get('resultado_libros_logistica_priorizacion_dt', 'PriorizacionController@resultado_libros_logistica_priorizacion_dt')->name('resultado_libros_logistica_priorizacion_dt');

    Route::post('eliminar_libro_priorizacion', 'AdministradorController@eliminar_libro_priorizacion')->name('eliminar_libro_priorizacion');


});
