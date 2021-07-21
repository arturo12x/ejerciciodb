<?php
include_once('conex.php');
$params = array();
$totalRecords = array();
$data = array();


if (isset($params['current'])) {

    $page = $params['current'];
} else {
    $page = 1;
}

$mysql = 'SELECT * FROM STUDENTS';

$querytop = mysqli_query($conn, $mysql) or die(mysqli_error($conn));

$totalRecords = mysqli_num_rows($querytop);

$queryrecords = mysqli_query($conn, $mysql) or die(mysqli_error($conn));


while ($row = mysqli_fetch_assoc($queryrecords)) {

    $data[] = $row;
}
$json_data = array(
    'current' =>intval($page),
    'rowcount' => 10,
    'rows' => $data,
    'total' => $totalRecords,
);

echo json_encode($json_data);
?>