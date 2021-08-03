<?php 
require_once 'conexion/conexion.php';
require_once 'respuestas.class.php';

class Materia extends conexion{

    private $tabla = "vista_materia";

    private $idMateria;
    private $nombre;
    private $idGrado;
    private $estatus;
    private $tipoMateria;

    public function listaMaterias($pagina = 1, $tipo = 1){
        $inicio = 0;
        $cantidad = 50;
        if($pagina > 1){
            $inicio = ($cantidad * ($pagina-1)) + 1;
            $cantidad = $cantidad * $pagina;
        }

        //$query = "SELECT * FROM ".$this->tabla." WHERE tipo_materia = ".$tipo." LIMIT $inicio,$cantidad";
        $query = "SELECT * FROM ".$this->tabla." WHERE tipo_materia = ".$tipo.";";
        $registros = parent::getRegistros($query);
        $_respuestas = new Respuestas;
        $respuesta = $_respuestas->response;
        $respuesta["result"] =  $registros;
        return $respuesta;
    }

    public function listaTecnologias($pagina = 1){
        $inicio = 0;
        $cantidad = 10;
        if($pagina > 1){
            $inicio = ($cantidad * ($pagina-1)) + 1;
            $cantidad = $cantidad * $pagina;
        }

        $query = "SELECT * FROM ".$this->tabla." WHERE tipo_materia = 0 LIMIT $inicio,$cantidad";
        $registros = parent::getRegistros($query);
        $_respuestas = new Respuestas;
        $respuesta = $_respuestas->response;
        $respuesta["result"] =  $registros;
        return $respuesta;
    }

    public function buscarPorID($id){
        $query = "SELECT * FROM ".$this->tabla." WHERE idmateria = '$id'";
        $registros = parent::getRegistros($query);
        $_respuestas = new Respuestas;
        $respuesta = $_respuestas->response;
        $respuesta["result"] =  $registros;
        return $respuesta;
    }

    public function misAsignaciones( $idDocente ){ //Devuelve las materias de las que está a cargo x docente
        $query = "SELECT asignacion.idasignacion,asignacion.idpersonal,
                  asignacion.idmateria,materia.nombre, grupos.descripcion, asignacion.idgrupo, materia.idgrado
                  FROM asignacion JOIN materia ON asignacion.idmateria = materia.idmateria
                  JOIN grupos ON grupos.idgrupo = asignacion.idgrupo
                  WHERE idpersonal = '$idDocente';";
        if( $idDocente == 'admin'){ //Si el docente es admin, devolver todas las asignaciones
            $query = "SELECT asignacion.idasignacion,asignacion.idpersonal,
            asignacion.idmateria,materia.nombre, grupos.descripcion, asignacion.idgrupo, materia.idgrado
            FROM asignacion JOIN materia ON asignacion.idmateria = materia.idmateria
            JOIN grupos ON grupos.idgrupo = asignacion.idgrupo;";
        }
        $registros = parent::getRegistros($query);
        $_respuestas = new Respuestas;
        $respuesta = $_respuestas->response;
        $respuesta["result"] =  $registros;
        return $respuesta;
    }

    public function Asignaciones(){ //Devuelve las materias de las que está a cargo x docente
        $query = "SELECT asignacion.idasignacion,asignacion.idpersonal,
                  asignacion.idmateria,materia.nombre, grupos.descripcion, asignacion.idgrupo, materia.idgrado
                  FROM asignacion JOIN materia ON asignacion.idmateria = materia.idmateria
                  JOIN grupos ON grupos.idgrupo = asignacion.idgrupo';";
        $registros = parent::getRegistros($query);
        $_respuestas = new Respuestas;
        $respuesta = $_respuestas->response;
        $respuesta["result"] =  $registros;
        return $respuesta;
    }

    public function misMaterias( $idalumno){ //Materias que cursa x alumno
        $query = " SELECT calificacion.idalumno, calificacion.idmateria, materia.nombre, periodo_escolar.idperiodo, 
                          periodo_escolar.descripcion AS ciclo 
                    FROM calificacion JOIN alumno ON alumno.idalumno=calificacion.idalumno 
                    JOIN materia ON materia.idmateria=calificacion.idmateria 
                    JOIN trimestre ON trimestre.idtrimestre=calificacion.idtrimestre 
                    JOIN periodo_escolar ON periodo_escolar.idperiodo=trimestre.idperiodo 
                    WHERE calificacion.idalumno='$idalumno' GROUP BY idmateria; ";
        $registros = parent::getRegistros($query);
        $_respuestas = new Respuestas;
        $respuesta = $_respuestas->response;
        $respuesta["result"] =  $registros;
        return $respuesta;
    }
    //Useless..for now
    public function buscarTodo(){
        $query = "SELECT * FROM ".$this->tabla.";";
        $registros = parent::getRegistros($query);
        $_respuestas = new Respuestas;
        $respuesta = $_respuestas->response;
        $respuesta["result"] =  $registros;
        return $respuesta;
    }
}
?>