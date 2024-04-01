<?php

namespace App\Http\InventarioImplements;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class UserImplement
{

    /**
     *Creación de usuario
     *
     * @param mixed $connection
     * @param mixed $fulL_name
     * @param mixed $email
     * @param mixed $direction
     * @param mixed $username
     * @param mixed $password
     * @param mixed $rol_id
     * 
     * @return array
     * 
     */
    public function createUser(
        $connection,
        $fulL_name,
        $email,
        $ci,
        $direction,
        $username,
        $password,
        $rol_id
    ) {
        $data = [
            "fulL_name" => $fulL_name,
            "email" => $email,
            "ci" => $ci,
            "direction" => $direction,
            "username" => $username,
            "password" => trim(bcrypt($password)),
            "rol_id" => $rol_id
        ];
        $data['id'] = $connection->table('usuarios')->insertGetId($data);

        return $data;
    }

    /**
     *Busca un usuario por user     
     *
     * @param mixed $connection
     * @param mixed $username
     * 
     * @return array
     * 
     */
    public function getUser($connection, $username)
    {
        return  $connection->selectOne("SELECT user.id,
                                        user.fulL_name,
                                        user.email,
                                        user.ci,
                                        user.direction,
                                        user.username,
                                        roles.name 
                                    FROM usuarios user 
                                    iNNER JOIN roles 
                                        ON roles.id = user.rol_id 
                                    WHERE user.username = :username", ["username" => $username]);
    }

    /**
     *Autenticar usuario
     *
     * @param mixed $connection
     * @param mixed $credentials
     * 
     * @return object
     * 
     */
    public function authenticateUser($connection, $credentials)
    {

        if (Auth::attempt($credentials)) {

            $user  = (object) self::getUser($connection,$credentials['username']);
            $user->token = Str::random(60);

            return  $user;
        } else {
            return response()->json(['error' => 'Credenciales inválidas'], 401);
        }
    }
}
