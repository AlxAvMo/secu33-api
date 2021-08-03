<?php 
require_once 'conexion/conexion.php';
require_once 'respuestas.class.php';

class Usuario extends conexion{
    private $tabla = "usuario";
    
    private $idusuario = "";
    private $nombre = "";
    private $apePat = "";
    private $apeMat = "";
    private $correo = "";
    private $contraseña = "";
    private $foto = "";
    private $tipo_usuario = "";
    private $sexo = "";
    private $f_nac = "0000-00-00";
    private $f_alta = "0000-00-00";
    private $domicilio = "";
    private $curp = "";
    private $estatus = "";
    private $token = "";
    /*
     public function __construct($nombre,$apePat,$apeMat,$correo,$contraseña,$foto,$tipo,$s,$f_nac,$f_alta,$domicilio,$curp,$estatus)
     {
         $this->nombre=$nombre;
         $this->apePat=$apePat;
         $this->apeMat=$apeMat;
         $this->correo=$correo;
         $this->contraseña=$contraseña;
         $this->foto=$foto;
         $this->tipo_usuario=$tipo;
         $this->sexo=$s;
         $this->f_nac=$f_nac;
         $this->f_alta=$f_alta;
         $this->domicilio=$domicilio;
         $this->curp=$curp;
         $this->estatus=$estatus;
     }
    */

    //OPERACIONES
    public function listaUsuarios($pagina = 1){
        $inicio = 0;
        $cantidad = 30;
        if($pagina > 1){
            $inicio = ($cantidad * ($pagina-1)) + 1;
            $cantidad = $cantidad * $pagina;
        }

        $query = "SELECT * FROM usuario LIMIT $inicio,$cantidad";
        $registros = parent::getRegistros($query);
        $_respuestas = new Respuestas;
        $respuesta = $_respuestas->response;
        $respuesta["result"] =  $registros;
        return $respuesta;
    }
    
