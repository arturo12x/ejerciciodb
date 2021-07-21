<?php

include_once('conex.php');
include_once('respuesta.php');
include_once('students.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $accion = "";
    $accion = $_POST['accion'];

    if (empty($accion)) {
        $resp1 = new respuesta();
        $resp1->set('4001', 'Action required', "", "red", '');
        $myJSON = json_encode($resp1);
        echo $myJSON;
        return;
    }

    function valida($data)
    {
        $valida = trim($data);
        $valida = stripcslashes($data);
        $valida = htmlspecialchars($data);
        return ($data);
    }

    function validaempty($data, $field)
    {

        
        $resp1 = new respuesta();
        if (empty($data)) {
            $resp1->set('4005', $field . ' required', "", "red", $field);
            $myJSON = json_encode($resp1);
            echo $myJSON;
            return false;
        }
        return true;
    }

    function validastring($data, $field)
    {
        if (!preg_match("/^[a-zA-Z'. -]+$/", $data)) {
            $resp1 = new respuesta();
            $resp1->set('4005', 'Only letters allowed', "", "red", $field);
            $myJSON = json_encode($resp1);
            echo $myJSON;
            return false;
        }
        return true;
    }

    function validainteger($data, $field)
    {
        if (!preg_match('/^[1-9][0-9]{0,2}$/', $data)) {
            $resp1 = new respuesta();
            $resp1->set('4005', 'Only numbers allowed', "", "red", $field);
            $myJSON = json_encode($resp1);
            echo $myJSON;
            return false;
        }
        return true;
    }

    function validaemail($data, $field)
    {
        if (!stripos($data, 'utlaguna.edu.mx')) {
            $resp1 = new respuesta();
            $resp1->set('4005', 'Only email utlaguna domain allowed', "", "red", $field);
            $myJSON = json_encode($resp1);
            echo $myJSON;
            return false;
        }
        return true;
    }
    $resp1 = new respuesta();
    $accion = $_POST['accion'];

    if ($accion == 'agregar') {
        //Evita la inyeccion SQL
        $nombre = "";
        $apellido = "";
        $edad = "";
        $email = "";

        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $edad = $_POST['edad'];
        $email =  $_POST['email'];

        if (!validaempty($nombre, 'name')) return;
        if (!validaempty($apellido, 'lastnanme')) return;
        if (!validaempty($edad, 'age')) return;
        if (!validaempty($email, 'email')) return;

        valida($nombre);
        valida($apellido);
        valida($edad);
        valida($email);

        if (!validastring($nombre, 'name')) return;
        if (!validastring($apellido, 'lastanme')) return;
        if (!validainteger($edad, 'age')) return;
        if (!validaemail($email, 'email')) return;


        $id = 0;

        $student = new students();
        $student->set($id, $nombre, $apellido, $edad, $email);


        $stmt = $conn->prepare('INSERT INTO students (name,lastname,age,email)VALUES(?,?,?,?)');
        $stmt->bind_param('ssis', $student->nombre, $student->apellido, $student->edad, $student->email);

        if ($stmt->execute()) {

            $ar = $stmt->affected_rows;
            if ($ar == 0) {
                $resp1->set('1000', 'There is an error', "", "red", "");
                $myJSON = json_encode($resp1);
                echo $myJSON;
            }
            if ($ar == 1) {
                $idst = mysqli_insert_id($conn);
                $resp1->set('1001', 'INSERT SUCCESSFUL', "ID: " . $idst, 'green', " ");

                $myJSON = json_encode($resp1);
                echo $myJSON;
            }
        } else {
            $resp1->set('1002', 'You have an error in your sql statement', "", "red", " ");
            $myJSON = json_encode($resp1);
            echo $myJSON;
        }
    }


    if ($accion == 'actualizar') {
        //Evita la inyeccion SQL
        $id = "";
        $nombre = "";
        $apellido = "";
        $edad = "";
        $email = "";

        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $edad = $_POST['edad'];
        $email =  $_POST['email'];
        if (!validaempty($id, 'id')) return;
        if (!validaempty($nombre, 'name')) return;
        if (!validaempty($apellido, 'lastnanme')) return;
        if (!validaempty($edad, 'age')) return;
        if (!validaempty($email, 'email')) return;
        valida($id);
        valida($nombre);
        valida($apellido);
        valida($edad);
        valida($email);

        if (!validastring($nombre, 'name')) return;
        if (!validastring($apellido, 'lastanme')) return;
        if (!validainteger($edad, 'age')) return;
        if (!validainteger($id, 'id')) return;
        if (!validaemail($email, 'email')) return;

        $student = new students();
        $student->set($id, $nombre, $apellido, $edad, $email);
        $stmt = $conn->prepare('UPDATE students SET name=?,lastname=?,age=?,email=? where id=?');
        $stmt->bind_param('ssisi', $student->nombre, $student->apellido, $student->edad, $student->email, $student->id);
        $resp1 = new respuesta();

        if ($stmt->execute()) {

            //convert 
            $ar = $stmt->affected_rows;
            if ($ar == 0) {
                $resp1->set('2000', 'There is an error', "ID: ", "red", "");
                $myJSON = json_encode($resp1);
                echo $myJSON;
            }
            if ($ar == 1) {
            }
            $resp1->set('2001', 'UPDATED SUCCESSFULLY', "ID: " . $id, "green", "");
            $myJSON = json_encode($resp1);
            echo $myJSON;
        } else {
            $resp1->set('2002', 'You have an error in your sql statement', "ID: ", "red", "");
            $myJSON = json_encode($resp1);
            echo $myJSON;
        }
    }

    //convertir a querys preparadas el proyecto anterior

    if ($accion == 'eliminar') {

        $id = "";
        $nombre = "";
        $apellido = "";
        $edad = "";
        $email = "";
        $id = $_POST['id'];

        if (!validaempty($id, 'id')) return;
        valida($id);
        if (!validainteger($id, 'id')) return;

        $student = new students();
        $student->set($id, $nombre, $apellido, $edad, $email);

        $stmt = $conn->prepare('DELETE FROM students WHERE id=?');
        $stmt->bind_param('i', $student->id);
        $resp1 = new respuesta();



        if ($stmt->execute()) {

            $ar = $stmt->affected_rows;
            if ($ar == 0) {
                $resp1->set('3000', 'There is an error, the id is wrong or the data doesnt exist', "ID: ", "red", "");
                $myJSON = json_encode($resp1);
                echo $myJSON;
            }
            if ($ar == 1) {
                $resp1->set('3001', 'DELETED SUCCESSFULLY', "ID: " . $id, "green", "");
                $myJSON = json_encode($resp1);
                echo $myJSON;
            }
        } else {
            $resp1->set('3002', 'You have an error in your sql statement', "ID: ", "red", "");
            $myJSON = json_encode($resp1);
            echo $myJSON;
        }
    }
}
