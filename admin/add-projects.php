<?php
include("../database/config.php");

// Fetch Students
$students = mysqli_query(
$conn,
"SELECT id, full_name FROM students ORDER BY full_name ASC"
);

// Insert Project
if(isset($_POST['submit']))
{
    $student_id    = $_POST['student_id'];
    $category      = $_POST['category'];
    $project_title = $_POST['project_title'];

    $file_name = $_FILES['project_file']['name'];
    $tmp_name  = $_FILES['project_file']['tmp_name'];

    $new_file_name = time() . "_" . $file_name;

    $upload_folder = "../uploads/projects/";

    if(!file_exists($upload_folder))
    {
        mkdir($upload_folder,0777,true);
    }

    move_uploaded_file(
        $tmp_name,
        $upload_folder . $new_file_name
    );

    $file_path = "uploads/projects/" . $new_file_name;

    $query = "INSERT INTO projects
    (student_id, category, project_title, file_path)

    VALUES

    ('$student_id',
     '$category',
     '$project_title',
     '$file_path')";

    if(mysqli_query($conn,$query))
    {
        echo "<script>
        alert('Project Added Successfully');
        window.location='add-projects.php';
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Add Project</title>

<link rel="stylesheet" href="admin.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<div class="container">

    <!-- SIDEBAR -->
    <aside class="sidebar">

        <h2>Admin Panel</h2>

        <ul>

            <li>
                <a href="dashboard.php">
                    <i class="fa-solid fa-home"></i>
                    Dashboard
                </a>
            </li>

            <li>
                <a href="students.php">
                    <i class="fa-solid fa-users"></i>
                    Students
                </a>
            </li>

            <li>
                <a href="add-student.php">
                    <i class="fa-solid fa-user-plus"></i>
                    Add Student
                </a>
            </li>

            <li>
                <a href="add-projects.php" class="active">
                    <i class="fa-solid fa-folder-open"></i>
                    Add Projects
                </a>
            </li>

            <!-- <li>
                <a href="manage-projects.php">
                    <i class="fas fa-diagram-project"></i>
                    Manage Projects
                </a>
            </li> -->

            <li>
                <a href="messages.php">
                    <i class="fa-solid fa-envelope"></i>
                    Messages
                </a>
            </li>

            <li>
                <a href="logout.php">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Logout
                </a>
            </li>

        </ul>

    </aside>

    <!-- MAIN CONTENT -->

    <div class="main-content">

        <div class="project-form">

            <h2>
                <i class="fa-solid fa-folder-plus"></i>
                Add New Project
            </h2>

            <form method="POST"
                  enctype="multipart/form-data">

                <!-- Student -->

                <div class="form-group">

                    <label>Select Student</label>

                    <select name="student_id" required>

                        <option value="">
                            -- Select Student --
                        </option>

                        <?php
                        while($row=mysqli_fetch_assoc($students))
                        {
                        ?>

                        <option
                        value="<?php echo $row['id']; ?>">

                            <?php
                            echo $row['full_name'];
                            ?>

                        </option>

                        <?php
                        }
                        ?>

                    </select>

                </div>

                <!-- Category -->

                <div class="form-group">

                    <label>Project Category</label>

                    <select name="category" required>

                        <option value="">
                            Select Category
                        </option>

                        <option value="MS Word">
                            MS Word
                        </option>

                        <option value="MS Excel">
                            MS Excel
                        </option>

                        <option value="PowerPoint">
                            PowerPoint
                        </option>

                        <option value="Canva Design">
                            Canva Design
                        </option>

                        <option value="Logo Design">
                            Logo Design
                        </option>

                        <option value="Web Page">
                            Web Page
                        </option>

                        <option value="Photoshop">
                            Photoshop
                        </option>

                        <option value="CoralDraw">
                            CoralDraw
                        </option>

                    </select>

                </div>

                <!-- Project Title -->

                <div class="form-group">

                    <label>Project Title</label>

                    <input
                    type="text"
                    name="project_title"
                    placeholder="Enter Project Title"
                    required>

                </div>

                <!-- File Upload -->

                <div class="form-group">

                    <label>Upload Project File</label>

                    <input
                    type="file"
                    name="project_file"
                    required>

                </div>

                <!-- Submit -->

                <button
                type="submit"
                name="submit"
                class="submit-btn">

                    <i class="fa-solid fa-upload"></i>
                    Upload Project

                </button>

            </form>

        </div>

    </div>

</div>

</body>
</html>