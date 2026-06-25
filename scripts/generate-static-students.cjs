const fs = require("fs");
const path = require("path");

const root = path.resolve(__dirname, "..");
const studentRoot = path.join(root, "all students data");
const uploadRoot = path.join(root, "uploads");
const profilesRoot = path.join(root, "profiles");

const nav = (prefix = "") => `
<header>
    <div class="logo">
        <img src="${prefix}mscit logo.png" alt="MSCIT Logo">
        <h2>MSCIT Portfolio Hub</h2>
    </div>
    <nav>
        <a href="${prefix}index.html">Home</a>
        <a href="${prefix}students.html">Students</a>
        <a href="${prefix}about.html">About</a>
        <a href="${prefix}contact.html">Contact</a>
    </nav>
</header>`;

const footer = () => `
<footer>
    <h3>MSCIT Portfolio Hub</h3>
    <p>Showcasing Student Skills & Achievements</p>
    <p>© 2026 All Rights Reserved</p>
</footer>`;

const escapeHtml = (value) =>
    String(value)
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;");

const slugify = (value) =>
    value
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, "-")
        .replace(/^-+|-+$/g, "");

const titleCase = (value) =>
    value
        .replace(/\d+/g, "")
        .replace(/\s+/g, " ")
        .trim()
        .split(" ")
        .filter(Boolean)
        .map((part) => part.charAt(0).toUpperCase() + part.slice(1).toLowerCase())
        .join(" ");

const categoryName = (dir) => {
    const clean = dir.toLowerCase();
    if (clean.includes("word")) return "MS Word";
    if (clean.includes("excel")) return "MS Excel";
    if (clean.includes("power")) return "PowerPoint";
    if (clean.includes("ppt")) return "PowerPoint";
    if (clean.includes("canva")) return "Canva Design";
    if (clean.includes("web")) return "Web Page";
    if (clean.includes("photo")) return "PhotoShop";
    if (clean.includes("coral")) return "CoralDraw";
    return titleCase(dir) || "Additional";
};

const listFiles = (dir, depth = 0) => {
    if (depth > 2 || !fs.existsSync(dir)) return [];
    return fs.readdirSync(dir, { withFileTypes: true }).flatMap((entry) => {
        const full = path.join(dir, entry.name);
        if (entry.isDirectory()) return listFiles(full, depth + 1);
        if (entry.name === "Thumbs.db" || entry.name.startsWith("~$")) return [];
        return [full];
    });
};

const photos = fs
    .readdirSync(uploadRoot)
    .filter((file) => /\.(jpe?g|png|webp)$/i.test(file))
    .map((file) => ({ file, key: file.toLowerCase() }));

const pickPhoto = (name) => {
    const parts = name.toLowerCase().replace(/\d+/g, " ").split(/[^a-z]+/).filter(Boolean);
    const first = parts[0] || "";
    const last = parts[parts.length - 1] || "";
    const match = photos.find(({ key }) => first && last && key.includes(first) && key.includes(last.charAt(0)));
    return match ? `uploads/${match.file}` : "logo.png";
};

const students = fs
    .readdirSync(studentRoot, { withFileTypes: true })
    .filter((entry) => entry.isDirectory())
    .map((entry) => {
        const displayName = titleCase(entry.name);
        return {
            displayName,
            folder: path.join(studentRoot, entry.name),
            slug: slugify(displayName || entry.name),
            photo: pickPhoto(displayName || entry.name),
        };
    })
    .filter((student) => student.displayName)
    .sort((a, b) => a.displayName.localeCompare(b.displayName));

fs.mkdirSync(profilesRoot, { recursive: true });

