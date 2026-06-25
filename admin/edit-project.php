<?php
session_start();
include("../database/config.php");

/* CHECK ID */
if(!isset($_GET['id']))
{
    header("Location: manage-projects.php");
    exit();
}

$id = intval($_GET['id']);

/* FETCH PROJECT */
$result = mysqli_query($conn,
"SELECT * FROM projects WHERE id='$id'");

$data = mysqli_fetch_assoc($result);

if(!$data)
{
    die("Project Not Found");
}

/* UPDATE PROJECT */
if(isset($_POST['update']))
{
    $category      = mysqli_real_escape_string(
                        $conn,
                        $_POST['category']
                     );

    $project_title = mysqli_real_escape_string(
                        $conn,
                        $_POST['project_title']
                     );

    $update = mysqli_query($conn,
    "UPDATE projects SET
     category='$category',
     project_title='$project_title'
     WHERE id='$id'");

    if($update)
    {
        header("Location: manage-projects.php?msg=updated");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Edit Project</title>

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
                    <i class="fas fa-home"></i>
                    Dashboard
                </a>
            </li>

            <li>
                <a href="students.php">
                    <i class="fas fa-users"></i>
                    Students
                </a>
            </li>

            <li>
                <a href="add-student.php">
                    <i class="fas fa-user-plus"></i>
                    Add Student
                </a>
            </li>

            <li>
                <a href="add-projects.php">
                    <i class="fas fa-folder-plus"></i>
                    Add Project
                </a>
            </li>

            <!-- <li>
                <a href="manage-projects.php" class="active">
                    <i class="fas fa-diagram-project"></i>
                    Manage Projects
                </a>
            </li> -->

            <li>
                <a href="messages.php">
                    <i class="fas fa-envelope"></i>
                    Messages
                </a>
            </li>

            <li>
                <a href="logout.php">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </a>
            </li>

        </ul>

    </aside>

    <!-- MAIN CONTENT -->

    <div class="main-content">

        <div class="project-form">

            <h2>
                <i class="fas fa-pen-to-square"></i>
                Edit Project
            </h2>

            <form method="POST">

                <div class="form-group">

                    <label>Project Category</label>

                    <select name="category" required>

                        <option value="MS Word"
                        <?php if($data['category']=="MS Word") echo "selected"; ?>>
                        MS Word
                        </option>

                        <option value="MS Excel"
                        <?php if($data['category']=="MS Excel") echo "selected"; ?>>
                        MS Excel
                        </option>

                        <option value="PowerPoint"
                        <?php if($data['category']=="PowerPoint") echo "selected"; ?>>
                        PowerPoint
                        </option>

                        <option value="Canva Design"
                        <?php if($data['category']=="Canva Design") echo "selected"; ?>>
                        Canva Design
                        </option>

                        <option value="Logo Design"
                        <?php if($data['category']=="Logo Design") echo "selected"; ?>>
                        Logo Design
                        </option>

                        <option value="Web Page"
                        <?php if($data['category']=="Web Page") echo "selected"; ?>>
                        Web Page
                        </option>

                        <option value="Internet"
                        <?php if($data['category']=="Internet") echo "selected"; ?>>
                        Internet
                        </option>

                        <option value="Additional Project"
                        <?php if($data['category']=="Additional Project") echo "selected"; ?>>
                        Additional Project
                        </option>

                    </select>

                </div>

                <div class="form-group">

                    <label>Project Title</label>

                    <input
                    type="text"
                    name="project_title"
                    value="<?php echo htmlspecialchars($data['project_title']); ?>"
                    required>

                </div>

                <button
                type="submit"
                name="update"
                class="submit-btn">

                    <i class="fas fa-save"></i>
                    Update Project

                </button>

            </form>

            <br>

            <a href="manage-projects.php"
               class="back-link">

                <i class="fas fa-arrow-left"></i>
                Back to Manage Projects

            </a>

        </div>

    </div>

</div>

</body>
</html>