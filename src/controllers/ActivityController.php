<?php


namespace Cmendoza\ApiCdc\controllers;

use Cmendoza\ApiCdc\models\ModelActivity;
use Cmendoza\ApiCdc\models\ModelUser;

class ActivityController
{
    private ModelActivity $obj;

    function __construct()
    {
        $this->obj = new ModelActivity();;
    }

    public function index()
    {
        return $this->obj->getAll();
    }

    public function show($numero)
    {
        return $this->obj->getActi($numero);
    }

    public function search($fields)
    {
        return $this->obj->search($fields['search']);
    }

    public function getProfe($fields)
    {
        $user = new ModelUser();
        $user->setTipo('U');
        $user->setClave($fields['clave']);
        return $user->getUserNom();
    }
}
