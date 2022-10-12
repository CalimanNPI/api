<?php

namespace Cmendoza\ApiCdc\controllers;

use Cmendoza\ApiCdc\models\ModelMongoAll  as Notificaciones;
use Cmendoza\ApiCdc\models\ModelSendNotifications as SendNotify;
use DateTime;
use Dotenv\Parser\Value;

class NotificacionController
{
    public static function index()
    {
        $result = new Notificaciones('notifications');

        $resultado =  $result->getAll();
        $array = array_values(array_filter($resultado, function ($value) {
            if (isset($value['isSend']) && isset($value['title'])) {
                return $value['isSend'] && str_contains($value['limitedTime'], date("m"));
            }
        }));

        return $array;

        // return  $result->getAll();
    }

    public static function show($id)
    {
        $result = new Notificaciones('notifications');
        return  $result->getById($id);
    }

    public static function store($fields)
    {

        error_log($fields['desc']);
        $data = [
            '_id' => uniqid(), 'title' => $fields['title'],
            'body' => $fields['body'], 'isSend' => false,
            'n_type' => $fields['n_type'], 'iconName' => $fields['iconName'],
            'created' => date("Y-m-d H:i:s"),
            "limitedTime" =>  date("Y-m-d H:i:s"), 'desc' => $fields['desc'],
        ];
        $notify = new Notificaciones('notifications');
        $result = $notify->save($data);
        return $result;
    }

    public static function update($id, $fields)
    {
        $notify = new Notificaciones('notifications');
        $result = $notify->update($fields, $id);
        return $result;
    }

    public static function delete($id)
    {
        $notify = new Notificaciones('notifications');
        $result = $notify->delete($id);
        return $result;
    }

    public static function sendN()
    {
        $notify = new SendNotify('notifications');
        $result = $notify->sendNotify();
        return $result;
    }

    public static function filtrar()
    {
        $result = new Notificaciones('notifications');
        $resultado =  $result->getAll();
        $array = array_values(array_filter($resultado, function ($value) {
            if (isset($value['isSend']) && isset($value['title'])) {
                return $value['isSend'] && str_contains($value['limitedTime'], date("m"));
            }
        }));

        $array = array_values($array);

        print_r($array);
    }
}
