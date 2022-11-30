<?php

namespace Cmendoza\ApiCdc\controllers;

use Cmendoza\ApiCdc\models\ModelMongoAll as TokenConn;


class TokenController
{

    public static function index()
    {
        $result = new TokenConn('tokens');
        return  $result->getAll();
    }

    public static function show($id)
    {
        $result = new TokenConn('tokens');
        return  $result->getById($id);
    }

    public static function storeToken($fields)
    {
        $data = ['_id' => uniqid(), 'token' => $fields['token']];
        $notify = new TokenConn('tokens');
        if (!$notify->get(['token' => $fields['token']])) {
            $result = $notify->save($data);
            return $result;
        }

        return ['message' => 'EL token ya existe'];
    }
}
