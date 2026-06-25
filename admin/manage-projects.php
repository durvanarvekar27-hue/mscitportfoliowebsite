<?php
session_start();
include("../database/config.php");

/* SEARCH */
$search = $_GET['search'] ?? '';

$query = mysqli_query(
$conn,
"SELECT
students.id,
students.full_name,
COUNT(projects.id) AS total_projects

FROM students

LEFT JOIN projects
ON students.id = projects.student_id

WHERE students.full_name LIKE '%$search%'

GROUP BY students.id

ORDER BY students.full_name ASC"
);
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Manage Projects</title>

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

        <div class="table-box glass-card">

            <h2>
                <i class="fas fa-folder-open"></i>
                Manage Projects
            </h2>

            <form method="GET" class="search-form">

                <input
                type="text"
                name="search"
                placeholder="Search Student..."
                value="<?php echo $search; ?>">

                <button
                type="submit"
                class="edit-btn">

                    <i class="fas fa-search"></i>
                    Search

                </button>

            </form>

            <div class="projects-grid">

            <?php

            if(mysqli_num_rows($query)>0)
            {
                while($row=mysqli_fetch_assoc($query))
                {
            ?>

                <div class="student-project-card">

                    <div class="student-header">

                        <h3>

                            <i class="fas fa-user-graduate"></i>

                            <?php echo $row['full_name']; ?>

                        </h3>

                        <span class="project-count">

                            <?php echo $row['total_projects']; ?>
                            Projects

                        </span>

                    </div>

                    <a
                    href="student-projects.php?id=<?php echo $row['id']; ?>"
                    class="view-btn">

                        <i class="fas fa-folder-open"></i>
                        View Projects

                    </a>

                </div>

            <?php
                }
            }
            else
            {
                echo "<p>No Students Found</p>";
            }
            ?>

            </div>

        </div>

    </div>

</div>

</body>
</html>