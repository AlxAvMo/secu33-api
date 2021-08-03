<?php 
require_once 'conexion/conexion.php';
require_once 'respuestas.class.php';

class Calificaciones extends conexion{
    private $tabla = "vista_calificaciones";

    private $idCalificacion;
    private $idAlumno;
    private $calificacion;
    private $inasistencias;
    private $idMateria;
    private $idTrimestre;
    private $editar;

    //OPERACIONES
    public function listaCalificaciones($pagina = 1){
        $inicio = 0;
        $cantidad = 100;
        if($pagina > 1){
            $inicio = ($cantidad * ($pagina-1)) + 1;
            $cantidad = $cantidad * $pagina;
        }

        $query = "SELECT * FROM ".$this->tabla." LIMIT $inicio,$cantidad";
        $registros = parent::getRegistros($query);
        return $registros;
    }

    public function buscarPorID($idCalificacion){
        $query = "SELECT * FROM ".$this->tabla." WHERE idcalificacion = '$idCalificacion'";
        $registros = parent::getRegistros($query);
        return $registros;
    }

    public function buscarPorAlumno($alumno,$materia){
        $resultArray = array();
        $query = "SELECT * FROM ".$this->tabla." WHERE idalumno = '$alumno' && idmateria = '$materia'; ";
        $registros = parent::getRegistros($query);
        foreach( $registros as $cal){
            $resultArray[$cal['trimestre']] = $cal;
        }
        $_respuestas = new Respuestas;
        $respuesta = $_respuestas->response;
        $respuesta["result"] =  $registros;
        return $respuesta;
    }

    public function buscarTodos(){
        $query = "SELECT * FROM ".$this->tabla;
        $registros = parent::getRegistros($query);
        return $registros;
    }
}

?>