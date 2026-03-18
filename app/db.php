<?php
ob_start();
session_start();


// $mysqli = new mysqli('localhost', 'careline', '18hESPUFo7VJPw7goEvL', 'careline');
$mysqli = new mysqli('localhost', 'root', '', 'care');

$mysqli->set_charset("utf8mb4");
if ($mysqli->connect_error) {
    die($mysqli->connect_error);
}

?>