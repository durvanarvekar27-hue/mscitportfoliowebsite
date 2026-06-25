<?php
session_start();
include("../database/config.php");

$error = "";

if(isset($_POST['login']))
{
    $username = mysqli_real_escape_string($conn,$_POST['username']);
    $password = mysqli_real_escape_string($conn,$_POST['password']);

    $query = mysqli_query(
        $conn,
        "SELECT * FROM admin
         WHERE username='$username'
         AND password='$password'"
    );

    if(mysqli_num_rows($query) > 0)
    {
        $admin = mysqli_fetch_assoc($query);

        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_name'] = $admin['username'];

        header("Location: dashboard.php");
        exit();
    }
    else
    {
        $error = "Invalid Username or Password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login</title>

<link rel="stylesheet" href="admin.css">
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>
<body>

<div class="login-container">

    <div class="login-card">

        <h1>Admin Login</h1>

        <?php if($error!=""){ ?>
            <div class="error">
                <?php echo $error; ?>
            </div>
        <?php } ?>

        <form method="POST">

            <div class="input-box">
                <i class="fa fa-user"></i>

                <input
                    type="text"
                    name="username"
                    placeholder="Username"
                    required>
            </div>

            <div class="input-box">
                <i class="fa fa-lock"></i>

                <input
                    type="password"
                    name="password"
                    placeholder="Password"
                    required>
            </div>

            <button type="submit" name="login" class="login-btn">
    <i class="fas fa-sign-in-alt"></i> Login
</button>

        </form>

    </div>

</div>

</body>
</html>