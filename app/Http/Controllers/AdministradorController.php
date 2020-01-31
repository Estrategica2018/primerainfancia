<?php

namespace App\Http\Controllers;

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
}
