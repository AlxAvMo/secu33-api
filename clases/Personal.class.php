<?php 
require_once 'conexion/conexion.php';
require_once 'respuestas.class.php';

class Personal extends conexion{

    private $tabla = "vista_personal";

    private $id;
    private $estatus;

    public function listaPersonal($pagina = 1){
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

    public function listaPersonalByTipo($tipo,$pagina = 1){
        $inicio = 0;
        $cantidad = 10;
        if($pagina > 1){
            $inicio = ($cantidad * ($pagina-1)) + 1;
            $cantidad = $cantidad * $pagina;
        }

        $query = "SELECT * FROM ".$this->tabla." WHERE tipo_usuario = ".$tipo." LIMIT $inicio,$cantidad";
        $registros = parent::getRegistros($query);
        $_respuestas = new Respuestas;
        $respuesta = $_respuestas->response;
        $respuesta["result"] =  $registros;
        return $respuesta;
    }

    
    public function buscarPorID($id){
        $query = "SELECT * FROM ".$this->tabla." WHERE idpersonal = '$id'";
        $registros = parent::getRegistros($query);
        $_respuestas = new Respuestas;
        $respuesta = $_respuestas->response;
        $respuesta["result"] =  $registros;
        return $respuesta;
    }

    public function buscarPorTipo($id){
        $query = "SELECT * FROM ".$this->tabla." WHERE idpersonal = '$id'";
        $registros = parent::getRegistros($query);
        $_respuestas = new Respuestas;
        $respuesta = $_respuestas->response;
        $respuesta["result"] =  $registros;
        return $respuesta;
    }

    public function buscarTodo(){
        $query = "SELECT * FROM tipo_usuario WHERE idtipo_usuario > 0 AND idtipo_usuario < 5";
        $registros = parent::getRegistros($query);
        $_respuestas = new Respuestas;
        $respuesta = $_respuestas->response;
        $respuesta["result"] =  $registros;
        return $respuesta;
    }
}
?>