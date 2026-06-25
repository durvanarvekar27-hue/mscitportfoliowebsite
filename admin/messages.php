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
    "SELECT * FROM messages ORDER BY id DESC"
);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Messages</title>

<link rel="stylesheet" href="admin.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>

<div class="container">

<aside class="sidebar">

<h2>Admin Panel</h2>

<ul>
<li><a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
<li><a href="students.php"><i class="fas fa-users"></i> Students</a></li>
<li><a href="add-student.php"><i class="fas fa-user-plus"></i> Add Student</a></li>
<li><a href="add-projects.php"><i class="fas fa-folder-plus"></i> Add Project</a></li>
<!-- <li><a href="manage-projects.php"><i class="fas fa-diagram-project"></i> Manage Projects</a></li> -->
<li><a href="messages.php" class="active"><i class="fas fa-envelope"></i> Messages</a></li>
<li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
</ul>

</aside>

<div class="main-content">

<div class="table-box glass-card">

<h2>
<i class="fas fa-envelope"></i>
Contact Messages
</h2>

<table>

<thead>
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Subject</th>
<th>Message</th>
<th>Date</th>
</tr>
</thead>

<tbody>

<?php
if(mysqli_num_rows($result)>0)
{
    while($row=mysqli_fetch_assoc($result))
    {
?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo $row['name']; ?></td>

<td><?php echo $row['email']; ?></td>

<td><?php echo $row['subject']; ?></td>

<td><?php echo $row['message']; ?></td>

<td><?php echo $row['created_at']; ?></td>

</tr>

<?php
    }
}
else
{
?>
<tr>
<td colspan="6" align="center">
No Messages Found
</td>
</tr>
<?php
}
?>

</tbody>

</table>

</div>

</div>

</div>

</body>
</html>