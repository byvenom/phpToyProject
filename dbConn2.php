<?
$host="203.231.238.145";
$user="root";
$pw="inet5650";
$dbName="songtest";
$conn = mysqli_connect($host,$user,$pw,$dbName);

header('Content-Type: application/json; charset=UTF-8');
header("HTTP/1.1 200 OK ");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
?>