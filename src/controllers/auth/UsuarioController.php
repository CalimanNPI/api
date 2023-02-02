<?php

namespace Cmendoza\ApiCdc\controllers\auth;

use Cmendoza\ApiCdc\models\ModelUser;
use Cmendoza\ApiCdc\lib\Validation;

class UsuarioController
{

   public $usuario;

   function __construct()
   {
      $this->usuario = new ModelUser();
   }

   public function update($fields)
   {
      $validate  = new Validation();

      error_log($fields['tipo']);

      if ($fields['tipo'] == "A") {
         error_log("usuario altoren");
         $array = array(
            'email' =>  "email",
            'phone' =>  "phone",
            'clave' => "size:10|number",
            'curp' => "curp"
         );
      }

      if ($fields['tipo'] == "U") {
         error_log("usuario ");
         $array = array(
            'curp' => "curp",
            'email' =>  "email",
            'phone' =>  "phone",
            'clave' => "size:10|number"
         );
      }

      if ($fields['tipo'] == "X") {
         error_log("usuario inter");
         $array = array(
            'curp' => "curp",
            'rfc' =>  "rfc",
            'email' =>  "email",
            'phone' =>  "phone",
            //'clave'=> "number|size:10"
            'clave' => "size:10|number"
         );
      }

      $validate->validateToken($fields['token']);

      $validate->make($array, $fields);

      $error = $validate->getErrors();
      if (count($error) > 0) {
         return ['error' => $error];
      }

      $this->usuario->setTipo($fields['tipo']);
      $this->usuario->updateUser($fields);

      return ["message" => "Se actualizo la información correactamente"];
   }

   public function getCredential($id, $tipo)
   {
      $this->usuario->setClave($id);
      $this->usuario->setTipo($tipo);
      return $this->usuario->getCredential();
   }
}