    public function buscarPorID($idusuario){
        $query = "SELECT * FROM ".$this->tabla." WHERE idusuario = '$idusuario'";
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

    public function guardarUsuario($json){
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
        if(!isset( $datos['idusuario']) || !isset($datos['tipo_usuario']) || !isset($datos['estatus']) ){
            return $_respuestas->error_400();
        }
        if(isset($datos['idusuario'])) { $this->idusuario=$datos['idusuario']; }
        if(isset($datos['nombre'])) { $this->nombre=$datos['nombre']; }
        if(isset($datos['apepat'])) { $this->apePat=$datos['apepat']; }
        if(isset($datos['apemat'])) { $this->apeMat=$datos['apemat']; }
        if(isset($datos['correo'])) { $this->correo=$datos['correo']; }
        if(isset($datos['contraseña'])) { $this->contraseña=$datos['contraseña']; }
        if(isset($datos['foto'])) { $this->foto=$datos['foto']; }
        if(isset($datos['tipo_usuario'])) { $this->tipo_usuario=$datos['tipo_usuario']; }
        if(isset($datos['sexo'])) { $this->sexo=$datos['sexo']; }
        if(isset($datos['f_nac'])) { $this->f_nac=$datos['f_nac']; }
        if(isset($datos['f_alta'])) { $this->f_alta=$datos['f_alta']; }
        if(isset($datos['domicilio'])) { $this->domicilio=$datos['domicilio']; }
        if(isset($datos['curp'])) { $this->curp=$datos['curp']; }
        if(isset($datos['estatus'])) { $this->estatus=$datos['estatus']; }
        $resp = $this->insertarUsuario();
        if($resp){
            $respuesta = $_respuestas->response;
            $respuesta["result"] = array(
                "idusuario" => "$this->idusuario",
                "mensaje" => "Usuario creado"
            );
            return $respuesta;
        }else{
            print_r("MENSAJEEE ".$resp);
            return $_respuestas->error_500();
        }
    }

    public function insertarUsuario(){
        $query = "INSERT INTO ".$this->tabla." VALUES('$this->idusuario','$this->correo','$this->contraseña','$this->foto','$this->tipo_usuario','$this->nombre','$this->apePat','$this->apeMat','$this->sexo','$this->f_nac','$this->domicilio','$this->f_alta','$this->estatus','$this->curp')";
        $result = parent::nonQueryId($query);
        return $result;
    }

    public function updateUsuario($json){
        $_respuestas = new Respuestas;
        $datos = json_decode($json,true);
        if( !isset( $datos['idusuario']) ){
            return $_respuestas->error_400();
        }
        if(isset($datos['idusuario'])) { $this->idusuario=$datos['idusuario']; }
        if(isset($datos['nombre'])) { $this->nombre=$datos['nombre']; }
        if(isset($datos['apepat'])) { $this->apePat=$datos['apepat']; }
        if(isset($datos['apemat'])) { $this->apeMat=$datos['apemat']; }
        if(isset($datos['correo'])) { $this->correo=$datos['correo']; }
        if(isset($datos['contraseña'])) { $this->contraseña=$datos['contraseña']; }
        if(isset($datos['foto'])) { $this->foto=$datos['foto']; }
        if(isset($datos['tipo_usuario'])) { $this->tipo_usuario=$datos['tipo_usuario']; }
        if(isset($datos['sexo'])) { $this->sexo=$datos['sexo']; }
        if(isset($datos['f_nac'])) { $this->f_nac=$datos['f_nac']; }
        if(isset($datos['f_alta'])) { $this->f_alta=$datos['f_alta']; }
        if(isset($datos['domicilio'])) { $this->domicilio=$datos['domicilio']; }
        if(isset($datos['curp'])) { $this->curp=$datos['curp']; }
        if(isset($datos['estatus'])) { $this->estatus=$datos['estatus']; }
        $resp = $this->update();
        if($resp){
            $respuesta = $_respuestas->response;
            $respuesta["result"] = array(
                "idusuario" => "$this->idusuario",
                "Mensaje" => "Los datos del usuario se han actualizado"
            );
            return $respuesta;
        }else{
            print_r("MENSAJEEE ".$resp);
            return $_respuestas->error_500();
        }
    }

    public function update(){
        $query = "UPDATE ".$this->tabla." SET nombre='$this->nombre',apepat='$this->apePat',apemat='$this->apeMat',
        correo='$this->correo',f_nac='$this->f_nac',sexo='$this->sexo',curp='$this->curp',tipo_usuario='$this->tipo_usuario'
        WHERE idusuario='$this->idusuario';";
        $result = parent::nonQueryId($query);
        return $result;
    }

    public function deleteUsuario($json){
        $_respuestas = new Respuestas;
        $datos = json_decode($json,true);
        if( !isset( $datos['idusuario']) ){
            return $_respuestas->error_400();
        }
        if(isset($datos['idusuario'])) { $this->idusuario=$datos['idusuario']; }
        $resp = $this->delete();
        if($resp){
            $respuesta = $_respuestas->response;
            $respuesta["result"] = array(
                "idusuario" => "$this->idusuario",
                "Mensaje" => "El usuaario ".$this->idusuario." ha sido eliminado"
            );
            return $respuesta;
        }else{
            print_r("MENSAJEEE ".$resp);
            return $_respuestas->error_500();
        }
    }

    public function delete(){
        $query = "DELETE FROM ".$this->tabla." WHERE idusuario='$this->idusuario';";
        $result = parent::nonQueryId($query);
        return $result;
    }

    private function buscarToken(){
        $query = "SELECT * FROM token";
        $token = parent::getRegistros($query);
        return $token;
    }

    private function actualizarToken($idtoken){
        $fecha = date("Y-m-d H:i");
        $query = "UPDATE token";
        $token = parent::nonQuery($query);
        return $token;
    }
    
    private function validarToken(){

    }

   //GETS

    public function getNombre(){
        return $this->nombre;
    }

    public function getApePat(){
        return $this->apePat;
    }

    public function getApeMat(){
        return $this->apeMat;
    }

    public function getCorreo(){
        return $this->correo;
    }

    public function getContraseña(){
        return $this->contraseña;
    }

    public function getTipoUsuario(){
        return $this->tipo_usuario;
    }

    public function getSexo(){
        return $this->sexo;
    }

    public function getF_nac(){
        return $this->f_nac;
    }

    public function getF_alta(){
        return $this->f_alta;
    }

    public function getDomicilio(){
        return $this->domicilio;
    }

    public function getCurp(){
        return $this->curp;
    }

    public function getEstatus(){
        return $this->estatus;
    }

    public function getFoto(){
        return $this->foto;
    }

   //SETS
    public function setNombre($nombre){
        $this->nombre=$nombre;
    }

    public function setApePat($apePat){
        $this->apePat=$apePat;
    }

    public function setApeMat($apeMat){
        $this->apeMat=$apeMat;
    }

    public function setCorreo($correo){
        $this->correo=$correo;
    }

    public function setContraseña($contraseña){
        $this->contraseña=$contraseña;
    }

    public function setTipoUsuario($tipo_usuario){
        $this->tipo_usuario=$tipo_usuario;
    }

    public function setSexo($sexo){
        $this->sexo=$sexo;
    }

    public function setF_nac($f_nac){
        $this->f_nac=$f_nac;
    }

    public function setF_alta($f_alta){
        $this->f_alta=$f_alta;
    }

    public function setDomicilio($domicilio){
        $this->domicilio=$domicilio;
    }

    public function setCurp($curp){
        $this->curp=$curp;
    }

    public function setEstatus($estatus){
        $this->estatus=$estatus;
    }

    public function setFoto($foto){
        $this->foto=$foto;
    }
}

?>