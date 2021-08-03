<?php 
require_once 'conexion/conexion.php';
require_once 'respuestas.class.php';

class Grupo extends conexion{
    private $tabla = "grupos";

    private $idGrupo = 0;
    private $nombre = "";
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
    public function listaGrupos($pagina = 1){
        $inicio = 0;
        $cantidad = 10;
        if($pagina > 1){
            $inicio = ($cantidad * ($pagina-1)) + 1;
            $cantidad = $cantidad * $pagina;
        }

        $query = "SELECT * FROM ".$this->tabla." LIMIT $inicio,$cantidad";
        $registros = parent::getRegistros($query);
        $_respuestas = new Respuestas;
        $respuesta = $_respuestas->response;
        $respuesta["result"] =  $registros;
        return $respuesta;
    }

    public function listaGruposYGrados($pagina = 1){
        $inicio = 0;
        $cantidad = 10;
        if($pagina > 1){
            $inicio = ($cantidad * ($pagina-1)) + 1;
            $cantidad = $cantidad * $pagina;
        }

        $query = "SELECT grados.idgrado,grupos.idgrupo,CONCAT(grados.descripcion,' Grupo ',grupos.descripcion) AS descripcion 
        FROM grados,grupos WHERE grupos.idgrupo > 0 and grados.idgrado > 0 
        ORDER BY grupos.idgrupo";
        $registros = parent::getRegistros($query);
        $_respuestas = new Respuestas;
        $respuesta = $_respuestas->response;
        $respuesta["result"] =  $registros;
        return $respuesta;
    }

    public function buscarPorID($idgrupo){
        $query = "SELECT * FROM ".$this->tabla." WHERE idgrupo = '$idgrupo'";
        $registros = parent::getRegistros($query);
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

    public function listarAlumnos($materia = "0"){
        if( $this->idGrupo > 0){
            $query = "SELECT * FROM vista_alumnos WHERE grado = $this->idGrado and idgrupo = $this->idGrupo AND idestatus = 1;"; //and idperiodo = $this->periodo_escolar
        }else{ // Si la calve de grupo es 0 (No asignado) entonces traer a todos los alumnos de x grado
            $query = "SELECT * FROM vista_calificaciones WHERE idmateria = '$materia' GROUP BY idalumno";
        }
        $registros = parent::getRegistros($query);
        $this->alumnos=$registros;
        $_respuestas = new Respuestas;
        $respuesta = $_respuestas->response;
        $respuesta["result"] =  $registros;
        return $respuesta;
    }

    public function getGrupo($grupo,$grado,$materia = "0"){ // ,$ciclo
        $this->setGrupo($grupo);
        $this->setGrado($grado);
        //$this->setPeriodo($ciclo);
        $this->listarAlumnos($materia);
        return array(
            "grupo" => $this->nombre,
            "idgrupo" => "$this->idGrupo",
            "idgrado" => "$this->idGrado",
            "alumnos" => $this->alumnos
        );
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
        $nombre = $this->buscarPorID($valor);
        if($nombre){
            $this->nombre = $nombre['result'][0]['descripcion'];
        }
        
    }
  
}

?>