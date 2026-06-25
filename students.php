<?php
include("database/config.php");

$result = mysqli_query(
    $conn,
    "SELECT * FROM students ORDER BY full_name ASC"
);
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Our Students</title>

<link rel="stylesheet" href="style.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>

/* Search Section */

.search-section{
    padding:30px 20px;
    background:#f8f8f8;
}

.search-box{
    max-width:600px;
    margin:auto;
}

.search-box input{
    width:100%;
    padding:15px 20px;
    font-size:18px;
    border:2px solid #ff7b00;
    border-radius:50px;
    outline:none;
}

.search-box input:focus{
    box-shadow:0 0 15px rgba(255,123,0,0.3);
}

#noResult{
    text-align:center;
    color:red;
    font-size:22px;
    font-weight:bold;
    margin:20px 0;
    display:none;
}

</style>

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

<section class="students-hero">

    <div class="hero-content">

        <h1>Our MSCIT Students</h1>

        <p>
            Explore Student Profiles,
            Projects & Achievements
        </p>

    </div>

</section>

<!-- Search Bar -->

<section class="search-section">

    <div class="search-box">

        <input
            type="text"
            id="studentSearch"
            placeholder="🔍 Search Student Name..."
            onkeyup="searchStudents()">

    </div>

</section>

<p id="noResult">No Student Found</p>

<section class="students">

    <div class="student-grid">

        <?php

        if(mysqli_num_rows($result) > 0)
        {
            while($row = mysqli_fetch_assoc($result))
            {
        ?>

        <div class="student-card">

            <div class="student-image">

                <img
                src="uploads/<?php echo $row['photo']; ?>"
                alt="<?php echo $row['full_name']; ?>">

            </div>

            <div class="student-info">

                <h3>
                    <?php echo $row['full_name']; ?>
                </h3>

                <p>
                    <?php echo $row['phone']; ?>
                </p>

                <a
                href="profile.php?id=<?php echo $row['id']; ?>"
                class="profile-btn">

                    View Profile

                </a>

            </div>

        </div>

        <?php
            }
        }
        else
        {
            echo "<h2>No Students Found</h2>";
        }
        ?>

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

<script>

function searchStudents()
{
    let input =
    document.getElementById("studentSearch");

    let filter =
    input.value.toLowerCase();

    let cards =
    document.querySelectorAll(".student-card");

    let found = false;

    cards.forEach(function(card)
    {
        let name =
        card.querySelector("h3")
        .innerText.toLowerCase();

        if(name.includes(filter))
        {
            card.style.display = "";
            found = true;
        }
        else
        {
            card.style.display = "none";
        }
    });

    document.getElementById("noResult").style.display =
    found ? "none" : "block";
}

</script>

</body>
</html>