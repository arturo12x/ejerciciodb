<?php
class students
{
    public $id;
    public $name;
    public $lastname;
    public $age;
    public $email;


    function set($id, $name, $lastname, $age, $email)
    {
        $this->id = $id;
        $this->name = $name;
        $this->lastname = $lastname;
        $this->age = $age;
        $this->email = $email;
    }
}
