<?php


namespace Cmendoza\ApiCdc\middlewares;

use Cmendoza\ApiCdc\models\ModelMongoAll as JWTU;

class Auth
{

    public function __construct()
    {
        $array = array(
            'nombre' => $validate->validateName($nombre),
            'paterno' => $validate->validateName($paterno),
            'materno' => $validate->validateName($materno),
            'correo' => $validate->validateEmail($correo),
            'celular' => $validate->validateTel($celular)
        );

        $error = $validate->validateAll($array);
        
    }

    public function validateAll($array)
    {

        $error = [];

        foreach ($array as $key => $value) {
            if (!$value) {
                array_push($error, ['error' => 'Formato invalido en: ' . $key]);
            }
        }

        return $error;
    }
}
