<?php


namespace Cmendoza\ApiCdc\middlewares;

use Cmendoza\ApiCdc\models\ModelMongoAll as JWTU;

class Auth
{

    function __construct()
    {
    }

    public function validateAuth($param)
    {
        $JWTU = new JWTU('jwtu');
        return $JWTU->get(["token" => $param]);
    }
}
