<?php

namespace App\Http\Controllers;

use App\CalificacionLibrosPriorizacion;
use App\EdadLectura;
use App\EdadLecturaPrioriza;
use App\Generos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;


class PriorizacionController extends Controller
{
    //
    public function index(Request $request) {
        if($request->user()->authorizeRoles(['usuario'])){

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
            return view('priorizacion')
                ->with('generos',$generos)
                ->with('registroPriorizacion',$registroPriorizacion)
                ->with('edadeslecturas',$edadeslecturas)
                ->with('tipoPriorizacion',$tipoPriorizacion)
                ->with('hiddenEdad',$hiddenEdad)
                ->with('hiddenGenero',$hiddenGenero)
                ->with('disabled',$disabled);
        }
    }


    public function consultar_cupos_priorizacion (Request $request, $tipo){
        if($request->user()->authorizeRoles(['usuario'])){
            if($tipo == 1){
                return response()->json(
                    EdadLecturaPrioriza::all(),
                    200
                );
            }
        }

    }

    public function registrar_calificacion_priorizacion (Request $request){
        /*

        );
        */
        if($request->user()->authorizeRoles(['usuario'])){

            $objetolibros = json_decode($request->get('objetolibros'),true);
            foreach ($objetolibros as $objetolibro){

                $calificacion = new CalificacionLibrosPriorizacion();
                    $calificacion->libro_priorizacion_id = $objetolibro['id'];
                    $calificacion->libro_id = $objetolibro['libro_id'];
                    $calificacion->priorizacion = $objetolibro['priorizacion'];
                    $calificacion->usuario_id = auth()->user()->id;
                $calificacion->save();

            }
            return response()->json(
                'preselección de libros exitosa!',
                200
            );
        }

    }

    public function  priorizacion_resultado (Request $request) {

        $resultado = DB::table('calificacion_libros_priorizacions as o')
            ->join('libros as od', 'od.id', '=', 'o.libro_id')
            ->join('generos as g', 'g.id', '=', 'od.genero')
            ->join('edad_lecturas as e', 'e.id', '=', 'od.nivel_lectura')
            ->selectRaw('*,e.nombre as nom_edad,g.nombre as nom_genero, sum(o.priorizacion) as sum')
            ->groupBy('o.libro_id')
            ->orderBy('sum', 'desc')
            ->get();

        $categorias = EdadLecturaPrioriza::all();
        $objeto = array();
        foreach ($categorias as $categoria){
            foreach ($resultado->where('nivel_lectura',$categoria->edad_lectura_id)->take($categoria->cupo)->all() as $item){
                array_push($objeto,$item);
            }

        }
        $objeto = collect($objeto);
        $unique = $objeto->unique()->sortBy('sum',  SORT_REGULAR,  true);
        return view('priorizacion_resultado')
            ->with('objeto',$unique);

    }

    public function resultado_libros_logistica_priorizacion_dt () {

        $resultado = DB::table('calificacion_libros_priorizacions as o')
            ->join('libros as od', 'od.id', '=', 'o.libro_id')
            ->join('generos as g', 'g.id', '=', 'od.genero')
            ->join('edad_lecturas as e', 'e.id', '=', 'od.nivel_lectura')
            ->selectRaw('*,e.nombre as nom_edad,g.nombre as nom_genero, sum(o.priorizacion) as sum')
            ->groupBy('o.libro_id')
            ->orderBy('sum', 'desc')
            ->get();

        return Datatables::of($resultado)

            ->addColumn('isbn', function ($libros) {
                return $libros->isbn;
            })
            ->addColumn('titulo', function ($libros) {
                return $libros->titulo;
            })
            ->addColumn('autor', function ($libros) {
                return $libros->autor;
            })
            ->addColumn('editorial', function ($libros) {
                return $libros->editorial;
            })
            ->addColumn('proveedor', function ($libros) {
                return $libros->proveedor;
            })
            ->addColumn('nivel_lectura', function ($libros) {
                return $libros->nom_edad;
            })
            ->addColumn('genero', function ($libros) {
                return $libros->nom_genero;
            })
            ->addColumn('resultado', function ($libros) {
                return $libros->sum;
            })

            ->make(true);

    }

}
