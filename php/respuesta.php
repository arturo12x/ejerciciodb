<?php
class respuesta
{
    public $code;
    public $desc;
    public $idstu;
    public $color;
    public $field;
    function set($code, $desc, $idstu, $color,$field)
    {
        $this->code = $code;
        $this->desc = $desc;
        $this->idstu = $idstu;
        $this->field = $field;
        $this->color = $color;
    }
}