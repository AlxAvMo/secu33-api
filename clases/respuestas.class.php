<?php
class Respuestas{

    public $response = [
        "status" => "ok",
        "result" => array()
    ];

    public function error_405(){
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "405",
            "error_msg" => "Método no permitido"
        );
        return $this->response;
    }

    public function error_200($cadena = "Datos incorrectos"){
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "200",
            "error_msg" => $cadena
        );
        return $this->response;
    }

    public function error_400(){
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "400",
            "error_msg" => "Datos o formato de datos incorrecto"
        );
        return $this->response;
    }

    public function error_404(){
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "404",
            "error_msg" => "Página no encontrada"
        );
        return $this->response;
    }

    public function error_500($cadena = "Error interno del servidor"){
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "500",
            "error_msg" => $cadena
        );
        return $this->response;
    }

    public function error_401($cadena = "No autorizado"){
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "401",
            "error_msg" => $cadena
        );
        return $this->response;
    }

}
?>