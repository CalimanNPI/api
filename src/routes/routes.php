<?php

use Cmendoza\ApiCdc\controllers\PublicidadController as Publicity;
use Cmendoza\ApiCdc\controllers\NotificacionController as Notify;
use Cmendoza\ApiCdc\controllers\TokenController as TokenConn;
use Cmendoza\ApiCdc\controllers\SendMailController as SendMail;
use Cmendoza\ApiCdc\controllers\ActivityController as Activity;
use Cmendoza\ApiCdc\controllers\auth\LoginController as Login;

$router = new \Bramus\Router\Router();

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

$router->get('/about', function () {
    //$pb = new Publicidad();
    // echo json_encode(Login::login());
    //echo 'About Page Contents <br>' . $_ENV['DB_HOST'];
});

$router->get('/about/{clave}', function ($clave) {
    //echo json_encode(PubCon::show($clave));
    echo 'About Page Contents  <br/>' . $clave;
});


/**token */
$router->post('/token', function () {
    $notify = TokenConn::storeToken($_POST);
    echo json_encode($notify);
});


/**Notificaciones */
$router->get('/notify/fil', function () {
    echo json_encode(Notify::filtrar());
});

$router->get('/notify', function () {
    echo json_encode(Notify::index());
});

$router->get('/notify/{id}', function ($id) {
    echo json_encode(Notify::show($id));
});

$router->post('/notify', function () {
    $notify = Notify::store($_POST);
    echo json_encode($notify);
});

$router->put('/notify/{id}', function ($id) {
    $postdata = file_get_contents("php://input");
    $obj = json_decode($postdata);
    error_log(json_encode($obj));
    echo json_encode(Notify::update($id, $obj));
});

$router->delete('/notify/{id}', function ($id) {
    echo json_encode(Notify::delete($id));
});

$router->get('/sendNotifications', function () {
    echo json_encode(Notify::sendN());
});


/** Publicidad */
$router->get('/publicity', function () {
    echo json_encode(Publicity::index());
});

$router->get('/publicity/{id}', function ($id) {
    echo json_encode(Publicity::show($id));
});

$router->post('/publicity', function () {
    $notify = Publicity::store($_POST);
    echo json_encode($notify);
});

/** Actividades */
$router->post('/actividad', function () {
    $activity = Activity::store($_POST);
    error_log(json_encode($_POST));
});

/**email */
$router->post('/sendEmail', function () {
    error_log(json_encode($_POST));
    $status = SendMail::storeMessage($_POST);
    error_log(json_encode($status));

    if ($status) {
        # code...
        echo json_encode(['message' => 'Se envio su mensaje !',]);
    } else {
        # code...
        echo json_encode(['message' => 'Lo sentimos, ocurrio un error ',]);
    }
});


$router->mount('/login', function () use ($router) {

    $router->post('/', function () {
        echo json_encode(['message' => Login::existUser($_POST)]);
    });

    $router->post('/auth', function () {
        $n = new Login();
        echo json_encode($n->validateAuth('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJjbGF2ZSI6IjQwNjAwNjA2MDEifQ.nPvU_NIZ3iVYcFJrWI4Z0LrRFS_UDnIGXuS3wTJRMjw'));
    });

    $router->post('/logout', function () {

        echo json_encode(['message' => Login::index()]);
    });
});

$router->run();
