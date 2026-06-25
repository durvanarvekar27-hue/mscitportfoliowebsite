<?php
session_start();

if(!isset($_SESSION['admin_id']))
{
    header("Location: login.php");
    exit();
}

include("../database/config.php");

$id = $_GET['id'] ?? 0;

$result = mysqli_query(
    $conn,
    "SELECT * FROM students WHERE id='$id'"
);

$student = mysqli_fetch_assoc($result);

$msg = "";

if(isset($_POST['update_student']))
{
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name'] ?? '');
    $email     = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
    $phone     = mysqli_real_escape_string($conn, $_POST['phone'] ?? '');
    $about     = mysqli_real_escape_string($conn, $_POST['about'] ?? '');

    // check image
    if(!empty($_FILES['photo']['name']))
    {
        $photo = time().'_'.$_FILES['photo']['name'];

        $tmp = $_FILES['photo']['tmp_name'];

        $uploadPath = "../uploads/";

        if(!is_dir($uploadPath))
        {
            mkdir($uploadPath, 0777, true);
        }

        move_uploaded_file($tmp, $uploadPath.$photo);

        mysqli_query(
            $conn,
            "UPDATE students SET
                full_name='$full_name',
                email='$email',
                phone='$phone',
                about='$about',
                photo='$photo'
             WHERE id='$id'"
        );
    }
    else
    {
        mysqli_query(
            $conn,
            "UPDATE students SET
                full_name='$full_name',
                email='$email',
                phone='$phone',
                about='$about'
             WHERE id='$id'"
        );
    }

    $msg = "Student Updated Successfully";

    // refresh data
    $result = mysqli_query($conn, "SELECT * FROM students WHERE id='$id'");
    $student = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Edit Student</title>

<link rel="stylesheet" href="admin.css">
</head>

<body>

<div class="container">

    <aside class="sidebar">

        <h2>Admin Panel</h2>

        <ul>
            <li><a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="students.php"><i class="fas fa-users"></i> Students</a></li>
            <li><a href="add-student.php"><i class="fas fa-user-plus"></i> Add Student</a></li>
            <li><a href="add-projects.php"><i class="fa-solid fa-folder-open"></i>Add Projects</a></li>
            <!-- <li><a href="manage-projects.php"><i class="fas fa-diagram-project"></i>Manage Projects</a></li> -->
            <li><a href="messages.php"><i class="fas fa-envelope"></i> Messages</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>

    </aside>

    <main class="main-content">

        <div class="form-box glass-card">

            <h2>Edit Student</h2>

            <?php if($msg != "") { ?>
                <div class="success-msg">
                    <?php echo $msg; ?>
                </div>
            <?php } ?>

            <form method="POST" enctype="multipart/form-data">

                <input type="text"
                       name="full_name"
                       value="<?php echo $student['full_name']; ?>"
                       required>

                <!-- <input type="email"
                       name="email"
                       value="<?php echo $student['email']; ?>"> -->

                <input type="text"
                       name="phone"
                       value="<?php echo $student['phone']; ?>">

                <textarea name="about"><?php echo $student['about']; ?></textarea>

                <img src="../uploads/<?php echo $student['photo']; ?>"
                     width="120"
                     style="border-radius:10px;margin-bottom:15px;">

                <input type="file" name="photo">

                <button type="submit"
                        name="update_student"
                        class="btn">
                    Update Student
                </button>

            </form>

        </div>

    </main>

</div>

</body>
</html>