<?php


namespace Cmendoza\ApiCdc\controllers;

use Cmendoza\ApiCdc\models\ModelMongoAll as activity;

class ActivityController
{
    public static function index()
    {
        $result = new activity('publicity');
        return  $result->getAll();
    }

    public static function show($id)
    {
        $result = new activity('publicity');
        return  $result->getById($id);
    }

    public static function store($fields)
    {
        $notify = new activity('activity');
        $result = $notify->save($fields);
        //error_log($result);
        //$data = ['title' => $fields['title2'], 'body' => $fields['body2'], 'id_ex' => $id, 'isSend' => false, 'table' => 'publicity'];
        //NotificacionController::store($data);
        return $result;
    }
}
