<?php

use Cmendoza\ApiCdc\controllers\PublicidadController as Publicity;
use Cmendoza\ApiCdc\controllers\NotificacionController as Notify;
use Cmendoza\ApiCdc\controllers\TokenController as TokenConn;
use Cmendoza\ApiCdc\controllers\SendMailController as SendMail;
use Cmendoza\ApiCdc\controllers\ActivityController as Activity;
use Cmendoza\ApiCdc\controllers\auth\AuthController as Login;
use Cmendoza\ApiCdc\controllers\auth\UsuarioController as Usuario;

$router = new \Bramus\Router\Router();

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

$router->setNamespace('\Cmendoza\ApiCdc\controllers');

/**token */
$router->post('/token', function () {
    $notify = TokenConn::storeToken($_POST);
    //error_log($_POST);
    echo json_encode($notify);
});

/**email */
$router->post('/sendEmail', function () {
    //error_log(json_encode($_POST));
    $status = SendMail::storeMessage($_POST);
    //error_log(json_encode($status));

    if ($status) {
        # code...
        echo json_encode(['message' => 'Se envio su mensaje !',]);
    } else {
        # code...
        echo json_encode(['message' => 'Lo sentimos, ocurrio un error ',]);
    }
});

/** send Notificación */
$router->get('/sendNotifications', function () {
    echo json_encode(Notify::sendN());
});

/**Notificaciones */
$router->mount('/notify', function () use ($router) {

    $router->get('/fil', function () {
        echo json_encode(Notify::filtrar());
    });

    $router->get('/', function () {
        echo json_encode(Notify::index());
    });

    $router->get('/{id}', function ($id) {
        echo json_encode(Notify::show($id));
    });

    $router->post('/', function () {
        $notify = Notify::store($_POST);
        echo json_encode($notify);
    });

    $router->put('/{id}', function ($id) {
        $postdata = file_get_contents("php://input");
        $obj = json_decode($postdata);
        //error_log(json_encode($obj));
        echo json_encode(Notify::update($id, $obj));
    });

    $router->delete('/{id}', function ($id) {
        echo json_encode(Notify::delete($id));
    });
});

/** Publicidad */
$router->mount('/publicity', function () use ($router) {
    $router->get('/', function () {
        echo json_encode(Publicity::index());
    });

    $router->get('/{id}', function ($id) {
        echo json_encode(Publicity::show($id));
    });

    $router->post('/', function () {
        $notify = Publicity::store($_POST);
        echo json_encode($notify);
    });
});

/**Actividad */
$router->mount('/acti', function () use ($router) {

    $router->get('/', function () {
        $obj = new Activity();
        echo json_encode($obj->index());
    });

    $router->get('/{id}', function ($id) {
        $obj = new Activity();
        echo json_encode($obj->show($id));
    });

    $router->post('/search', function () {
        $obj = new Activity();
        echo json_encode($obj->search($_POST));
    });

    $router->post('/prof', function () {
        $obj = new Activity();
        echo json_encode($obj->getProfe($_POST));
    });
});

/**auth */
$router->post('/login', function () {
    $login = new Login();
    //error_log(json_encode($_POST));
    //exit;
    echo json_encode($login->existUser($_POST));
});

$router->post('/logout', function () {
    $login = new Login();
    echo json_encode($login->logout($_POST));
});

$router->mount('/usuario', function () use ($router) {
    $router->post('/', function () {
        //$postdata = file_get_contents("php://input");
        //$obj = json_decode($postdata);
        //error_log(json_encode($obj));
        $usuario = new Usuario();
        //echo json_encode($_REQUEST);
        echo json_encode($usuario->update($_POST));
    });

    $router->get('/credential/{id}/{tipo}', function ($id, $tipo) {
        $usuario = new Usuario();
        echo json_encode($usuario->getCredential($id, $tipo));
    });
});

$router->run();
