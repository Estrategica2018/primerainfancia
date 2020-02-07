<?php

namespace App\Http\Controllers;

use App\EdadLectura;
use App\EdadLecturaPrioriza;
use App\GeneroPrioriza;
use App\Generos;
use App\HistorialRegistrosLibros;
use App\LibrosPreseleccion;
use App\LibrosPriorizacion;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ComiteController extends Controller
{
    //

    public function index(Request $request){
        if($request->user()->authorizeRoles(['comite_educativo','administrador_plataforma'])){

            $usuarios = User::Has('libros_preseleccion')->get();
            $generos = Generos::all();
            $edadeslecturas = EdadLectura::all();
            $registroPriorizacion = false;
            $tipoPriorizacion = "";
            $disabled = "";
            $hiddenEdad = "";
            $hiddenGenero = "hidden";
            if(count(EdadLecturaPrioriza::all())){
                $registroPriorizacion = true;
                $tipoPriorizacion = "rango_edad";
                $disabled = "disabled";
                $hiddenEdad = "";
            }else{
                if(count(GeneroPrioriza::all())){
                    $registroPriorizacion = true;
                    $tipoPriorizacion = "rango_genero";
                    $disabled = "disabled";
                    $hiddenGenero = "";
                    $hiddenEdad = "hidden";
                }
            }

            $libros = HistorialRegistrosLibros::where([
                ['tipo_registro_id', '=', 2],
                ['user_id', '=', auth()->user()->id]
            ])->get();
            if($libros===null){
                $libros = [];
            }
            return view('comite')
                ->with('generos',$generos)
                ->with('registroPriorizacion',$registroPriorizacion)
                ->with('edadeslecturas',$edadeslecturas)
                ->with('tipoPriorizacion',$tipoPriorizacion)
                ->with('hiddenEdad',$hiddenEdad)
                ->with('hiddenGenero',$hiddenGenero)
                ->with('disabled',$disabled)
                ->with('usuarios',$usuarios)
                ->with('libros',$libros);
        }

    }

    public function libros_preseleccion_dt (Request $request) {

        $librosPreseleccionados = LibrosPreseleccion::all();

        return Datatables::of($librosPreseleccionados)

            ->addColumn('isbn', function ($libros) {
                return $libros->libro->isbn;
            })
            ->addColumn('titulo', function ($libros) {
                return $libros->libro->titulo;
            })
            ->addColumn('autor', function ($libros) {
                return $libros->libro->autor;
            })
            ->addColumn('editorial', function ($libros) {
                return $libros->libro->editorial;
            })
            ->addColumn('proveedor', function ($libros) {
                return $libros->libro->proveedor;
            })
            ->addColumn('nivel_lectura', function ($libros) {
                return $libros->libro->edadf->nombre;
            })
            ->addColumn('categoria', function ($libros) {
                return $libros->libro->categoriaf->nombre;
            })
            ->addColumn('genero', function ($libros) {
                return $libros->libro->generof->nombre;
            })
            ->addColumn('coincidenciapre', function ($libros) {
                return count(HistorialRegistrosLibros::where([
                    ['libro_id',$libros->libro_id],
                    ['tipo_registro_id',1]
                ])->get());
            })
            ->addColumn('coincidenciacom', function ($libros) {
                return count(HistorialRegistrosLibros::where([
                    ['libro_id',$libros->libro_id],
                    ['tipo_registro_id',2]
                ])->get());
            })
            ->addColumn('categoria_id', function ($libros) {
                return $libros->libro->categoria_id;
            })
            ->make(true);

    }

    public function libros_priorizacion_dt (){

        $librosPreseleccionados = LibrosPriorizacion::all();

        return Datatables::of($librosPreseleccionados)

            ->addColumn('isbn', function ($libros) {
                return $libros->libro->isbn;
            })
            ->addColumn('titulo', function ($libros) {
                return $libros->libro->titulo;
            })
            ->addColumn('autor', function ($libros) {
                return $libros->libro->autor;
            })
            ->addColumn('editorial', function ($libros) {
                return $libros->libro->editorial;
            })
            ->addColumn('proveedor', function ($libros) {
                return $libros->libro->proveedor;
            })
            ->addColumn('nivel_lectura', function ($libros) {
                return $libros->libro->edadf->nombre;
            })
            ->addColumn('genero', function ($libros) {
                return $libros->libro->generof->nombre;
            })
            ->addColumn('nivel_id', function ($libros) {
                return $libros->libro->nivel_lectura;
            })
            ->addColumn('genero_id', function ($libros) {
                return $libros->libro->genero;
            })
            ->addColumn('priorizacion', function ($libros) {
                return '<span class="badge badge-light">Sin priorizar</span>';
            })
            ->addColumn('evaluar', function ($libros) {
                return  '<button type="button" class="btn btn-info btn-sm evaluardt">Evaluar</button>';
            })
            ->rawColumns(['priorizacion','evaluar'])
            ->make(true);

    }

    public function libros_preseleccion_usuarios_dt (Request $request, $userId) {

       $librosPreseleccionados =  LibrosPreseleccion::where('user_id',$userId)->get();

        return Datatables::of($librosPreseleccionados)

            ->addColumn('isbn', function ($libros) {
                return $libros->libro->isbn;
            })
            ->addColumn('titulo', function ($libros) {
                return $libros->libro->titulo;
            })
            ->addColumn('autor', function ($libros) {
                return $libros->libro->autor;
            })
            ->addColumn('editorial', function ($libros) {
                return $libros->libro->editorial;
            })
            ->addColumn('proveedor', function ($libros) {
                return $libros->libro->proveedor;
            })
            ->addColumn('nivel_lectura', function ($libros) {
                return $libros->libro->edadf->nombre;
            })
            ->addColumn('genero', function ($libros) {
                return $libros->libro->generof->nombre;
            })
            ->addColumn('categoria', function ($libros) {
                return $libros->categoriaf->nombre;
            })
            ->make(true);
    }
}
