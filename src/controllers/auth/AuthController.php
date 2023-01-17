<?php

namespace Cmendoza\ApiCdc\controllers\auth;

use Cmendoza\ApiCdc\lib\Validation;
use Cmendoza\ApiCdc\lib\JWT;
use Cmendoza\ApiCdc\models\ModelLogin;
use Cmendoza\ApiCdc\models\ModelUser;
use Cmendoza\ApiCdc\models\ModelMongoAll as Mongo;
//use Cmendoza\ApiCdc\middlewares\Auth;

class AuthController //extends Auth
{

    public function existUser($fields)
    {
        $validate = new Validation();

        $validate->make(array(
            'email' => "email",
            'clave' =>  "size:10|number",
        ), $fields);

        $error = $validate->getErrors();

        if (count($error) > 0) {
            return ["error" => $error];
        }

        $modelLogin = new ModelLogin();
        $modelUser = new ModelUser();

        $token = JWT::createJWT($fields['clave']);

        $result = $modelLogin->get($fields);
        if (count($result) > 0) {

            $data = [
                '_id' => uniqid(), 'clave' => $fields['clave'],
                'token' => $token, 'created' => date("Y-m-d H:i:s"),
            ];

            $modelUser->setClave($fields['clave']);
            $modelUser->setTipo($result[0]['status']);

            $jwtu = new Mongo('jwtu');
            if (!$jwtu->get(['token' => $token])) {
                $resultM = $jwtu->save($data);
            }

            $usuario = $modelUser->getUser();
            //error_log($result[0]['status']);
            //error_log(json_encode($result));
            return ['info' => $result, 'usuario' => $usuario, 'token' => $token, 'status' => $result[0]['status']];
        }

        return ['error' => ["Las credencíales son incorrecto"]];
    }

    public function logout($fields)
    {
        $token = JWT::createJWT($fields['clave']);

        if (hash_equals($token, $fields['token'])) {
            $jwtu = new Mongo('jwtu');
            $jwtu->delete(['token' => $token]);
            return true;
        }

        return false;
    }
}
