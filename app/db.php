<?php
ob_start();
session_start();


// $mysqli = new mysqli('localhost', 'teamciph_vadiya', 'CzI{DOZCUwps=n18', 'teamciph_vadiya');
$mysqli = new mysqli('localhost', 'root', '', 'care');

$mysqli->set_charset("utf8mb4");
if ($mysqli->connect_error) {
    die($mysqli->connect_error);
}

?>