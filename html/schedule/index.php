<?php
require($_SERVER['DOCUMENT_ROOT']."/admin/header.php");

$serverName = "VUZ-DB\SQLEXPRESS";
$connectionInfo = array("Database"=>"Расписание","UID"=>"rasp","PWD"=>"123456");

$conn = sqlsrv_connect($serverName,$connectionInfo);

if( $conn ) {
    echo "Connection established.<br />";
}else{
    echo "Connection could not be established.<br />";
    die( print_r( sqlsrv_errors(), true));
}
?>

