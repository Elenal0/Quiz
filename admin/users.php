<!-- filename: admin/users.php -->
<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';
requireAdmin();

// Fetch all quiz attempts with user and topic information
$stmt = $pdo->query("
    SELECT 
        qa.id,
        qa.score,
        qa.total_questions,
        qa.attempt_date,
        u.username,
        u.email,
        qt.topic_name
    FROM quiz_attempts qa
    JOIN users u ON qa.user_id = u.id
    JOIN quiz_topics qt ON qa.topic_id = qt.id
    ORDER BY qa.attempt_date DESC
");
$attempts = $stmt->fetchAll();

// Calculate statistics
$totalAttempts = count($attempts);
$totalUsers = $pdo->query("SELECT COUNT(DISTINCT user_id) as count FROM quiz_attempts")->fetchColumn();

$pageTitle = 'User Attempts - Admin';
$cssPath = '../assets/css/styles.css';
$jsPath = '../assets/js/script.js';
?>
<?php include '../includes/header.php'; ?>

<main>
    <div class="container">
        <h2 style="margin: 2rem 0 1rem;">User Quiz Attempts</h2>
        
        <div class="profile-stats" style="margin-bottom: 2rem;">
            <div class="stat-card">
                <div class="stat-number"><?php echo $totalAttempts; ?></div>
                <div class="stat-label">Total Attempts</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $totalUsers; ?></div>
                <div class="stat-label">Active Users</div>
            </div>
        </div>

        <div style="margin-bottom: 1rem;">
            <a href="export-attempts.php" class="btn-primary">Export as CSV</a>
            <a href="dashboard.php" class="btn-secondary">Back to Dashboard</a>
        </div>

        <?php if (empty($attempts)): ?>
            <div class="alert alert-info">
                <p>No quiz attempts found yet.</p>
            </div>
        <?php else: ?>
            <table class="attempts-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Topic</th>
                        <th>Score</th>
                        <th>Percentage</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($attempts as $attempt): ?>
                        <?php 
                            $percentage = ($attempt['score'] / $attempt['total_questions']) * 100;
                            $gradeClass = $percentage >= 80 ? 'grade-a' : ($percentage >= 60 ? 'grade-b' : ($percentage >= 40 ? 'grade-c' : 'grade-f'));
                        ?>
                        <tr>
                            <td><?php echo $attempt['id']; ?></td>
                            <td><?php echo htmlspecialchars($attempt['username']); ?></td>
                            <td><?php echo htmlspecialchars($attempt['email']); ?></td>
                            <td><?php echo htmlspecialchars($attempt['topic_name']); ?></td>
                            <td><?php echo $attempt['score'] . '/' . $attempt['total_questions']; ?></td>
                            <td>
                                <span class="<?php echo $gradeClass; ?>" style="padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-weight: 600;">
                                    <?php echo round($percentage, 1); ?>%
                                </span>
                            </td>
                            <td><?php echo date('d M Y, H:i', strtotime($attempt['attempt_date'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</main>

<?php include '../includes/footer.php'; ?>
