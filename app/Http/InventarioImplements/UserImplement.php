<?php

namespace App\Http\InventarioImplements;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;


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
            "password" => trim(Crypt::encryptString($password)),
            "rol_id" => $rol_id
        ];
        $data['id'] = $connection->table('usuarios')->insertGetId($data);

        return $data;
    }

    /**
     *Actualiza un registro de usuario
     *
     * @param mixed $connection
     * @param mixed $id
     * @param mixed $fulL_name
     * @param mixed $email
     * @param mixed $ci
     * @param mixed $direction
     * @param mixed $username
     * @param mixed $password
     * @param mixed $rol_id
     * 
     * @return array
     * 
     */
    function updateUser(
        $connection,
        $id,
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
            "password" => trim(Crypt::encryptString($password)),
            "rol_id" => $rol_id
        ];

        $connection->table('usuarios')->where('id', $id)->update($data);

        return $data;
    }

    /**
     * elimina un usuario   
     *
     * @param mixed $connection
     * @param mixed $id
     * 
     * @return array
     * 
     */
    function deleteUser($connection, $id)
    {
        return  $connection->table('usuarios')->where('id', $id)->delete();
    }

    /**
     * Crea y actualiza dinamicamente 
     *
     * @param mixed $connection
     * @param mixed $id
     * @param mixed $fulL_name
     * @param mixed $email
     * @param mixed $ci
     * @param mixed $direction
     * @param mixed $username
     * @param mixed $password
     * @param mixed $rol_id
     * 
     * @return [type]
     * 
     */
    function dynamicCreateUsers(
        $connection,
        $id,
        $fulL_name,
        $email,
        $ci,
        $direction,
        $username,
        $password,
        $rol_id
    ) {

        $data = [];
        if (empty($id)) {
            dump('asdasd');
            $data =  self::createUser(
                $connection,
                $fulL_name,
                $email,
                $ci,
                $direction,
                $username,
                $password,
                $rol_id
            );
        } else {

            $data = self::updateUser(
                $connection,
                $id,
                $fulL_name,
                $email,
                $ci,
                $direction,
                $username,
                $password,
                $rol_id
            );
        }

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
                    user.fulL_name  name_user,
                    user.email,
                    user.ci,
                    user.direction,
                    user.username,
                    user.rol_id rol,
                    user.password token,
                    roles.name name_rol 
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


        $password_encrypt_db = $connection->table('usuarios')->where('username', $credentials['username'])->value('password');

        $password_encrypt_db = Crypt::decryptString($password_encrypt_db);


        if ($password_encrypt_db == trim($credentials['password'])) {

            $user  = (object) self::getUser($connection, $credentials['username']);

            return  $user;
        } else {
            throw new \Exception('Credenciales inválidas', 401);
        }
    }

    /**
     * Lista los usuarios menos el actual METODO PLIGROSO
     *
     * @param mixed $connection 
     * @param mixed $rol
     * 
     * @return array
     * 
     */
    public function listUsers($connection, $user)
    {
        $users = $connection->select("SELECT 
            user.id ,
            user.fulL_name name_user,
            user.email,
            roles.name name_rol,
            user.direction,
            user.username,
            user.rol_id rol,
            user.password,
            user.ci
        FROM usuarios user
        INNER JOIN roles ON
             roles.id = user.rol_id
        WHERE user.id != :user;", [
            "user" => $user
        ]);

        foreach ($users  as $key => $user) {

            $users[$key]->password = Crypt::decryptString($user->password);
        }

        return $users;
    }
}
