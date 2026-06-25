<?php
include("database/config.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>About Us | MSCIT Portfolio Hub</title>

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
<section class="about-hero">

    <h1>About MSCIT</h1>

    <p>
        Empowering students with digital literacy,
        computer knowledge and practical IT skills
        for the modern digital world.
    </p>

</section>

<!-- ABOUT MSCIT -->
<section class="about-section">

    <div class="glass-box">

        <h2>What is MSCIT?</h2>

        <p>
            MSCIT (Maharashtra State Certificate in Information Technology)
            is one of Maharashtra's most popular IT literacy courses.
        </p>

        <p>
            The course helps students, professionals and citizens
            develop essential computer knowledge and digital skills.
        </p>

        <p>
            Topics include Computer Fundamentals,
            MS Office, Internet Applications,
            Digital Services, Cyber Security and
            Modern Technology Tools.
        </p>

    </div>

</section>

<!-- FEATURES -->
<section class="features">

    <h2 class="section-title">What Students Learn</h2>

    <div class="feature-grid">

        <div class="feature-card">
            <i class="fas fa-desktop"></i>
            <h3>Computer Basics</h3>
            <p>
                Learn computer fundamentals,
                hardware, software and daily operations.
            </p>
        </div>

        <div class="feature-card">
            <i class="fas fa-file-word"></i>
            <h3>MS Office</h3>
            <p>
                Create documents, spreadsheets,
                presentations and reports.
            </p>
        </div>

        <div class="feature-card">
            <i class="fas fa-globe"></i>
            <h3>Internet Skills</h3>
            <p>
                Learn browsing, email communication,
                online services and digital tools.
            </p>
        </div>

        <div class="feature-card">
            <i class="fas fa-shield-alt"></i>
            <h3>Cyber Security</h3>
            <p>
                Understand safe internet practices
                and digital security awareness.
            </p>
        </div>

    </div>

</section>

<!-- MISSION -->
<section class="mission">

    <div class="glass-box">

        <h2>Our Mission</h2>

        <p>
            To showcase student achievements,
            skills, projects and learning outcomes
            through a modern portfolio platform
            that inspires growth and innovation.
        </p>

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
