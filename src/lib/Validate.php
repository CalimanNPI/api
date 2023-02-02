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
        $reg = "/^\\d+$/";
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
        $reg = "/^[\pL\s]+$/u";
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

    public function curp($param)
    {
        $reg = "/^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/";
        return preg_match($reg, $param);
    }

    public function rfc($param)
    {
        $reg = "/^[ÑA-Z]{3,4}[0-9]{6}[0-9A-Z]{3}$/";
        return preg_match($reg, $param);
    }
}
