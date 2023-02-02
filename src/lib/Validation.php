<?php

namespace Cmendoza\ApiCdc\lib;

use Cmendoza\ApiCdc\lib\Validate;
use Cmendoza\ApiCdc\models\ModelMongoAll as Mongo;

class Validation
{

    public $errors = [];

    public function setErrors($error)
    {
        array_push($this->errors, $error);
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function make($array, $fields)
    {
        $array_errors = json_encode(require_once(__DIR__.'/../lang/validation.php'));
        $array_errors = json_decode($array_errors);

        $num = 0;
        $leng = "";

        foreach ($array as $key => $values) {
            $validate = new Validate();

            $value = $fields[$key];
            $params = explode('|', $values);

            foreach ($params as  $param) {

                if (strpos($param, ':') !== false) {
                    $length = explode(':', $param);
                    $num = $length[1];
                    $leng = $length[0];
                }

                if ($leng === "max" || $leng === "min" || $leng === "size") {
                    $message = str_replace(':size', $num, str_replace(':attribute', ucfirst($key), $array_errors->$leng));
                    $validate->$leng($value, $num) ?: $this->setErrors($message);
                    $leng = "";
                } else {
                    $message = str_replace(':attribute', ucfirst($key), $array_errors->$param);
                    $validate->$param($value) ?: $this->setErrors($message);
                }
            }
        }
    }

    public function validateToken($token)
    {
        $array_errors = json_encode(require_once(__DIR__.'/../lang/validation.php'));
        $array_errors = json_decode($array_errors);
        $jwtu = new Mongo('jwtu');
        $re = $jwtu->get(['token' => $token]);
        count($re) == 1 ?: $this->setErrors($array_errors->auth);
    }

    public function attributes()
    {
        return [
            'email' => 'email address',
        ];
    }
}
