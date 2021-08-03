<?php 
require_once 'conexion/conexion.php';
require_once 'respuestas.class.php';

class Alumno extends conexion{
    private $tabla = "vista_alumnos";

    private $id;
    private $grado;
    private $grupo;
    private $idusuario;
    private $idtutor;
    private $estatus;
    private $primaria;
    private $periodo_escolar;

    /*
     public function __construct($id,$grado,$grupo,$usuario,$tutor,$primaria,$periodo_escolar,$estatus)
     {
         $this->id=$id;
         $this->grado=$grado;
         $this->grupo=$grupo;
         $this->usuario=$usuario;
         $this->tutor=$tutor;
         $this->primaria=$primaria;
         $this->periodo_escolar=$periodo_escolar;
         $this->estatus=$estatus;
     } 
     */
    //OPERACIONES de búsqueda
    public function listaAlumnos($pagina = 1){
        $_respuestas = new Respuestas;
        $inicio = 0;
        $cantidad = 30;
        if($pagina > 1){
            $inicio = ($cantidad * ($pagina-1)) + 1;
            $cantidad = $cantidad * $pagina;
        }

        $query = "SELECT * FROM ".$this->tabla." LIMIT $inicio,$cantidad";
        $registros = parent::getRegistros($query);
        $respuesta = $_respuestas->response;
        $respuesta["result"] = $registros;
        return $respuesta;
    }

    public function buscarPorID($idalumno){
        $query = "SELECT * FROM ".$this->tabla." WHERE idalumno = '$idalumno'";
        $registros = parent::getRegistros($query);
        $_respuestas = new Respuestas;
        $respuesta = $_respuestas->response;
        $respuesta["result"] =  $registros;
        return $respuesta;
    }

    public function buscarTodos(){
        $query = "SELECT * FROM ".$this->tabla;
        $registros = parent::getRegistros($query);
        $_respuestas = new Respuestas;
        $respuesta = $_respuestas->response;
        $respuesta["result"] =  $registros;
        return $respuesta;
    }
    
    public function guardarAlumno($json){
        $_respuestas = new Respuestas;
        $datos = json_decode($json,true);

        /* Validación del token
            if( !isset($datos['token']) ){
                return $_respuestas->error_401();
            }else{
                $this->token = $datos['token'];
                $arrayToken = $this->buscarToken();
                if($arrayToken){
                    //Token válido
                }else{
                    return $_respuestas->error_401();
                }
            } 
        */

        if(isset($datos['idalumno'])) { $this->idalumno=$datos['idalumno']; }
        if(isset($datos['grado'])) { $this->grado=$datos['grado']; }
        if(isset($datos['grupo'])) { $this->grupo=$datos['grupo']; }
        if(isset($datos['idusuario'])) { $this->idusuario=$datos['idusuario']; }
        if(isset($datos['idtutor'])) { $this->idtutor=$datos['idtutor']; }
        if(isset($datos['estatus'])) { $this->estatus=$datos['estatus']; }
        if(isset($datos['primaria'])) { $this->primaria=$datos['primaria']; }
        if(isset($datos['periodo_escolar'])) { $this->periodo_escolar=$datos['periodo_escolar']; }
        
        $resp = $this->insertarAlumno();
        if($resp){
            $respuesta = $_respuestas->response;
            $respuesta["result"] = array(
                "idusuario" => "$this->idusuario",
                "mensaje" => "Alumno registrado"
            );
            return $respuesta;
        }else{
            print_r("MENSAJEEE ".$resp);
            return $_respuestas->error_500();
        }
    }

    public function insertarAlumno(){
        $query = "INSERT INTO ".$this->tabla." VALUES('$this->idalumno','$this->grado','$this->grupo','$this->idusuario','$this->idtutor','$this->estatus','$this->primaria')";
        $result = parent::nonQueryId($query);
        return $result;
    }
    
//GETS
    public function getId(){
        return $this->id;
    }

    public function getGrado(){
        return $this->grado;
    }

    public function getGrupo(){
        return $this->grupo;
    }

    public function getUsuario(){
        return $this->usuario;
    }

    public function getTutor(){
        return $this->tutor;
    }

    public function getPrimaria(){
        return $this->primaria;
    }

    public function getEstatus(){
        return $this->estatus;
    }

    public function getPeriodoEscolar(){
        return $this->periodo_escolar;
    }

    //SETS
    public function setId($id){
        $this->id=$id;
    }

    public function setGrado($grado){
        $this->grado=$grado;
    }

    public function setGrupo($grupo){
        $this->grupo=$grupo;
    }

    public function setUsuario($usuario){
        $this->usuario=$usuario;
    }

    public function setTutor($tutor){
        $this->tutor=$tutor;
    }

    public function setPrimaria($primaria){
        $this->primaria=$primaria;
    }

    public function setEstatus($estatus){
        $this->estatus=$estatus;
    }

    public function setPeriodoEscolar($ciclo){
        $this->periodo_escolar=$ciclo;
    }
}

?>