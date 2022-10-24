<?php

namespace Cmendoza\ApiCdc\controllers\auth;

use Cmendoza\ApiCdc\lib\Validate;
use Cmendoza\ApiCdc\lib\Jwt;
use Cmendoza\ApiCdc\models\LoginModel;
use Cmendoza\ApiCdc\models\ModelMongoAll as JWTU;
use Cmendoza\ApiCdc\middlewares\Auth;

class LoginController extends Auth
{

    public static function existUser($fields)
    {
        $validate  = new Validate();

        if ($validate->is_mail($fields['mail']) && $validate->is_numeric($fields['clave'])) {
            $model = new LoginModel();
            $result = $model->get($fields);
            if (count($result)) {
                $json = Jwt::createJWT($fields['clave']);

                $JWTU = new JWTU('jwtu');
                $data = [
                    '_id' => uniqid(), 'token' => $json, 'headerAuth' => '',
                ];

                if ($JWTU->get(["token" => $json])) {
                    return $json;
                }

                $JWTU->save($data);
                return $json;
            }
        }

        return false;
    }

    public static function index()
    {
        $model = new LoginModel();
        return $model->getAll();
    }
}
