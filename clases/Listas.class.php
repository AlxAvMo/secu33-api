<?php 
require_once 'conexion/conexion.php';
require_once 'respuestas.class.php';

class Lista extends conexion{
    private $tabla = "grupos";

    private $idGrupo = 0;
    private $idGrado = 0;
    private $alumnos = array();
    private $numAlumnos = 0;
    private $periodo_escolar = 0;

    /*
     public function __construct($idgrupo,$idgrado)
     {
        
     } 
     */
    //OPERACIONES de búsqueda
    public function getListas($pagina = 1){
        $inicio = 0;
        $cantidad = 10;
        if($pagina > 1){
            $inicio = ($cantidad * ($pagina-1)) + 1;
            $cantidad = $cantidad * $pagina;
        }

        $query = "SELECT asignacion.idasignacion,asignacion.idmateria,materia.nombre,materia.idgrado,
        asignacion.idgrupo,grupos.descripcion AS grupo
        FROM asignacion JOIN materia ON asignacion.idmateria = materia.idmateria
        JOIN grupos ON asignacion.idgrupo = grupos.idgrupo"; //LIMIT $inicio,$cantidad
        $registros = parent::getRegistros($query);
        $_respuestas = new Respuestas;
        $respuesta = $_respuestas->response;
        $respuesta["result"] =  $registros;
        return $respuesta;
    }

    public function getLista($grado,$grupo,$materia = "0"){ // ,$ciclo
        $this->setGrupo($grupo); // Guarda el idgrupo y recupera la descripción
        //$this->setGrado($grado);
        //$this->setPeriodo($ciclo);
        $alumnos = $this->listarAlumnos($grado,$grupo,$materia);
        return array(
            "grupo" => $this->nombre,
            "idgrupo" => "$grupo",
            "idgrado" => "$grado",
            "alumnos" => $this->alumnos
        );
    }    

    public function listarAlumnos($grado,$grupo,$materia = "0"){
        if( $this->idGrupo > 0){
            $query = "SELECT vista_calificaciones.idalumno, vista_calificaciones.nombre,vista_calificaciones.apepat, 
            vista_calificaciones.apemat, vista_calificaciones.idmateria, vista_calificaciones.materia, alumno.idgrado,
            vista_calificaciones.idgrupo, grupos.descripcion AS grupo, alumno.idperiodo
            FROM vista_calificaciones 
            JOIN grupos ON grupos.idgrupo = vista_calificaciones.idgrupo
            JOIN alumno ON alumno.idalumno = vista_calificaciones.idalumno
            WHERE idmateria = '$materia' AND vista_calificaciones.idgrupo = '$grupo' AND alumno.idgrado = '$grado'
            GROUP BY idalumno;"; //and idperiodo = $this->periodo_escolar
        }else{ // Si la calve de grupo es 0 (No asignado) entonces traer a todos los alumnos de x grado
            $query = "SELECT vista_calificaciones.idalumno, vista_calificaciones.nombre,vista_calificaciones.apepat, 
            vista_calificaciones.apemat, vista_calificaciones.idmateria, vista_calificaciones.materia, alumno.idgrado,
            vista_calificaciones.idgrupo, grupos.descripcion AS grupo, alumno.idperiodo
            FROM vista_calificaciones 
            JOIN grupos ON grupos.idgrupo = vista_calificaciones.idgrupo
            JOIN alumno ON alumno.idalumno = vista_calificaciones.idalumno
            WHERE idmateria = '$materia' AND alumno.idgrado = '$grado'
            GROUP BY idalumno;";
        }
        $registros = parent::getRegistros($query);
        $this->alumnos=$registros;
        $_respuestas = new Respuestas;
        $respuesta = $_respuestas->response;
        $respuesta["result"] =  $registros;
        return $respuesta;
    }
    
    //GETS
    

    //SETS
    public function setGrado($valor){
        $this->idGrado=$valor;
    }

    public function setPeriodo($valor){
        $this->periodo_escolar=$valor;
    }

    public function setGrupo($valor){
        $this->idGrupo=$valor;
        $nombre = parent::getRegistros("SELECT * FROM grupos WHERE idgrupo = '$valor'");
        if($nombre){
            $this->nombre = $nombre[0]['descripcion'];
        }
    }
  
}

?>