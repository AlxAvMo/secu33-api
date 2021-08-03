<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
include_once '../clases/Grupo.class.php';
include_once '../clases/respuestas.class.php';

$_respuestas = new Respuestas;
$_grupo = new Grupo;

switch($_SERVER['REQUEST_METHOD']){
    case 'POST':
        //Crear
    break;
    case 'GET':
        //Consultar
        if( isset($_GET['id']) ){ //Consulta individual
            $response = $_grupo->buscarPorID($_GET['id']);
            echo json_encode($response);
            http_response_code(200);
        }elseif( isset($_GET['grupo']) && isset($_GET['grado']) ){ // && isset($_GET['periodo'])
            $grado = $_GET['grado'];
            $grupo = $_GET['grupo'];
            //$ciclo = $_GET['periodo'];
            if( isset($_GET['materia']) ){
                $materia = $_GET['materia'];
                $response = $_grupo->getGrupo($grupo,$grado,$materia); //,$ciclo
            }else{
                $response = $_grupo->getGrupo($grupo,$grado); //,$ciclo
            }
            echo json_encode($response);
            http_response_code(200);
        }elseif(isset($_GET['page'])){
            $pagina = $_GET['page'];
            //$response = $_grupo->listaGrupos($pagina);
            $response = $_grupo->listaGruposYGrados($pagina);
            echo json_encode($response);
            http_response_code(200);
        }else{
            $response = $_grupo->buscarTodos();
            echo json_encode($response);
            http_response_code(200);
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