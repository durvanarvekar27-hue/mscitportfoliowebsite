<?php
include("database/config.php");

$query = "SELECT * FROM students ORDER BY id DESC LIMIT 4";
$result = mysqli_query($conn, $query);

$count_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM students");
$count_data = mysqli_fetch_assoc($count_query);
$total_students = $count_data['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MSCIT Student Portfolio Hub</title>

<link rel="stylesheet" href="style.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>

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

<section class="hero">

    <div class="hero-content">

        <h1>Welcome To MAAYA MSCIT Student Hub</h1>

        <p>
            Explore student profiles, projects,
            skills and achievements in one place.
        </p>

        <a href="students.php" class="btn">
            Explore Students
        </a>

    </div>

</section>

<section class="stats">

    <div class="stat-box">
        <h2><?php echo $total_students; ?>+</h2>
        <p>Students</p>
    </div>

    <div class="stat-box">
        <h2>200+</h2>
        <p>Projects</p>
    </div>

    <div class="stat-box">
        <h2>15+</h2>
        <p>Skills</p>
    </div>

    <div class="stat-box">
        <h2>100%</h2>
        <p>Practical Learning</p>
    </div>

</section>

<section class="students">

    <h2 class="section-title">
        Featured Students
    </h2>

    <div class="student-grid">

        <?php
        while($row = mysqli_fetch_assoc($result))
        {
        ?>

        <div class="student-card">

            <div class="student-image">

                <img
                src="uploads/<?php echo $row['photo']; ?>"
                alt="<?php echo $row['full_name']; ?>">

            </div>

            <h3>
                <?php echo $row['full_name']; ?>
            </h3>

            <p>
                MSCIT Student
            </p>

            <a
            href="profile.php?id=<?php echo $row['id']; ?>"
            class="profile-btn">
                View Profile
            </a>

        </div>

        <?php
        }
        ?>

    </div>

    <div style="text-align:center; margin-top:30px;">
        <a href="students.php" class="btn">
            View All Students
        </a>
    </div>

</section>

<section class="skills">

    <h2 class="section-title">
        MSCIT Skills
    </h2>

    <div class="skills-grid">

        <div class="skill">
            <i class="fa-brands fa-microsoft"></i>
            <span>MS Word</span>
        </div>

        <div class="skill">
            <i class="fa-solid fa-file-excel"></i>
            <span>MS Excel</span>
        </div>

        <div class="skill">
            <i class="fa-solid fa-file-powerpoint"></i>
            <span>PowerPoint</span>
        </div>

        <div class="skill">
            <i class="fa-solid fa-brush"></i>
            <span>Canva</span>
        </div>

        <div class="skill">
            <i class="fa-brands fa-html5"></i>
            <span>HTML</span>
        </div>

        <div class="skill">
            <i class="fa-brands fa-css3-alt"></i>
            <span>CSS</span>
        </div>

        <div class="skill">
            <i class="fa-solid fa-camera-retro"></i>
            <span>Photoshop</span>
        </div>

    </div>

</section>

<footer>

    <h3>MSCIT Portfolio Hub</h3>

    <p>
        Showcasing Student Skills & Achievements
    </p>

    <p>
        © 2026 All Rights Reserved
    </p>

</footer>

</body>
</html>

