<?php 
require_once 'conexion/conexion.php';
require_once 'respuestas.class.php';

class Grado extends conexion{
    private $tabla = "grados";

    private $idGrado = 0;
    private $nombre = "";

    /*
     public function __construct($idgrupo,$idgrado)
     {
        
     } 
     */
    //OPERACIONES de búsqueda
    public function listaGrados($pagina = 1){
        $inicio = 0;
        $cantidad = 10;
        if($pagina > 1){
            $inicio = ($cantidad * ($pagina-1)) + 1;
            $cantidad = $cantidad * $pagina;
        }

        $query = "SELECT * FROM ".$this->tabla." LIMIT $inicio,$cantidad";
        $registros = parent::getRegistros($query);
        return $registros;
    }

    public function buscarPorID($idgrado){
        $query = "SELECT * FROM ".$this->tabla." WHERE idgrado = '$idgrado'";
        $registros = parent::getRegistros($query);
        return $registros;
    }

    public function buscarTodos(){
        $query = "SELECT * FROM ".$this->tabla;
        $registros = parent::getRegistros($query);
        return $registros;
    }

    //GETS
    public function getGrado(){
        return $this->idGrado;
    }

    //SETS
    public function setGrado($valor){
        $this->idGrado=$valor;
    }
}
?>