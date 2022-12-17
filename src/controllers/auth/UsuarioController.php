<?php

namespace Cmendoza\ApiCdc\controllers\auth;

use Cmendoza\ApiCdc\models\UserModel;
use Cmendoza\ApiCdc\middlewares\Validation;

class UsuarioController
{
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

      $usuario = new UserModel();
      $usuario->setTipo($fields['tipo']);

      $usuario->updateUser($fields);

      return ["message" => "Se actualizo la información correactamente"];
   }
}
