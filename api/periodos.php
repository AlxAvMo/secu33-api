<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
include_once '../clases/Periodo.class.php';
include_once '../clases/respuestas.class.php';

$_respuestas = new Respuestas;
$_periodo = new Periodo;

switch($_SERVER['REQUEST_METHOD']){
    case 'POST':
        //Crear
    break;
    case 'GET':
        //Consultar
        if( isset($_GET['id']) ){
            $response = $_periodo->buscarPorID($_GET['id']);
            echo json_encode($response);
            http_response_code(200);
        }else{
            if(isset($_GET['page'])){
                $pagina = $_GET['page'];
                $response = $_periodo->listaPeriodos($pagina);
                echo json_encode($response);
                http_response_code(200);
            }else{
                $response = $_periodo->buscarTodos();
                echo json_encode($response);
                http_response_code(200);
            }
        }
    break;
    case 'PUT':
    break;
    case 'DELETE':
        //Borrar
    break;
    default:
        $response = $_respuestas->error_405();
        echo json_encode($response);
}
?>