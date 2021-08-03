<?php 
require_once 'conexion/conexion.php';
require_once 'respuestas.class.php';

class Boleta extends conexion{

    private $tabla = "vista_calificaciones";

    private $idAlumno;

    public function listaCalificaciones($pagina = 1, $idalumno){
        $inicio = 0;
        $cantidad = 30;
        if($pagina > 1){
            $inicio = ($cantidad * ($pagina-1)) + 1;
            $cantidad = $cantidad * $pagina;
        }

        $query = "SELECT idcalificacion,idalumno,idmateria,cal,inasistencias,idtrimestre,idperiodo FROM ".$this->tabla." WHERE idalumno = ".$idalumno." LIMIT $inicio,$cantidad";
        $registros = parent::getRegistros($query);
        $_respuestas = new Respuestas;
        $respuesta = $_respuestas->response;
        $respuesta["result"] =  $registros;
        return $respuesta;
    }

    public function listaCalsMateria($pagina = 1, $idalumno,$idmateria){
        $inicio = 0;
        $cantidad = 30;
        if($pagina > 1){
            $inicio = ($cantidad * ($pagina-1)) + 1;
            $cantidad = $cantidad * $pagina;
        }

        $query = "SELECT idcalificacion,idalumno,idmateria,cal,inasistencias,idtrimestre,idperiodo FROM ".$this->tabla." WHERE idalumno = ".$idalumno." AND idmateria = '$idmateria' LIMIT $inicio,$cantidad";
        $registros = parent::getRegistros($query);
        $_respuestas = new Respuestas;
        $respuesta = $_respuestas->response;
        $respuesta["result"] =  $registros;
        return $respuesta;
    }

    
}
?>