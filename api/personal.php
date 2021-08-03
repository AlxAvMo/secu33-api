<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
include_once '../clases/Personal.class.php';
include_once '../clases/respuestas.class.php';

$_respuestas = new Respuestas;
$_personal = new Personal;

switch($_SERVER['REQUEST_METHOD']){
    case 'POST':
        /*
        $_POST = file_get_contents('php://input');
        $response = $_materia->guardarAlumno($_POST);
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
            $response = $_personal->buscarPorID($_GET['id']);
            echo json_encode($response);
            http_response_code(200);
        }else{
            if(isset($_GET['tipo'])){
                $tipo = $_GET['tipo'];
                $response = $_personal->listaPersonalByTipo($tipo);
                echo json_encode($response);
                http_response_code(200);
            }elseif(isset($_GET['page'])){
                $pagina = $_GET['page'];
                $response = $_personal->listaPersonal($pagina);
                echo json_encode($response);
                http_response_code(200);
            }else{
                $response = $_personal->buscarTodo();
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