<?php
session_start();

if(!isset($_SESSION['admin_id']))
{
    header("Location: login.php");
    exit();
}

include("../database/config.php");

$msg = "";

if(isset($_POST['add_student']))
{
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name'] ?? '');
    $email     = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
    $phone     = mysqli_real_escape_string($conn, $_POST['phone'] ?? '');
    $about     = mysqli_real_escape_string($conn, $_POST['about'] ?? '');

    $newPhoto = "";

    // IMAGE UPLOAD SAFETY CHECK
    if(isset($_FILES['photo']) && $_FILES['photo']['error'] == 0)
    {
        $photo = $_FILES['photo']['name'];
        $tmp   = $_FILES['photo']['tmp_name'];

        $newPhoto = time() . '_' . $photo;

        $uploadPath = "../uploads/";

        // Create folder if not exists
        if(!is_dir($uploadPath))
        {
            mkdir($uploadPath, 0777, true);
        }

        move_uploaded_file($tmp, $uploadPath . $newPhoto);
    }

    // INSERT INTO DATABASE
    $query = "INSERT INTO students (full_name, email, phone, photo, about)
              VALUES ('$full_name', '$email', '$phone', '$newPhoto', '$about')";

    if(mysqli_query($conn, $query))
    {
        $msg = "✅ Student added successfully!";
    }
    else
    {
        $msg = "❌ Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Add Student</title>

<link rel="stylesheet" href="admin.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>

<div class="container">

    <!-- Sidebar -->
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

    <!-- Main Content -->
    <main class="main-content">

        <div class="top-bar">
            <h1>Add Student</h1>
        </div>

        <div class="form-box glass-card">

            <?php if($msg != "") { ?>
                <div class="success-msg">
                    <?php echo $msg; ?>
                </div>
            <?php } ?>

            <form method="POST" enctype="multipart/form-data">

                <input type="text"
                       name="full_name"
                       placeholder="Full Name"
                       required>

                <!-- <input type="email"
                       name="email"
                       placeholder="Email"> -->

                <input type="text"
                       name="phone"
                       placeholder="Phone Number">

                <textarea name="about"
                          placeholder="About Student"></textarea>

                <input type="file"
                       name="photo"
                       required>

                <button type="submit"
                        name="add_student"
                        class="btn">
                    Add Student
                </button>

            </form>

        </div>

    </main>

</div>

</body>
</html>