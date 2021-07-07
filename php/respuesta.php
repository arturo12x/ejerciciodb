<?php
class respuesta
{
    public $code;
    public $desc;
    public $idstu;
    public $color;
    function set($code, $desc, $idstu, $color)
    {
        $this->code = $code;
        $this->desc = $desc;
        $this->idstu = $idstu;
        $this->color = $color;
    }
}