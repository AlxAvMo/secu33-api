<?php 
require_once 'conexion/conexion.php';
require_once 'respuestas.class.php';

class Periodo extends conexion{
    private $tabla = "periodo_escolar";

    private $idPeriodo = 0;
    private $descripcion = "";

    /*
     public function __construct($idgrupo,$idgrado)
     {
        
     } 
    */
    //OPERACIONES de búsqueda
    public function listaPeriodos($pagina = 1){
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

    public function buscarPorID($id){
        $query = "SELECT * FROM ".$this->tabla." WHERE idperiodo = '$id'";
        $registros = parent::getRegistros($query);
        return $registros;
    }

    public function buscarTodos(){
        $query = "SELECT * FROM ".$this->tabla;
        $registros = parent::getRegistros($query);
        return $registros;
    }

    //GETS
    public function getDescripcion(){
        return $this->descripcion;
    }

    public function getIdPeriodo(){
        return $this->idPeriodo;
    }

    public function getPeriodoArray(){
        return array(
            "idperiodo" => $this->idPeriodo,
            "descripcion" => $this->descripcion
        );
    }

    //SETS
    public function setDescripcion($valor){
        $this->descripcion=$valor;
    }

    public function SetIdPeriodo($valor){
        $this->idPeriodo = $valor;
    }
}
?>