<?php

namespace App\Http\Controllers;

use App\EdadLectura;
use App\EdadLecturaPrioriza;
use App\Generos;
use App\LibrosPreseleccion;
use App\LibrosPriorizacion;
use App\User;
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
            $hiddenEdad = "hidden";
            $hiddenGenero = "hidden";
            if(count(EdadLecturaPrioriza::all())){
                $registroPriorizacion = true;
                $tipoPriorizacion = "rango_edad";
                $disabled = "disabled";
                $hiddenEdad = "";
            }

            return view('comite')
                ->with('generos',$generos)
                ->with('registroPriorizacion',$registroPriorizacion)
                ->with('edadeslecturas',$edadeslecturas)
                ->with('tipoPriorizacion',$tipoPriorizacion)
                ->with('hiddenEdad',$hiddenEdad)
                ->with('hiddenGenero',$hiddenGenero)
                ->with('disabled',$disabled)
                ->with('usuarios',$usuarios);
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
            ->addColumn('genero', function ($libros) {
                return $libros->libro->generof->nombre;
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
            ->addColumn('observacion', function ($libros) {
                return $libros->observacion;
            })
            ->make(true);
    }
}
