<?php
require_once 'conexion/conexion.php';
require_once 'respuestas.class.php';

class Auth extends conexion{

    public function login($json){
        $respuestas = new Respuestas;
        $datos = json_decode($json,true);
        if(!isset($datos['password'])){
            if( isset($datos['token']) && isset($datos['usuario']) ){ //Si manda el token --
                if( $this->validarToken($datos['usuario'],$datos['token']) ){
                    $usuario = $datos['usuario'];
                    $datos = $this->obtenerUsuario($usuario);
                    if($datos[0]['idestatus'] == 1){
                        $datos[0]['contraseña'] = null;
                        $token = $this->insertarToken($datos[0]['idusuario']);
                        if($token){
                            $resp = $respuestas->response;
                            $resp['result'] = $datos;
                            $resp['token'] = $token;
                            return $resp;
                        }else{
                            return $respuestas->error_500("Error interno, no se ha odido guardar el token");
                        }
                    }else{
                        return $respuestas->error_200("El usuario ".$usuario." ha sido desactivado");
                    }
                }
            } 
            //error
            return $respuestas->error_400();
        }else{
            $usuario = $datos['usuario'];
            $pass = $datos['password'];
            $pass = parent::encriptar($pass);
            $datos = $this->obtenerUsuario($usuario);
            if($datos){
                if($pass == $datos[0]['password']){
                    $datos[0]['password'] = null;
                    if($datos[0]['idestatus'] == 1){
                        $token = $this->insertarToken($datos[0]['idusuario']);
                        if($token){
                            $resp = $respuestas->response;
                            $resp['result'] = $datos;
                            $resp['token'] = $token;
                            return $resp;
                        }else{
                            return $respuestas->error_500("Error interno, no se ha odido guardar el token");
                        }
                    }else{
                        return $respuestas->error_200("El usuario ".$usuario." ha sido desactivado");
                    }
                }else{
                    return $respuestas->error_200("Los datos no coinciden");
                }
            }else{
                return $respuestas->error_200("El usuario ".$usuario." no existe");
            }
        }
    }

    public function obtenerUsuario($user){
        $query = "SELECT idusuario,contraseña AS password,correo,idestatus,tipo_usuario,nombre,apepat,apemat,sexo,domicilio,curp,foto FROM usuario WHERE idusuario = '$user'";
        $query = utf8_decode($query);
        $datos = parent::getRegistros($query);
        if(isset($datos[0]['idusuario'])){
            return $datos;
        }else{
            return 0;
        }
    }

    private function insertarToken($idusuario){
        /*
        $val = true;
        $token = bin2hex(openssl_random_pseudo_bytes(16,$val));
        $date = date('Y-m-d H:i');
        $estado = "activo";
        $query = "INSERT INTO tokens (idusuario,token,idestatus,fecha) VALUES ('$idusuario','$token','$estado','$date')";
        $insertar = parent::nonQuery($query);
        if($insertar){
            return $token;
        }else{
            return 0;
        }
        */
        $user = $this->obtenerUsuario($idusuario);
        if($user){
            $token = md5($user[0]['idusuario']);
            return $token;
        }else{
            return 0;
        }
    }

    private function validarToken($iduser,$token){
        $tokenValido = md5($iduser);
        if($tokenValido == $token){
            return true;
        }else{
            return false;
        }
    }   
}

?>