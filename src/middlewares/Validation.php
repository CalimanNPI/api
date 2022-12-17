<?php

namespace Cmendoza\ApiCdc\middlewares;

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
        $array_errors = json_encode(require_once('.//lang/validation_m.php'));
        $array_errors = json_decode($array_errors);

        $num = 0;
        $leng = "";

        foreach ($array as $key => $values) {
            $validate = new Validate();

            $value = $fields[$key];
            $params = explode('|', $values);

            //error_log("--------------------");
            //error_log(json_encode($params));
            foreach ($params as  $param) {

                if (strpos($param, ':') !== false) {
                    $length = explode(':', $param);
                    $num = $length[1];
                    $leng = $length[0];
                    //error_log($param);
                    //error_log($leng);
                }

                //error_log(strpos(":as", ':'));
                //error_log("++++++++++++++++++++++++");
                //error_log(json_encode($param));

                if ($leng === "max" || $leng === "min" || $leng === "size") {
                    $message = str_replace(':size', $num, str_replace(':attribute', ucfirst($key), $array_errors->$leng));
                    $validate->$leng($value, $num) ?: self::setErrors($message);
                   // error_log($param);
                    $leng = "";
                } else {
                    $message = str_replace(':attribute', ucfirst($key), $array_errors->$param);
                    $validate->$param($value) ?: self::setErrors($message);
                    //error_log($message . "  " . $param);
                }
            }
        }

        //return self::getErrors();
    }

    public function validateToken($token)
    {
        //error_log($token);
        $array_errors = json_encode(require_once('.//lang/auth.php'));
        $array_errors = json_decode($array_errors);

        $jwtu = new Mongo('jwtu');
        $re = $jwtu->get(['token' => $token]);
        //error_log(count($re));
        count($re) == 1 ?: self::setErrors($array_errors->auth);
        // error_log(count($re) == 1 ? "ada" : $array_errors->auth);
        //return self::getErrors();
    }

    public function attributes()
    {
        return [
            'email' => 'email address',
        ];
    }
}
