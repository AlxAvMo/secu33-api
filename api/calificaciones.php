<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
include_once '../clases/Calificacion.class.php';
include_once '../clases/respuestas.class.php';

$_respuestas = new Respuestas;
$_calificaciones = new Calificaciones;

switch($_SERVER['REQUEST_METHOD']){
    case 'POST':
        /*
        $_POST = file_get_contents('php://input');
        $response = $_calificaciones->guardarAlumno($_POST);
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
    case 'GET':
        if(isset($_GET['id'])){
            $response = $_calificaciones->buscarPorID($_GET['id']);
            echo json_encode($response);
            http_response_code(200);
        }else{
            if(isset($_GET['alumno'])){
                $alumno = $_GET['alumno'];
                $materia = $_GET['materia'];
                $response = $_calificaciones->buscarPorAlumno($alumno,$materia);
                echo json_encode($response);
                http_response_code(200);
            }else{
                $response = $_calificaciones->buscarTodos();
                echo json_encode($response);
                http_response_code(200);
            }
        }
    break;
    case 'PUT':
        /*
        $json = file_get_contents('php://input');
        $response = $_calificaciones->updateUsuario($json);
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
        $response = $_alumno->_calificaciones($json);
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