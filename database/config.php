<?php

$host = "localhost";
$user = "root";
$pass = "";
$db   = "mscit_portfolio";

$conn = mysqli_connect("localhost", "root", "", "mscit_portfolio", 3307);
if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

?>