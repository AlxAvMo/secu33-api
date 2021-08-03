<?php

class conexion{
    private $server;
    private $user;
    private $password;
    private $database;
    private $port;
    private $conexion;

    function __construct(){
        $datos = $this->getDatosConexion();
        foreach($datos as $key => $value){
            $this->server = $value['server'];
            $this->user = $value['user'];
            $this->password = $value['password'];
            $this->database = $value['database'];
            $this->port = $value['port'];
        
        }
        $this->conexion = new mysqli($this->server, $this->user, $this->password, $this->database);
        if($this->conexion->connect_errno){
            echo "Falló la conexión con la base de datos";
            die();
        }else{
            //echo "conexión establecida";
        }
    }

    private function getDatosConexion(){
        $dir = dirname(__FILE__);
        $jsondata = file_get_contents($dir."/config");
        return json_decode($jsondata,true);
    }

    //
    private function convertirUTF8($array){
        array_walk_recursive($array,function(&$item,$key){
            if(!mb_detect_encoding($item,'utf-8',true)){
                $item = utf8_encode($item);
            }
        });
        return $array;
    }

    public function getRegistros($query){
        $results = $this->conexion->query($query);
        $resultArray = array();
        foreach($results as $reg) {
            $resultArray[] = $reg;
        }
        return $this->convertirUTF8($resultArray);
    }

    public function nonQuery($query){
        $results = $this->conexion->query($query);
        return $this->conexion->affected_rows;
    }

    public function nonQueryId($query){
        $results = $this->conexion->query($query);
        $filas = $this->conexion->affected_rows;
        if($filas >= 1){
            return $filas;
        }else{
            return $this->conexion->error;
        }
    }

    protected function encriptar($string){
       return hash('md5',$string);
    }
}

?>