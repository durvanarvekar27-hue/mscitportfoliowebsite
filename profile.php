<?php
include("database/config.php");
session_start();

/* SAFE ID CHECK */
if(!isset($_GET['id']) || empty($_GET['id'])){
    die("No student ID provided in URL");
}

$id = intval($_GET['id']);

/* STUDENT FETCH */
$student = mysqli_query($conn, "SELECT * FROM students WHERE id=$id");
$data = mysqli_fetch_assoc($student);

if(!$data){
    echo "Student not found";
    exit;
}

$student_id = intval($data['id']);

/* PROJECTS FETCH */
$projects = mysqli_query($conn, "SELECT * FROM projects WHERE student_id=$student_id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Student Profile</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<header>
    <div class="logo">
        <img src="mscit logo.png" alt="logo">
        <h2>MSCIT Portfolio Hub</h2>
    </div>

    <nav>
        <a href="home.php">Home</a>
        <a href="students.php">Students</a>
        <a href="about.php">About</a>
        <a href="contact.php">Contact</a>
    </nav>
</header>

<div class="profile-container">

    <img src="uploads/<?php echo $data['photo'] ?: 'default.png'; ?>" alt="profile">

    <h2><?php echo $data['full_name']; ?></h2>

    <div class="info">
        <!-- <p><b>Email:</b> <?php echo $data['email']; ?></p> -->
        <p><b>Phone:</b> <?php echo $data['phone']; ?></p>
        <p><b>Course:</b> <?php echo $data['course']; ?></p>
        <p><b>About:</b> <?php echo $data['about']; ?></p>
    </div>

    <hr>

    <!-- FILTER BUTTONS -->
    <div class="filter-bar">
        <button onclick="filterProjects('ms word')">MS Word</button>
        <button onclick="filterProjects('ms excel')">Ms Excel</button>
        <button onclick="filterProjects('canva design')">Canva Design</button>
        <button onclick="filterProjects('powerpoint')">PowerPoint</button>
        <button onclick="filterProjects('web page')">Web Page</button>
        <button onclick="filterProjects('photoshop')">PhotoShop</button>
        <button onclick="filterProjects('coraldraw')">CoralDraw</button>
    </div>

    <h3>Projects</h3>

    <div id="projects">

        <?php while($row = mysqli_fetch_assoc($projects)) { ?>

            <div class="project-card"
                 data-type="<?php echo strtolower(trim($row['category'])); ?>">

                <h4><?php echo $row['project_title'] ?? 'No Title'; ?></h4>

                <p><b>Category:</b> <?php echo $row['category']; ?></p>

                <?php if(!empty($row['file_path'])) { ?>
                    <a href="<?php echo $row['file_path']; ?>" target="_blank">
                        View Project
                    </a>
                <?php } else { ?>
                    <p>No file uploaded</p>
                <?php } ?>

            </div>

        <?php } ?>

    </div>

</div>

<script>
function filterProjects(type) {

    let cards = document.querySelectorAll(".project-card");

    type = type.toLowerCase().trim();

    cards.forEach(card => {

        let cardType = card.getAttribute("data-type");

        if(cardType){
            cardType = cardType.toLowerCase().trim();
        }

        if(cardType === type){
            card.style.display = "block";
        }
        else{
            card.style.display = "none";
        }
    });
}
</script>

</body>
</html>