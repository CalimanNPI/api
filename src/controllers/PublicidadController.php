<?php


namespace Cmendoza\ApiCdc\controllers;

use Cmendoza\ApiCdc\models\ModelMongoAll as publicity;

class PublicidadController
{
    public static function index()
    {
        $result = new publicity('publicity');
        return  $result->getAll();
    }

    public static function show($id)
    {
        $result = new publicity('publicity');
        return  $result->getById($id);
    }

    public static function store($fields)
    {
        $id = uniqid();
        $data = ['_id' => $id, 'title' => $fields['title'], 
        'body' => $fields['body'], 'img_url' => $fields['uriImg'], 
        'description' => $fields['description'], 'date' => $fields['date']];
        $notify = new publicity('publicity');
        $result = $notify->save($data);
        return $result;
    }
}
