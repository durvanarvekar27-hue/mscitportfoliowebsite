<?php
include("../database/config.php");

if(isset($_GET['id']))
{
    $id = intval($_GET['id']);

    // Get file path first
    $result = mysqli_query(
        $conn,
        "SELECT file_path FROM projects WHERE id='$id'"
    );

    $project = mysqli_fetch_assoc($result);

    if($project)
    {
        $file = "../" . $project['file_path'];

        if(file_exists($file))
        {
            unlink($file); // delete uploaded file
        }

        mysqli_query(
            $conn,
            "DELETE FROM projects WHERE id='$id'"
        );
    }

    header("Location: manage-projects.php");
    exit();
}
?>