<!-- filename: public/dashboard.php -->
<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';
requireLogin();

$pageTitle = 'Dashboard - QuizMaster';
$cssPath = '../assets/css/styles.css';
$jsPath = '../assets/js/script.js';
?>
<?php include '../includes/header.php'; ?>

<main>
    <div class="container">
        <h2 style="text-align:center;margin:2.5rem 0 1rem;font-size:2.5rem;">Quiz Dashboard</h2>
        <p style="text-align:center;color:var(--text-secondary);margin-bottom:2rem;">
            Pick a topic below and test your knowledge!
        </p>
        <div class="topics-grid">
            <div class="topic-card science" onclick="window.location.href='quiz.php?topic=Science'">
                <span class="icon">🔬</span>
                <h3>Science</h3>
                <p>Test your knowledge of Physics, Chemistry, Biology, and General Science concepts.</p>
                <div class="btn-secondary">Start Quiz</div>
            </div>
            <div class="topic-card history" onclick="window.location.href='quiz.php?topic=History'">
                <span class="icon">🏛️</span>
                <h3>History</h3>
                <p>Explore questions about World History, Ancient Civilizations, and Historical Events.</p>
                <div class="btn-secondary">Start Quiz</div>
            </div>
            <div class="topic-card general" onclick="window.location.href='quiz.php?topic=General Knowledge'">
                <span class="icon">🧠</span>
                <h3>General Knowledge</h3>
                <p>Mixed questions covering various topics and current awareness.</p>
                <div class="btn-secondary">Start Quiz</div>
            </div>
            <div class="topic-card current" onclick="window.location.href='quiz.php?topic=Current Affairs'">
                <span class="icon">📰</span>
                <h3>Current Affairs</h3>
                <p>Questions about recent events, news, and contemporary issues.</p>
                <div class="btn-secondary">Start Quiz</div>
            </div>
        </div>
    </div>
</main>
<?php include '../includes/footer.php'; ?>
