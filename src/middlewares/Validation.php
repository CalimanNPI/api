<?php

namespace Cmendoza\ApiCdc\middlewares;

use Cmendoza\ApiCdc\lib\Validate;

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

            foreach ($params as  $param) {

                if (str_contains($param, ':')) {
                    $length = explode(':', $param);
                    $num = $length[1];
                    $leng = $length[0];
                }

                if ($leng == 'max' || $leng == 'min' || $leng == 'size') {
                    $message = str_replace(':size', $num, str_replace(':attribute', ucfirst($key), $array_errors->$leng));
                    $validate->$leng($value, $num) ?: self::setErrors($message);
                } else {
                    $message = str_replace(':attribute', ucfirst($key), $array_errors->$param);
                    $validate->$param($value) ?: self::setErrors($message);
                }
            }
        }

        return self::getErrors();
    }

    public function attributes()
    {
        return [
            'email' => 'email address',
        ];
    }
}
