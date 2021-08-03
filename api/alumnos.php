<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
include_once '../clases/Alumno.php';
include_once '../clases/respuestas.class.php';

$_respuestas = new Respuestas;
$_alumno = new Alumno;

switch($_SERVER['REQUEST_METHOD']){
    case 'POST':
        $_POST = file_get_contents('php://input');
        $response = $_alumno->guardarAlumno($_POST);
        //Responder
        if(isset($response['result']['error_id'])){
            $error = $response['result']['error_id'];
            http_response_code($error);
        }else{
            http_response_code(200);
        }
        echo json_encode($response);
    break;
    case 'GET':
        if(isset($_GET['id'])){
            $response = $_alumno->buscarPorID($_GET['id']);
            echo json_encode($response);
            http_response_code(200);
        }else{
            if(isset($_GET['page'])){
                $pagina = $_GET['page'];
                $response = $_alumno->listaAlumnos($pagina);
                echo json_encode($response);
                http_response_code(200);
            }else{
                $response = $_alumno->buscarTodos();
                echo json_encode($response);
                http_response_code(200);
            }
        }
    break;
    case 'PUT':
        /*
        $json = file_get_contents('php://input');
        $response = $_alumno->updateUsuario($json);
        //Responder
        if(isset($response['result']['error_id'])){
            $error = $response['result']['error_id'];
            http_response_code($error);
        }else{
            http_response_code(200);
        }
        echo json_encode($response);
        */
    break;
    case 'DELETE':
        /*/En caso de mandar los datos a través de los headers
        $datos = getallheaders();
        if( isset($datos['token']) && isset($datos['idusuario']) ){
            $json = [
                "token" => $datos['token'],
                "idusuario" => $datos['idusuario']
            ];
        }else{
            $json = file_get_contents('php://input');
        } */
        /*
        $json = file_get_contents('php://input');
        $response = $_alumno->deleteUsuario($json);
        //Responder
        if(isset($response['result']['error_id'])){
            $error = $response['result']['error_id'];
            http_response_code($error);
        }else{
            http_response_code(200);
        }
        echo json_encode($response);
        */
    break;
    default:
        $response = $_respuestas->error_405();
        echo json_encode($response);
}
?>