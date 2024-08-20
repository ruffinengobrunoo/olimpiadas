<?php
$servername = "sql110.infinityfree.com";
$username = "if0_37140050";
$password = "Xnp59VIX3y";
$dbname = "if0_37140050_ecommerse";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
