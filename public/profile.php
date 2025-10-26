<!-- filename: public/profile.php -->
<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';
requireLogin();

$pageTitle = 'Profile - QuizMaster';
$cssPath = '../assets/css/styles.css';
$jsPath = '../assets/js/script.js';

// Fetch attempts
$stmt = $pdo->prepare("SELECT qa.*, qt.topic_name FROM quiz_attempts qa JOIN quiz_topics qt ON qa.topic_id = qt.id WHERE qa.user_id = ? ORDER BY attempt_date DESC");
$stmt->execute([$_SESSION['user_id']]);
$attempts = $stmt->fetchAll();

$totalAttempts = count($attempts);
$totalScore = 0;
foreach ($attempts as $a) $totalScore += $a['score'];
$avgScore = $totalAttempts ? round($totalScore / $totalAttempts, 2) : 0;
?>
<?php include '../includes/header.php'; ?>
<main>
    <div class="container">
        <h2 style="margin:2rem 0 1rem;text-align:center;">Your Profile</h2>
        <div class="profile-stats">
            <div class="stat-card">
                <div class="stat-number"><?php echo htmlspecialchars($_SESSION['username']); ?></div>
                <div class="stat-label">Username</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $totalAttempts; ?></div>
                <div class="stat-label">Total Attempts</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $avgScore; ?></div>
                <div class="stat-label">Avg. Score</div>
            </div>
        </div>
        <h3 style="margin-top:3rem;">Recent Quiz Attempts</h3>
        <table class="attempts-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Topic</th>
                    <th>Score</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!$attempts): ?>
                <tr><td colspan="3">No attempts yet.</td></tr>
            <?php else: ?>
                <?php foreach ($attempts as $attempt): ?>
                <tr>
                    <td><?php echo htmlspecialchars(date("d M Y, H:i", strtotime($attempt['attempt_date']))); ?></td>
                    <td><?php echo htmlspecialchars($attempt['topic_name']); ?></td>
                    <td><?php echo $attempt['score'] . '/' . $attempt['total_questions']; ?></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
        <a href="change-password.php" class="btn-secondary">Change Password</a>
    </div>
</main>
<?php include '../includes/footer.php'; ?>
