<?php

namespace Cmendoza\ApiCdc\lib;

class Validate
{
    function __construct()
    {
    }

    public function required($param)
    {
        return isset($param);
    }

    public function number($param)
    {
        $reg = "/([0-9])\w+/";
        return preg_match($reg, $param);
    }

    public function phone($param)
    {
        $reg =  "/^\\+?[1-9][0-9]{7,14}$/";
        return preg_match($reg, $param);
    }

    public function email($param)
    {
        return filter_var($param, FILTER_VALIDATE_EMAIL);
    }

    public function string($param)
    {
        $reg =  "/^[a-zñA-ZÑ]+[áéíóú]*$/";
        return preg_match($reg, $param);
    }

    public function size($param, $length)
    {
        return mb_strlen($param) == $length;;
    }

    public function max($param, $length)
    {
        return mb_strlen($param) <= $length;;
    }

    public function min($param, $length)
    {
        return mb_strlen($param) >= $length;;
    }
}
