<?php
class students{
    public $id;
    public $nombre;
    public $apellido;
    public $edad;
    public $email;
    

    function set($id, $nombre, $apellido,$edad,$email){
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->edad = $edad;
        $this->email = $email;
    }
}

?>