for (const student of students) {
    const projects = listFiles(student.folder)
        .map((file) => {
            const rel = path.relative(root, file).split(path.sep).map(encodeURIComponent).join("/");
            const parent = path.basename(path.dirname(file));
            const name = path.basename(file);
            return { href: `../${rel}`, category: categoryName(parent), name };
        })
        .sort((a, b) => a.category.localeCompare(b.category) || a.name.localeCompare(b.name));

    const projectCards = projects.length
        ? projects.map((project) => `
            <div class="project-card" data-type="${escapeHtml(project.category.toLowerCase())}">
                <h4>${escapeHtml(project.name.replace(/\.[^.]+$/, ""))}</h4>
                <p><b>Category:</b> ${escapeHtml(project.category)}</p>
                <a href="${project.href}" target="_blank" rel="noopener">View Project</a>
            </div>`).join("")
        : `<p>No projects found for this student.</p>`;

    const html = `<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>${escapeHtml(student.displayName)} | MSCIT Portfolio Hub</title>
<link rel="stylesheet" href="../style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
${nav("../")}
<div class="profile-container">
    <img src="../${student.photo.split("/").map(encodeURIComponent).join("/")}" alt="${escapeHtml(student.displayName)}">
    <h2>${escapeHtml(student.displayName)}</h2>
    <div class="info">
        <p><b>Course:</b> MSCIT Student</p>
        <p><b>About:</b> Student projects and practical assignments are collected below.</p>
    </div>
    <hr>
    <div class="filter-bar">
        <button onclick="filterProjects('ms word')">MS Word</button>
        <button onclick="filterProjects('ms excel')">MS Excel</button>
        <button onclick="filterProjects('canva design')">Canva Design</button>
        <button onclick="filterProjects('powerpoint')">PowerPoint</button>
        <button onclick="filterProjects('web page')">Web Page</button>
        <button onclick="filterProjects('photoshop')">PhotoShop</button>
        <button onclick="filterProjects('coraldraw')">CoralDraw</button>
    </div>
    <h3>Projects</h3>
    <div id="projects">${projectCards}</div>
</div>
<script>
function filterProjects(type) {
    const cards = document.querySelectorAll(".project-card");
    const selected = type.toLowerCase().trim();
    cards.forEach((card) => {
        card.style.display = card.getAttribute("data-type") === selected ? "block" : "none";
    });
}
</script>
</body>
</html>`;

    fs.writeFileSync(path.join(profilesRoot, `${student.slug}.html`), html);
}

const cards = students.map((student) => `
        <div class="student-card">
            <div class="student-image">
                <img src="${student.photo.split("/").map(encodeURIComponent).join("/")}" alt="${escapeHtml(student.displayName)}">
            </div>
            <div class="student-info">
                <h3>${escapeHtml(student.displayName)}</h3>
                <p>MSCIT Student</p>
                <a href="profiles/${student.slug}.html" class="profile-btn">View Profile</a>
            </div>
        </div>`).join("");

fs.writeFileSync(path.join(root, "students.html"), `<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Our Students</title>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<style>
.search-section{padding:30px 20px;background:#f8f8f8}.search-box{max-width:600px;margin:auto}.search-box input{width:100%;padding:15px 20px;font-size:18px;border:2px solid #ff7b00;border-radius:50px;outline:none}.search-box input:focus{box-shadow:0 0 15px rgba(255,123,0,0.3)}#noResult{text-align:center;color:red;font-size:22px;font-weight:bold;margin:20px 0;display:none}
</style>
</head>
<body>
${nav()}
<section class="students-hero">
    <div class="hero-content">
        <h1>Our MSCIT Students</h1>
        <p>Explore Student Profiles, Projects & Achievements</p>
    </div>
</section>
<section class="search-section">
    <div class="search-box">
        <input type="text" id="studentSearch" placeholder="Search Student Name..." onkeyup="searchStudents()">
    </div>
</section>
<p id="noResult">No Student Found</p>
<section class="students">
    <div class="student-grid">${cards}
    </div>
</section>
${footer()}
<script>
function searchStudents() {
    const filter = document.getElementById("studentSearch").value.toLowerCase();
    const cards = document.querySelectorAll(".student-card");
    let found = false;
    cards.forEach((card) => {
        const name = card.querySelector("h3").innerText.toLowerCase();
        const visible = name.includes(filter);
        card.style.display = visible ? "" : "none";
        if (visible) found = true;
    });
    document.getElementById("noResult").style.display = found ? "none" : "block";
}
</script>
</body>
</html>`);

console.log(`Generated students.html and ${students.length} profile pages.`);
