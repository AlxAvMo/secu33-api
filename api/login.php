<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
require_once '../clases/auth.class.php';
require_once '../clases/respuestas.class.php';

$_auth = new Auth;
$_respuestas = new Respuestas;

if($_SERVER['REQUEST_METHOD'] == "POST"){
    //Obtener los datos enviados
    $_postbody = file_get_contents('php://input');
    //print_r($_postbody);
    //Obtener los datos de la BD
    $datos = $_auth->login($_postbody);
    //Responder
    if(isset($datos['result']['error_id'])){
        $error = $datos['result']['error_id'];
        http_response_code($error);
    }else{
        http_response_code(200);
    }
    echo json_encode($datos);
}else{
    $response = $_respuestas->error_405();
    echo json_encode($response);
}
?>