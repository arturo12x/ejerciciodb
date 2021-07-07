<?php
include_once('conex.php');
include_once('respuesta.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $resp1 = new respuesta();

    if (empty($_POST['accion'])) {

        $resp1->set('4001', 'Action required', "", "red");
        $myJSON = json_encode($resp1);
        echo $myJSON;
        return;
    }
    if (empty($_POST['nombre'])) {

        $resp1->set('4002', 'Name required', "", "red");
        $myJSON = json_encode($resp1);
        echo $myJSON;
        return;
    }
    if (empty($_POST['apellido'])) {
        $resp1->set('4003', 'Lastname required', "", "red");
        $myJSON = json_encode($resp1);
        echo $myJSON;
        return;
    }
    if (empty($_POST['edad'])) {
        $resp1->set('4004', 'Age required', "", "red");
        $myJSON = json_encode($resp1);
        echo $myJSON;
        return;
    }
    if (empty($_POST['email'])) {
        $resp1->set('4005', 'Email required', "", "red");
        $myJSON = json_encode($resp1);
        echo $myJSON;
        return;
    }

    $accion = $_POST['accion'];
    if ($accion == 'agregar') {
        //Evita la inyeccion SQL
        $stmt = $conn->prepare('INSERT INTO students (name,lastname,age,email)VALUES(?,?,?,?)');
        $stmt->bind_param('ssis', $name, $lastname, $age, $email);

        $resp1 = new respuesta();
        if ($stmt->execute()) {

            $ar = $stmt->affected_rows;
            if ($ar == 0) {
                $resp1->set('1000', 'There is an error', "", "red");
                $myJSON = json_encode($resp1);
                echo $myJSON;
            }
            if ($ar == 1) {
                $idst = mysqli_insert_id($conn);
                $resp1->set('1001', 'INSERT SUCCESSFUL', "ID: " . $idst, 'green');
                $myJSON = json_encode($resp1);
                echo $myJSON;
            }
        } else {
            $resp1->set('1002', 'You have an error in your sql statement', "", "red");
            $myJSON = json_encode($resp1);
            echo $myJSON;
        }
    }


    if ($accion == 'actualizar') {
        //Evita la inyeccion SQL
        $id = $_POST['id'];

        $stmt = $conn->prepare('UPDATE students SET name=?,lastname=?,age=?,email=? where id=?');
        $stmt->bind_param('ssisi', $name, $lastname, $age, $email, $id);
        $resp1 = new respuesta();

        if ($stmt->execute()) {

            //convert 
            $ar = $stmt->affected_rows;
            if ($ar == 0) {
                $resp1->set('2000', 'There is an error', "ID: ");
                $myJSON = json_encode($resp1);
                echo $myJSON;
            }
            if ($ar == 1) {
            }
            $resp1->set('2001', 'UPDATED SUCCESSFULLY', "ID: " . $id);
            $myJSON = json_encode($resp1);
            echo $myJSON;
        } else {
            $resp1->set('2002', 'You have an error in your sql statement', "ID: ");
            $myJSON = json_encode($resp1);
            echo $myJSON;
        }
    }

    //convertir a querys preparadas el proyecto anterior

    if ($accion == 'eliminar') {
        $id = $_POST['id'];
        $stmt = $conn->prepare('DELETE FROM students WHERE id=?');
        $stmt->bind_param('i', $id);
        $resp1 = new respuesta();

        if ($stmt->execute()) {

            $ar = $stmt->affected_rows;
            if ($ar == 0) {
                $resp1->set('3000', 'There is an error', "ID: ");
                $myJSON = json_encode($resp1);
                echo $myJSON;
            }
            if ($ar == 1) {
                $resp1->set('3001', 'DELETED SUCCESSFULLY', "ID: " . $id);
                $myJSON = json_encode($resp1);
                echo $myJSON;
            }
        } else {
            $resp1->set('3002', 'You have an error in your sql statement', "ID: ");
            $myJSON = json_encode($resp1);
            echo $myJSON;
        }
    }
}
