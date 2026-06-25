<?php
require_once("../database/config.php");

$student_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if($student_id <= 0){
    die("Invalid Student ID");
}

/* DELETE PROJECT */
if(isset($_GET['delete'])){

    $delete_id = intval($_GET['delete']);

    /* GET FILE PATH */
    $fileQuery = mysqli_query(
        $conn,
        "SELECT file_path
         FROM projects
         WHERE id='$delete_id'
         AND student_id='$student_id'"
    );

    $fileData = mysqli_fetch_assoc($fileQuery);

    /* DELETE FILE FROM SERVER */
    if($fileData && !empty($fileData['file_path'])){

        $filePath = "../" . $fileData['file_path'];

        if(file_exists($filePath)){
            unlink($filePath);
        }
    }

    /* DELETE RECORD FROM DATABASE */
    mysqli_query(
        $conn,
        "DELETE FROM projects
         WHERE id='$delete_id'
         AND student_id='$student_id'"
    );

   header("Location: view-projects.php?id=$student_id");
    exit();
}

/* STUDENT DETAILS */
$student = mysqli_query(
    $conn,
    "SELECT full_name
     FROM students
     WHERE id='$student_id'"
);

$studentData = mysqli_fetch_assoc($student);

if(!$studentData){
    die("Student Not Found");
}

/* FETCH PROJECTS */
$projects = mysqli_query(
    $conn,
    "SELECT *
     FROM projects
     WHERE student_id='$student_id'
     ORDER BY id DESC"
);
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Student Projects</title>

<link rel="stylesheet" href="admin.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>
<body>

<div class="projects-container">

    <h2 class="projects-title">
        <i class="fas fa-folder-open"></i>
        <?php echo htmlspecialchars($studentData['full_name']); ?>'s Projects
    </h2>

    <?php if(mysqli_num_rows($projects) > 0){ ?>

    <div class="projects-grid">

        <?php while($row = mysqli_fetch_assoc($projects)){ ?>

        <div class="project-card">

            <span class="category">
                <?php echo htmlspecialchars($row['category']); ?>
            </span>

            <h3>
                <?php echo htmlspecialchars($row['project_title']); ?>
            </h3>

            <!-- VIEW BUTTON -->
            <a href="../<?php echo $row['file_path']; ?>"
               target="_blank"
               class="view-btn">

                <i class="fas fa-eye"></i>
                View Project

            </a>

            <!-- DELETE BUTTON -->
            <a href="view-projects.php?id=<?php echo $student_id; ?>&delete=<?php echo $row['id']; ?>"
   class="delete-btn"
   onclick="return confirm('Are you sure you want to delete this project?');">

    <i class="fas fa-trash"></i>
    Delete

</a>

        </div>

        <?php } ?>

    </div>

    <?php } else { ?>

    <div class="no-project">
        <h3>No Projects Added Yet</h3>
    </div>

    <?php } ?>

    <center>
        <a href="students.php" class="back-btn">
            <i class="fas fa-arrow-left"></i>
            Back to Students
        </a>
    </center>

</div>

</body>
</html>