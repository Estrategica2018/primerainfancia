<?php

namespace App\Http\Controllers;

use App\EdadLectura;
use App\EdadLecturaPrioriza;
use App\GeneroPrioriza;
use App\Generos;
use App\HistorialRegistrosLibros;
use App\Libros;
use App\LibrosPreseleccion;
use App\LibrosPriorizacion;
use App\User;
use Illuminate\Database\Eloquent\Builder;
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

        if($request->user()->authorizeRoles(['ministerio']) || $request->user()->authorizeRoles(['administrador_plataforma'])){
            $libros = User::with('usuario_libros_registrados_preseleccion.libros')->whereHas('usuario_libros_registrados_preseleccion',function(Builder $query){
                $query->where('tipo_registro_id', '=', 1);//preselección
            })->first();
            if($libros===null){
                $libros = [];
            }else{
                $libros = $libros->usuario_libros_registrados_preseleccion->where('tipo_registro_id',1)->where('user_id',auth()->user()->id);
            }
            //dd($libros);
            return view('home')->with('libros',$libros);
        }
        if($request->user()->authorizeRoles(['comite_educativo'])){

            $libros = HistorialRegistrosLibros::where([
                ['tipo_registro_id', '=', 2],
                ['user_id', '=', auth()->user()->id]
            ])->get();
            $librosLiteraios = 0;
            $librosInformativos = 0;
            if($libros===null){
                $libros = [];
            }else{
                foreach($libros as $li){
                    if($li->libros->categoriaf->id == 1){
                        $librosInformativos++;
                    }else{
                        $librosLiteraios++;
                    }
                }
            }
            return view('comite')
                ->with('libros',$libros)
                ->with('librosInformativos',$librosInformativos)
                ->with('librosLiterarios',$librosLiteraios);
        }
        if($request->user()->authorizeRoles(['usuario'])){

            $libros = HistorialRegistrosLibros::where([
                ['tipo_registro_id', '=', 4],
                ['user_id', '=', auth()->user()->id]
            ])->get();
            if($libros===null){
                $libros = [];
            }
            return view('priorizacion')
                ->with('libros',$libros);
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
            ->addColumn('categoria', function ($libros) {
                return $libros->categoriaf->nombre;
            })

            ->make(true);
    }

    public function registrar_libros_para_comite (Request $request) {

        $objetolibros = json_decode($request->get('objetolibros'),true);

        //registrar_libros_para_comite

        foreach ($objetolibros as $objetolibro){
            if(!count(HistorialRegistrosLibros::where([
                ['libro_id',$objetolibro["id"]],
                ['user_id',auth()->user()->id],
                ['tipo_registro_id',1]

            ])->get()) ){
                $historial = new HistorialRegistrosLibros();
                $historial->libro_id = $objetolibro["id"];
                $historial->user_id = auth()->user()->id;
                $historial->observacion = $objetolibro["observacion"];
                $historial->tipo_registro_id = 1;
                $historial->save();
            }
            if(!count(LibrosPreseleccion::where('libro_id',$objetolibro["id"])->get()) ){
                $preseleccion = new LibrosPreseleccion();
                $preseleccion->libro_id = $objetolibro["id"];
                $preseleccion->observacion = $objetolibro["observacion"];
                $preseleccion->user_id = auth()->user()->id;
                $preseleccion->save();
            }
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

            if(!count(HistorialRegistrosLibros::where([
                ['libro_id',$objetolibro["libro_id"]],
                ['user_id',auth()->user()->id],
                ['tipo_registro_id',2]

            ])->get()) ){
                $historial = new HistorialRegistrosLibros();
                $historial->libro_id = $objetolibro["libro_id"];
                $historial->user_id = auth()->user()->id;
                $historial->tipo_registro_id = 2;
                $historial->save();
            }
/*
            if(!count(LibrosPriorizacion::where('libro_id',$objetolibro["libro_id"])->get()) ) {
                $preseleccion = new LibrosPriorizacion();
                $preseleccion->libro_preseleccionado_id = $objetolibro["id"];
                $preseleccion->libro_id = $objetolibro["libro_id"];
                $preseleccion->save();
            }
*/
        }
        return response()->json(
            'preselección de libros exitosa!',
            200
        );

    }

    public function registrar_cupos_genero_priorizacion (Request $request) {

        $objectCupos = json_decode($request->get('objectCupos'),true);

        foreach ($objectCupos as $objectCupo){
            $edadLectura = new GeneroPrioriza();
            $edadLectura->genero_id = $objectCupo['id'];
            $edadLectura->cupo = $objectCupo['cupo'];
            $edadLectura->save();
        }

        return response()->json(
            'cupos asignados exitosamente!',
            200
        );
    }

    public function elminar_libro_preseleccion (Request $request) {

        $libro = HistorialRegistrosLibros::where([
            ['libro_id',$request->get('libro_id')],
            ['user_id',auth()->user()->id],
            ['tipo_registro_id',$request->get('tipo_lista')]

        ])->delete();

        if(!count(HistorialRegistrosLibros::where([
            ['libro_id',$request->get('libro_id')],
            ['tipo_registro_id',$request->get('tipo_lista')]

        ])->get())){

            switch (intval($request->get('tipo_lista'))){
                case 1:
                    $libro = LibrosPreseleccion::where('libro_id',$request->get('libro_id'))->delete();
                break;
                case 2:
                    //$libro = LibrosPreseleccion::where('libro_id',$request->get('libro_id'))->delete();
                break;
            }


        }

    }
}
