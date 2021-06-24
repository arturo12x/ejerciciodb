<?php
include_once('conex.php');
if (isset($_POST['nombre'])) $name = $_POST['nombre'];
if (isset($_POST['apellido'])) $lastname = $_POST['apellido'];
if (isset($_POST['edad'])) $age = $_POST['edad'];
if (isset($_POST['email'])) $email = $_POST['email'];

$accion = $_POST['accion'];
if ($accion == 'agregar') {
    //Evita la inyeccion SQL
    $stmt = $conn->prepare('INSERT INTO students (name,lastname,age,email)VALUES(?,?,?,?)');
    $stmt->bind_param('ssis', $name, $lastname, $age,$email);
    if ($stmt->execute()) {

        $ar = $stmt->affected_rows;
        if ($ar == 0) {
            echo '1000';}
        }
        if ($ar == 1) {
            echo '1001';
        }

    } else {
        echo '1002';
    }

}
if ($accion == 'actualizar') {
    //Evita la inyeccion SQL
    $id = $_POST['id'];
    $stmt = $conn->prepare('UPDATE students SET name=?,lastname=?,age=?,email=? where id=?');
    $stmt->bind_param('ssii', $name, $lastname, $age, $id,$email);
    if ($stmt->execute()) {


        $ar = $stmt->affected_rows;
        if ($ar == 0) {
            echo '2000';
        }
        if ($ar == 1) {
            echo '2001';
        }


    } else {
        echo '2002';
    }

    //convertir a querys preparadas el proyecto anterior
}
if ($accion == 'eliminar') {
    $id = $_POST['id'];
    $stmt = $conn->prepare('DELETE FROM students WHERE id=?');
    $stmt->bind_param('i', $id);
    if ($stmt->execute()) {

        $ar = $stmt->affected_rows;
        if ($ar == 0) {
            echo '3000';
        }
        if ($ar == 1) {
            echo '3001';
        }


    } else {
        echo '3002';
    }

}
?>

