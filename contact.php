<?php
include("database/config.php");

if(isset($_POST['send']))
{
    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $subject = mysqli_real_escape_string($conn,$_POST['subject']);
    $message = mysqli_real_escape_string($conn,$_POST['message']);

    mysqli_query(
        $conn,
        "INSERT INTO messages(name,email,subject,message)
         VALUES('$name','$email','$subject','$message')"
    );

    $success = "Message Sent Successfully!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Contact Us | MSCIT Portfolio Hub</title>

<link rel="stylesheet" href="style.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>

<!-- HEADER -->
<header>
    <div class="logo">
    <img src="mscit logo.png" alt="MSCIT Logo">
    <h2>MSCIT Portfolio Hub</h2>
</div>

    <nav>
        <a href="home.php">Home</a>
        <a href="students.php">Students</a>
        <a href="about.php">About</a>
        <a href="contact.php">Contact</a>
    </nav>
</header>

<!-- HERO -->
<section class="contact-hero">

    <h1>Contact Us</h1>

    <p>
        Have questions or need assistance?
        We'd love to hear from you.
    </p>

</section>

<!-- CONTACT SECTION -->
<section class="contact-container">

    <!-- Contact Form -->
    <div class="contact-form glass-card">

        <h2>Send Message</h2>

        <form method="POST">

<?php
if(isset($success))
{
    echo "<div class='success-msg'>$success</div>";
}
?>

<input type="text"
name="name"
placeholder="Your Name"
required>

<input type="email"
name="email"
placeholder="Your Email"
required>

<input type="text"
name="subject"
placeholder="Subject"
required>

<textarea
name="message"
rows="6"
placeholder="Write your message..."
required></textarea>

<button type="submit" name="send">
    Send Message
</button>

</form>

    </div>

    <!-- Contact Info -->
    <div class="contact-info glass-card">

        <h2>Contact Information</h2>

        <div class="info-box">
            <i class="fa-solid fa-location-dot"></i>
            <span>Panchami Heights, 204, College Rd, near Moti Talav, Sawantwadi, Maharashtra 416510</span>
        </div>

        <div class="info-box">
            <i class="fa-solid fa-phone"></i>
            <span>+91 9420277373</span>
        </div>

        <div class="info-box">
            <i class="fa-solid fa-envelope"></i>
            <span>education.maaya@gmail.com</span>
        </div>

        <div class="info-box">
            <i class="fa-solid fa-globe"></i>
            <span>maayacourses.com</span>
        </div>

    </div>

</section>

<!-- FOOTER -->
<footer>

    <h3>MSCIT Portfolio Hub</h3>

    <p>Showcasing Student Skills & Achievements</p>

    <p>© <?php echo date("Y"); ?> All Rights Reserved</p>

</footer>

</body>
</html>