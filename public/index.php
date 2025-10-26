<?php
// filename: public/index.php

session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';

$pageTitle = 'Home - QuizMaster';
$cssPath = '../assets/css/styles.css';
$jsPath = '../assets/js/script.js';
?>

<?php include '../includes/header.php'; ?>

<main>
    <section class="hero">
        <div class="container">
            <h1>Welcome to QuizMaster</h1>
            <p>Test your knowledge across multiple subjects with our comprehensive quiz system. Challenge yourself with questions on Science, History, General Knowledge, and Current Affairs.</p>
            <?php if (!isLoggedIn()): ?>
                <a href="register.php" class="btn-primary">Get Started</a>
            <?php else: ?>
                <a href="dashboard.php" class="btn-primary">Take a Quiz</a>
            <?php endif; ?>
        </div>
    </section>

    <div class="container">
        <section class="topics">
            <h2 style="text-align: center; margin-bottom: 3rem; font-size: 2.5rem; color: var(--text-primary);">Choose Your Topic</h2>
            <div class="topics-grid">
                <div class="topic-card science" onclick="<?php echo isLoggedIn() ? "window.location.href='quiz.php?topic=Science'" : "window.location.href='login.php'"; ?>">
                    <span class="icon">🔬</span>
                    <h3>Science</h3>
                    <p>Test your knowledge of Physics, Chemistry, Biology, and General Science concepts.</p>
                    <div class="btn-secondary">Start Quiz</div>
                </div>

                <div class="topic-card history" onclick="<?php echo isLoggedIn() ? "window.location.href='quiz.php?topic=History'" : "window.location.href='login.php'"; ?>">
                    <span class="icon">🏛️</span>
                    <h3>History</h3>
                    <p>Explore questions about World History, Ancient Civilizations, and Historical Events.</p>
                    <div class="btn-secondary">Start Quiz</div>
                </div>

                <div class="topic-card general" onclick="<?php echo isLoggedIn() ? "window.location.href='quiz.php?topic=General Knowledge'" : "window.location.href='login.php'"; ?>">
                    <span class="icon">🧠</span>
                    <h3>General Knowledge</h3>
                    <p>Mixed questions covering various topics and current awareness.</p>
                    <div class="btn-secondary">Start Quiz</div>
                </div>

                <div class="topic-card current" onclick="<?php echo isLoggedIn() ? "window.location.href='quiz.php?topic=Current Affairs'" : "window.location.href='login.php'"; ?>">
                    <span class="icon">📰</span>
                    <h3>Current Affairs</h3>
                    <p>Questions about recent events, news, and contemporary issues.</p>
                    <div class="btn-secondary">Start Quiz</div>
                </div>
            </div>
        </section>

        <?php if (!isLoggedIn()): ?>
        <section style="text-align: center; margin: 4rem 0; padding: 3rem; background: var(--card-background); border-radius: var(--border-radius); box-shadow: var(--shadow);">
            <h2 style="margin-bottom: 1rem; color: var(--text-primary);">Ready to Get Started?</h2>
            <p style="margin-bottom: 2rem; color: var(--text-secondary); font-size: 1.1rem;">Create your account today and start testing your knowledge!</p>
            <a href="register.php" class="btn-primary" style="margin-right: 1rem;">Sign Up Now</a>
            <a href="login.php" class="btn-secondary">Already have an account?</a>
        </section>
        <?php endif; ?>
    </div>
</main>

<?php include '../includes/footer.php'; ?>
