<?php
session_start();

if(!isset($_SESSION['admin_id']))
{
    header("Location: login.php");
    exit();
}

include("../database/config.php");

$result = mysqli_query(
    $conn,
    "SELECT * FROM students ORDER BY id DESC"
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Manage Students</title>

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
            <li>
                <a href="dashboard.php">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </li>

            <li>
                <a href="students.php" class="active">
                    <i class="fas fa-users"></i> Students
                </a>
            </li>

            <li>
                <a href="add-student.php">
                    <i class="fas fa-user-plus"></i> Add Student
                </a>
            </li>

            <li>
                <a href="add-projects.php">
                    <i class="fas fa-folder-plus"></i> Add Projects
                </a>
            </li>

            <!-- <li>
                <a href="manage-projects.php">
                    <i class="fas fa-diagram-project"></i> Manage Projects
                </a>
            </li> -->

            <li>
                <a href="messages.php">
                    <i class="fas fa-envelope"></i> Messages
                </a>
            </li>

            <li>
                <a href="logout.php">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </li>
        </ul>

    </aside>

    <!-- Main Content -->
    <main class="main-content">

        <div class="top-bar">
            <h1>
                <i class="fas fa-users"></i>
                Manage Students
            </h1>
        </div>

        <div class="table-box glass-card">

            <table>

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Photo</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                <?php
                if(mysqli_num_rows($result) > 0)
                {
                    while($row = mysqli_fetch_assoc($result))
                    {
                ?>

                <tr>

                    <td>
                        <?php echo $row['id']; ?>
                    </td>

                    <td>

                        <?php
                        $photo = !empty($row['photo'])
                        ? $row['photo']
                        : 'default.png';
                        ?>

                        <img
                        src="../uploads/<?php echo $photo; ?>"
                        width="60"
                        height="60"
                        style="
                        border-radius:50%;
                        object-fit:cover;
                        border:2px solid #60a5fa;
                        ">

                    </td>

                    <td>
                        <?php echo $row['full_name']; ?>
                    </td>

                    <!-- <td>
                        {<?php echo $row['email']; ?>}
                    </td> -->

                    <td>
                        <?php echo $row['phone']; ?>
                    </td>

                    <td>

                        <!-- View Projects -->

                        <a href="view-projects.php?id=<?php echo $row['id']; ?>"
                           class="view-btn">
                           <i class="fas fa-eye"></i>
                           Projects
                        </a>

                        <!-- Edit -->

                        <a href="edit-student.php?id=<?php echo $row['id']; ?>"
                           class="edit-btn">
                           <i class="fas fa-edit"></i>
                           Edit
                        </a>

                        <!-- Delete -->

                        <a href="delete-student.php?id=<?php echo $row['id']; ?>"
                           class="delete-btn"
                           onclick="return confirm('Delete Student?')">
                           <i class="fas fa-trash"></i>
                           Delete
                        </a>

                    </td>

                </tr>

                <?php
                    }
                }
                else
                {
                ?>

                <tr>
                    <td colspan="6" style="text-align:center;">
                        No Students Found
                    </td>
                </tr>

                <?php
                }
                ?>

                </tbody>

            </table>

        </div>

    </main>

</div>

</body>
</html>