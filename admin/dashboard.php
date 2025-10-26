<!-- filename: admin/dashboard.php -->
<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';
requireAdmin();

$stmt = $pdo->query("SELECT COUNT(*) as user_count FROM users WHERE is_admin=0");
$userCount = $stmt->fetchColumn();
$stmt = $pdo->query("SELECT COUNT(*) as q_count FROM questions");
$qCount = $stmt->fetchColumn();

$pageTitle = 'Admin Dashboard - QuizMaster';
$cssPath = '../assets/css/styles.css';
?>
<?php include '../includes/header.php'; ?>
<main>
    <div class="container">
        <h2 style="margin-top:2rem;">Admin Dashboard</h2>
        <div class="profile-stats">
            <div class="stat-card">
                <div class="stat-number"><?php echo $userCount; ?></div>
                <div class="stat-label">Users</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $qCount; ?></div>
                <div class="stat-label">Questions</div>
            </div>
        </div>
        <div style="margin:2rem 0;">
            <a href="questions.php" class="btn-primary" style="margin-right:1rem;">Manage Questions</a>
            <a href="users.php" class="btn-secondary">View User Attempts</a>
            <a href="logout.php" class="btn-secondary" style="float:right;">Logout</a>
        </div>
    </div>
</main>
<?php include '../includes/footer.php'; ?>
