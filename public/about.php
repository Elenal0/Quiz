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
            It was designed and developed by passionate tech enthusiasts dedicated to learning and sharing knowledge.
        </p>
        <div class="profile-stats">
            <div class="stat-card">
                <img src="../assets/images/dev1.jpg" class="dev-image" alt="Dev 1">
                <h4>John Doe</h4>
                <p>Full Stack Developer</p>
                <div class="social-links">
                    <a href="#">LinkedIn</a>
                    <a href="#">GitHub</a>
                </div>
            </div>
            <div class="stat-card">
                <img src="../assets/images/dev2.jpg" class="dev-image" alt="Dev 2">
                <h4>Jane Smith</h4>
                <p>UI/UX Designer</p>
                <div class="social-links">
                    <a href="#">LinkedIn</a>
                    <a href="#">Dribbble</a>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include '../includes/footer.php'; ?>
