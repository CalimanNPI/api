<?php

namespace Cmendoza\ApiCdc\lib;


class Validate
{
    function __construct()
    {
    }

    public  function is_mail($param)
    {
        return filter_var($param, FILTER_VALIDATE_EMAIL);
    }
    
    public  function is_numeric($param)
    {
        return filter_var($param, FILTER_VALIDATE_INT);
    }

    public  function is_float($param)
    {
        return filter_var($param, FILTER_VALIDATE_FLOAT);
    }
}
