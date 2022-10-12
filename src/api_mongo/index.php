<?php

// Crear
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input = $_POST;
    header("HTTP/1.1 200 OK");
    echo json_encode($input['token']);
    exit();
}

//En caso de que ninguna de las opciones anteriores se haya ejecutado
header("HTTP/1.1 400 Bad Request");
