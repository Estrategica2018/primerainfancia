<?php

namespace App\Http\Controllers;

use App\EdadLectura;
use App\EdadLecturaPrioriza;
use App\Generos;
use App\Libros;
use App\LibrosPreseleccion;
use App\LibrosPriorizacion;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if($request->user()->authorizeRoles(['ministerio'])){
            //return redirect()->route('home');
            return view('home');
        }
        if($request->user()->authorizeRoles(['comite_educativo'])){
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
                ->with('disabled',$disabled);
        }
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

    public function libros_dt(Request $request){

        $libros = Libros::all();

        return Datatables::of($libros)

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
                return $libros->edadf->nombre;
            })
            ->addColumn('genero', function ($libros) {
                return $libros->generof->nombre;
            })

            ->make(true);
    }

    public function registrar_libros_para_comite (Request $request) {

        $objetolibros = json_decode($request->get('objetolibros'),true);

        foreach ($objetolibros as $objetolibro){
            $preseleccion = new LibrosPreseleccion();
            $preseleccion->libro_id = $objetolibro["id"];
            $preseleccion->observacion = $objetolibro["observacion"];
            $preseleccion->user_id = auth()->user()->id;
            $preseleccion->save();

        }
        return response()->json(
            'preselección de libros exitosa!',
            200
        );
    }

    public function registrar_cupos_edades_priorizacion (Request $request){

        $objectCupos = json_decode($request->get('objectCupos'),true);

        foreach ($objectCupos as $objectCupo){
            $edadLectura = new EdadLecturaPrioriza();
            $edadLectura->edad_lectura_id = $objectCupo['id'];
            $edadLectura->cupo = $objectCupo['cupo'];
            $edadLectura->save();
        }

        return response()->json(
            'cupos asignados exitosamente!',
            200
        );
    }

    public function registrar_libros_para_priorizacion (Request $request){

        $objetolibros = json_decode($request->get('objetolibros'),true);

        foreach ($objetolibros as $objetolibro){
            $preseleccion = new LibrosPriorizacion();
            $preseleccion->libro_preseleccionado_id = $objetolibro["id"];
            $preseleccion->libro_id = $objetolibro["libro_id"];
            $preseleccion->save();

        }
        return response()->json(
            'preselección de libros exitosa!',
            200
        );

    }
}
