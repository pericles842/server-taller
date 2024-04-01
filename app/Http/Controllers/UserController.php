<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\InventarioImplements\UserImplement;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Response;



class UserController extends Controller
{

    private $userImplement;

    public function __construct(UserImplement $userImplement)
    {
        $this->userImplement = $userImplement;
    }

    /**
     * Creacion de usuarios
     *
     * @param Request $request
     * 
     * @return array
     * 
     */
    public function createUser(Request $request)
    {
        try {
            if (!$request->filled('fulL_name')) throw new \Exception("Nombre es requerido", 400);
            if (!$request->filled('email')) throw new \Exception("Email es requerido", 400);
            if (!$request->filled('username')) throw new \Exception("Username es requerido", 400);
            if (!$request->filled('password')) throw new \Exception("Password es requerido", 400);
            if (!$request->filled('rol_id')) throw new \Exception("Rol es requerido", 400);


            $response =  $this->userImplement->createUser(
                DB::connection(),
                $request->fulL_name,
                $request->email,
                $request->ci,
                $request->direction,
                $request->username,
                $request->password,
                $request->rol_id
            );
        } catch (\Exception $e) {
            return $e;
        }

        return response($response, 200)->header('Content-Type', 'application/json');
    }

    /**
     * Autentica un usuario
     *
     * @param Request $request
     * 
     * @return [type]
     * 
     */
    public function authenticateUser(Request $request)
    {
        try {


            if (!$request->filled('username')) throw new \Exception("Username es requerido", 400);
            if (!$request->filled('password')) throw new \Exception("Password es requerido", 400);

            $response =  $this->userImplement->authenticateUser(
                DB::connection(),
                $request->only('username', 'password')
            );

            if (!empty($response->token)) {

                $cookie = cookie('token_user', $response->token); // 60 minutos de vida de la cookie
            }
        } catch (\Exception $e) {
            return $e;
        }

        return response([$response], 200)->header('Content-Type', 'application/json')->cookie($cookie);
    }

    /**
     * Logaut de la sesion
     *
     * @param Request $request
     * 
     * @return [type]
     * 
     */
    public function logoutUser()
    {
        // Eliminar la cookie 'token_user'
        $cookie = cookie()->forget('token_user');

        return response()->json(['message' => 'Sesión Cerrada exitosamente'], 200)->cookie($cookie);
    }
    /**
     *Ontiende un usuario
     *
     * @param mixed $param
     * 
     * @return [type]
     * 
     */
    public function getUser($param)
    {
        try {

            $response =  $this->userImplement->getUser(
                DB::connection(),
                $param
            );
        } catch (\Exception $e) {
            return $e;
        }

        return response([$response], 200)->header('Content-Type', 'application/json');
    }
}
