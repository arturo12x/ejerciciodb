<?php
include_once('conex.php');
if (isset($_POST['nombre'])) $name = $_POST['nombre'];
if (isset($_POST['apellido'])) $lastname = $_POST['apellido'];
if (isset($_POST['edad'])) $age = $_POST['edad'];
if (isset($_POST['email'])) $email = $_POST['email'];
class respuesta{
    public $code;
    public $desc;
    public $idstu;
    function set($code,$desc,$idstu){
        $this->code=$code;
        $this->desc=$desc;
        $this->idstu=$idstu;
    }
}
$accion = $_POST['accion'];
if ($accion == 'agregar') {
    //Evita la inyeccion SQL
    $stmt = $conn->prepare('INSERT INTO students (name,lastname,age,email)VALUES(?,?,?,?)');
    $stmt->bind_param('ssis', $name, $lastname, $age,$email);

    $resp1= new respuesta();
    if ($stmt->execute()) {

        $ar = $stmt->affected_rows;
        if ($ar == 0) {
            $resp1->set('1000','There is an error',"ID: ");
            $myJSON=json_encode($resp1);
            echo $myJSON;
        }
        if ($ar == 1) {
            $idst=mysqli_insert_id($conn);

            $resp1->set('1001','INSERT SUCCESSFUL',"ID: ".$idst);
            $myJSON=json_encode($resp1);
echo $myJSON;
        }

    } else {
        $resp1->set('1002','You have an error in your sql statement',"ID: ");
        $myJSON=json_encode($resp1);
        echo $myJSON;
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
            $resp1->set('2000','There is an error',"ID: ");
            $myJSON=json_encode($resp1);
            echo $myJSON;
        }
        if ($ar == 1) {
   }
            $resp1->set('2001','UPDATED SUCCESSFULLY',"ID: ".$id);
            $myJSON=json_encode($resp1);
            echo $myJSON;
        }


    } else {
        $resp1->set('2002','You have an error in your sql statement',"ID: ");
        $myJSON=json_encode($resp1);
        echo $myJSON;
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
            $resp1->set('3000','There is an error',"ID: ");
            $myJSON=json_encode($resp1);
            echo $myJSON;
        }
        if ($ar == 1) {
   $resp1->set('3001','DELETED SUCCESSFULLY',"ID: ".$id);
            $myJSON=json_encode($resp1);
            echo $myJSON;
        }


    } else {
        $resp1->set('3002','You have an error in your sql statement',"ID: ");
        $myJSON=json_encode($resp1);
        echo $myJSON;    }

}
?>

