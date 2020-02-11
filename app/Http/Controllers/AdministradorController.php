<?php

namespace App\Http\Controllers;

use App\CalificacionLibrosPriorizacion;
use App\EdadLectura;
use App\EdadLecturaPrioriza;
use App\GeneroPrioriza;
use App\Generos;
use App\HistorialRegistrosLibros;
use App\LibrosPreseleccion;
use App\LibrosPriorizacion;
use App\Role;
use App\RoleUser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class AdministradorController extends Controller
{
    //
    public function index(Request $request){

        $roles = Role::all();

        return view('administrador')
           ->with('roles',$roles);

    }

    public function usuarios_dt(Request $request){

        $usuarios = User::all();

        return Datatables::of($usuarios)

            ->addColumn('nombre', function ($usuario) {
                return $usuario->name;
            })
            ->addColumn('cedula', function ($usuario) {
                return $usuario->numero_identificacion;
            })
            ->addColumn('correo', function ($usuario) {
                return $usuario->email;
            })
            ->addColumn('entidad', function ($usuario) {
                return $usuario->entidad;
            })
            ->addColumn('cargo', function ($usuario) {
                return $usuario->cargo;
            })
            ->addColumn('accion', function () {
                return  '<button type="button" class="btn btn-warning btn-sm editar">Editar</button>';
            })
            ->addColumn('roles', function ($usuario) {
                $rol = "";
                foreach ($usuario->roles as $role){
                    $rol = $rol.''.$role->description.',';
                }
                return  $rol;
            })
            ->addColumn('roles_id', function ($usuario) {
                $rol = "";
                foreach ($usuario->roles as $role){
                    $rol = $rol.''.$role->id.',';
                }
                return  $rol;
            })
            ->rawColumns(['accion'])
            ->make(true);

    }

    public function registrar_usuarios (Request $request){

        $user = new User();
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = Hash::make($request->get('password1'));
        $user->entidad = $request->get('entidad');
        $user->cargo = $request->get('cargo');
        $user->numero_identificacion = $request->get('numero_identificacion');
        $user->save();
        $roles = explode(",",$request->get('roles'));

        foreach ($roles as $role){
            $roleUser = new RoleUser();
            $roleUser->role_id = $role;
            $roleUser->user_id = $user->id;
            $roleUser->save();
        }
        return response()->json(
            'usuario creado!',
            200
        );

    }

    public function reiniciar_tablas (){

        CalificacionLibrosPriorizacion::getQuery()->delete();
        EdadLecturaPrioriza::getQuery()->delete();
        GeneroPrioriza::getQuery()->delete();
        LibrosPriorizacion::getQuery()->delete();
        LibrosPreseleccion::getQuery()->delete();

    }

    public function editar_usuario (Request $request){

        $user = User::find($request->get('id'));
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->entidad = $request->get('entidad');
        $user->cargo = $request->get('cargo');
        $user->numero_identificacion = $request->get('numero_identificacion');
        $user->save();
        $roles = explode(",",$request->get('roles'));
        RoleUser::where('user_id',$request->get('id'))->delete();
        foreach ($roles as $role){
            $roleUser = new RoleUser();
            $roleUser->role_id = $role;
            $roleUser->user_id = $user->id;
            $roleUser->save();
        }
        return response()->json(
            'usuario editado!',
            200
        );
    }

    public function index_priorizacion(){

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

        //$informativo = 0;
        //$literario = 0;

        $informativoPorcentaje = count(HistorialRegistrosLibros::whereHas('libros',function ($query){
            return $query->where('categoria',1);
        })->where([
            ['tipo_registro_id', '=', 3],
        ])->get()); /// 220) * 100;
        $literarioPorcentaje = count(HistorialRegistrosLibros::whereHas('libros',function ($query){
            return $query->where('categoria',2);
        })->where([
            ['tipo_registro_id', '=', 3],
        ])->get());// / 220) *100;

        //dd($informativoPorcentaje,$literarioPorcentaje);


        return view('admin_priorizacion')
            ->with('generos',$generos)
            ->with('registroPriorizacion',$registroPriorizacion)
            ->with('edadeslecturas',$edadeslecturas)
            ->with('tipoPriorizacion',$tipoPriorizacion)
            ->with('hiddenEdad',$hiddenEdad)
            ->with('hiddenGenero',$hiddenGenero)
            ->with('disabled',$disabled)
            ->with('usuarios',$usuarios)
            ->with('libros',$libros)
            ->with('informativoPorcentaje',$informativoPorcentaje)
            ->with('literarioPorcentaje',$literarioPorcentaje);

    }

    public function registrar_libros_administrador_para_priorizacion (Request $request){

        $objetolibros = json_decode($request->get('objetolibros'),true);

        foreach ($objetolibros as $objetolibro ){

            if(!count(HistorialRegistrosLibros::where([
                ['libro_id',$objetolibro["libro_id"]],
                ['user_id',auth()->user()->id],
                ['tipo_registro_id',3]

            ])->get()) ){
                $historial = new HistorialRegistrosLibros();
                $historial->libro_id = $objetolibro["libro_id"];
                $historial->user_id = auth()->user()->id;
                $historial->tipo_registro_id = 3;
                $historial->save();
            }

            if(!count(LibrosPriorizacion::where('libro_id',$objetolibro["libro_id"])->get()) ) {
                $preseleccion = new LibrosPriorizacion();
                $preseleccion->libro_preseleccionado_id = $objetolibro["id"];
                $preseleccion->libro_id = $objetolibro["libro_id"];
                $preseleccion->save();
            }
        }

    }

    public function historial_libros_usuario_dt ($userId,$tipoRegistro) {

        $libros = HistorialRegistrosLibros::where([
            ['user_id',$userId],
            ['tipo_registro_id',$tipoRegistro],
        ])->get();

        return Datatables::of($libros)

            ->addColumn('isbn', function ($libros) {
                return $libros->libros->isbn;
            })
            ->addColumn('titulo', function ($libros) {
                return $libros->libros->titulo;
            })
            ->addColumn('autor', function ($libros) {
                return $libros->libros->autor;
            })
            ->addColumn('editorial', function ($libros) {
                return $libros->libros->editorial;
            })
            ->addColumn('proveedor', function ($libros) {
                return $libros->libros->proveedor;
            })
            ->addColumn('nivel_lectura', function ($libros) {
                return $libros->libros->edadf->nombre;
            })
            ->addColumn('genero', function ($libros) {
                return $libros->libros->generof->nombre;
            })
            ->addColumn('categoria', function ($libros) {
                return $libros->libros->categoriaf->nombre;
            })
            ->make(true);

    }
}
