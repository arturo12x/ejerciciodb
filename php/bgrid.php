<?php
include_once('conex.php');
$params = array();
$totalRecords = array();
$data = array();
$sqltotal = "";
$sqlcon = "";
$params = $_REQUEST;
$limite = $params['rowCount'];




if (isset($params['current'])) {

    $page = $params['current'];
} else {
    $page = 1;
}

$mysql = 'SELECT * FROM STUDENTS ';
$sqltot.=$mysql;
$sqlcon.=$mysql;

if(!empty($busqueda)){
    $where.="WHERE (";
    $where.="name LIKE '%".$busqueda."%' ";
    $where.="OR lastname LIKE '%".$busqueda."%' ";
    $where.="OR age LIKE '%".$busqueda."%' ";
    $where.="OR email LIKE '%".$busqueda."%' )";
}
  //
if(!empty($where) or $where!=""){
    $sqltot.=$where;
    $sqlcon.=$where;
}
$sqlcon.="LIMIT $inicio, $limite";

$querytop = mysqli_query($conn, $sqltot) or die(mysqli_error($conn));

$totalRecords = mysqli_num_rows($querytop);

$queryrecords = mysqli_query($conn, $sqlcon) or die(mysqli_error($conn));


while ($row = mysqli_fetch_assoc($queryrecords)) {

    $data[] = $row;
}
$json_data = array(
    'current' => intval($page),
    'rowcount' => $inicio,
    'rows' => $data,
    'total' => $totalRecords,
);

echo json_encode($json_data);
