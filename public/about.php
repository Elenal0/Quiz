<!-- filename: public/about.php -->
<?php
session_start();
require_once '../includes/functions.php';
$pageTitle = 'About - QuizMaster';
$cssPath = '../assets/css/styles.css';
$jsPath = '../assets/js/script.js';
?>
<?php include '../includes/header.php'; ?>

<main>
    <div class="container">
        <h2 style="text-align:center;margin:2rem 0 1rem;">About QuizMaster</h2>
        <p style="text-align:center;max-width:700px;margin:0 auto 2rem;">
            QuizMaster is a modern, open-source quiz platform built with PHP, MySQL, HTML, CSS, and JavaScript. 
            It is designed and developed by passionate tech enthusiasts dedicated to learning and sharing knowledge.
        </p>
        <div class="profile-stats">
            <div class="stat-card">
                <img src="../assets/images/bilal.png" class="dev-imageA" alt="Bilal">
                <h4>Bilal Teli</h4>
                <p>Worked on - Backend, Frontend, Bug fixes</p>
                <div class="social-links">
                    <a href="https://www.linkedin.com/in/bilal-teli-42ab0137a/">LinkedIn</a>
                    <a href="https://github.com/BilalTeli">GitHub</a>
                </div>
            </div>
            <div class="stat-card">
                <img src="../assets/images/dev.png" class="dev-imageA" alt="Dev">
                <h4>Dev Tayade</h4>
                <p>Worked on - Xampp, Backend, Frontend</p>
                <div class="social-links">
                    <a href="https://www.linkedin.com/in/dev-tayade-834b692ab">LinkedIn</a>
                    <a href="https://github.com/iblameDev17">Github</a>
                </div>
            </div>
            <div class="stat-card">
                <img src="../assets/images/nupur.png" class="dev-imageA" alt="Nupur">
                <h4>Nupur Thakur </h4>
                <p>Worked on - UI/UX, Git, Frontend</p>
                <div class="social-links">
                    <a href="https://www.linkedin.com/in/nupurth60/">LinkedIn</a>
                    <a href="https://github.com/Elenal0">Github</a>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include '../includes/footer.php'; ?>
