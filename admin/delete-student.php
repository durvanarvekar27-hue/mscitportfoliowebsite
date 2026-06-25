<?php

session_start();

if(!isset($_SESSION['admin_id']))
{
    header("Location: login.php");
    exit();
}

include("../database/config.php");

$id = $_GET['id'];

$getStudent = mysqli_query(
    $conn,
    "SELECT * FROM students WHERE id='$id'"
);

$student = mysqli_fetch_assoc($getStudent);

if($student)
{
    if(file_exists("../uploads/".$student['photo']))
    {
        unlink("../uploads/".$student['photo']);
    }

    mysqli_query(
        $conn,
        "DELETE FROM students WHERE id='$id'"
    );
}

header("Location: students.php");
exit();
?>