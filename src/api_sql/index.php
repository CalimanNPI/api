<?php
include "config.php";
include "utils.php";


$dbConn =  connect($db);

// Listar
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
        //Mostrar un post
        $sql = $dbConn->prepare("SELECT * FROM dbo.alto_ren WHERE clave=:id");
        $sql->bindValue(':id', $_GET['id']);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        header("HTTP/1.1 200 OK");
        $respuesta = json_encode($sql->fetchAll());
        echo $respuesta;
        //return $respuesta;
        exit();
    } else {
        //Mostrar lista de post
        $sql = $dbConn->prepare("SELECT top 10 * FROM dbo.alto_ren");
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        header("HTTP/1.1 200 OK");
        $respuesta = json_encode($sql->fetchAll());
        echo $respuesta;
        //return $respuesta;
        exit();
    }
}

// Crear
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input = $_POST;
    $sql = "INSERT INTO dbo.alto_ren
          (clave, paterno, materno, nom, ncomple, sexo,  tipo, depor, edad)
          VALUES
          (:clave, :paterno, :materno, :nom, :ncomple, :sexo,  :tipo, :depor, :edad)";
    $statement = $dbConn->prepare($sql);
    bindAllValues($statement, $input);
    $statement->execute();
    $postId = $dbConn->lastInsertId();
    if ($postId) {
        $input['id'] = $postId;
        header("HTTP/1.1 200 OK");
        echo json_encode($input);
        exit();
    }
}

//Borrar
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $id = $_GET['id'];
    $statement = $dbConn->prepare("DELETE FROM dbo.alto_ren where clave=:id");
    $statement->bindValue(':id', $id);
    $statement->execute();
    header("HTTP/1.1 200 OK");
    exit();
}

//Actualizar
if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $input = $_GET;
    $clave = $input['id'];
    $fields = getParams($input);

    $sql = "
          UPDATE dbo.alto_ren
          SET $fields
          WHERE clave='$clave'
           ";

    $statement = $dbConn->prepare($sql);
    bindAllValues($statement, $input);

    $statement->execute();
    header("HTTP/1.1 200 OK");
    exit();
}


//En caso de que ninguna de las opciones anteriores se haya ejecutado
header("HTTP/1.1 400 Bad Request");


