<?php
session_start();

if(!isset($_SESSION['admin_id']))
{
    header("Location: login.php");
    exit();
}

include("../database/config.php");

// Counts
$student_count = mysqli_num_rows(
    mysqli_query($conn, "SELECT * FROM students")
);

$message_count = mysqli_num_rows(
    mysqli_query($conn, "SELECT * FROM contact_messages")
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Admin Dashboard</title>

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
            <h1>
                Welcome, <?php echo $_SESSION['admin_name']; ?>
            </h1>
        </div>

        <!-- Stats -->
        <div class="stats">

            <div class="card">
                <i class="fas fa-users"></i>
                <h2><?php echo $student_count; ?></h2>
                <p>Total Students</p>
            </div>

            <div class="card">
                <i class="fas fa-envelope"></i>
                <h2><?php echo $message_count; ?></h2>
                <p>Contact Messages</p>
            </div>

        </div>

        <!-- Recent Students -->
        <div class="recent">

            <h2>Recent Students</h2>

            <table>

                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                </tr>

                <?php
                $recent = mysqli_query(
                    $conn,
                    "SELECT * FROM students ORDER BY id DESC LIMIT 5"
                );

                while($row = mysqli_fetch_assoc($recent))
                {
                ?>

                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['full_name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['phone']; ?></td>
                </tr>

                <?php } ?>

            </table>

        </div>

    </main>

</div>

</body>
</html>