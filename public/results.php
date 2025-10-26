<!-- filename: public/results.php -->
<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';
requireLogin();

$attempt = null;
$justSubmitted = false;

// Handle POST submission from quiz
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $topic = sanitizeInput($_POST['topic'] ?? '');
    $topic_id = intval($_POST['topic_id'] ?? 0);
    $score = intval($_POST['score'] ?? 0);
    $total = intval($_POST['total'] ?? 10);

    if (!$topic_id) {
        $_SESSION['error'] = "Invalid quiz submission.";
        header('Location: dashboard.php');
        exit();
    }

    try {
        // Store the attempt
        $stmt = $pdo->prepare("INSERT INTO quiz_attempts (user_id, topic_id, score, total_questions) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_SESSION['user_id'], $topic_id, $score, $total]);
        $attempt_id = $pdo->lastInsertId();

        // Fetch the attempt we just created
        $stmt = $pdo->prepare("SELECT qa.*, qt.topic_name FROM quiz_attempts qa JOIN quiz_topics qt ON qa.topic_id = qt.id WHERE qa.id = ?");
        $stmt->execute([$attempt_id]);
        $attempt = $stmt->fetch();
        $justSubmitted = true;

    } catch (PDOException $e) {
        $_SESSION['error'] = "Error saving quiz results. Please try again.";
        header('Location: dashboard.php');
        exit();
    }
}

// Handle GET request (viewing previous attempt)
if (!$attempt && isset($_GET['attempt_id'])) {
    $attempt_id = intval($_GET['attempt_id']);
    $stmt = $pdo->prepare("SELECT qa.*, qt.topic_name FROM quiz_attempts qa JOIN quiz_topics qt ON qa.topic_id = qt.id WHERE qa.id = ? AND qa.user_id = ?");
    $stmt->execute([$attempt_id, $_SESSION['user_id']]);
    $attempt = $stmt->fetch();
}

$pageTitle = 'Quiz Results - QuizMaster';
$cssPath = '../assets/css/styles.css';
$jsPath = '../assets/js/script.js';
?>
<?php include '../includes/header.php'; ?>

<main>
    <div class="container">
        <?php if (!$attempt): ?>
            <div class="results-container">
                <h3>Invalid quiz attempt.</h3>
                <p>We couldn't find your quiz results.</p>
                <a href="dashboard.php" class="btn-primary">Back to Dashboard</a>
            </div>
        <?php else: ?>
        <div class="results-container">
            <?php if ($justSubmitted): ?>
                <div class="alert alert-success" style="margin-bottom: 2rem;">
                    <p>✓ Quiz submitted successfully!</p>
                </div>
            <?php endif; ?>
            
            <h2>Quiz Results: <?php echo htmlspecialchars($attempt['topic_name']); ?></h2>
            <div class="score-display"><?php echo $attempt['score'] . '/' . $attempt['total_questions']; ?></div>
            <div class="grade-display <?php
                $percent = ($attempt['score'] / $attempt['total_questions'])*100;
                if ($percent >= 80) echo 'grade-a';
                elseif ($percent >= 60) echo 'grade-b';
                elseif ($percent >= 40) echo 'grade-c';
                else echo 'grade-f';
            ?>">
                Grade: <?php echo calculateGrade($attempt['score'], $attempt['total_questions']); ?>
            </div>
            <div class="speedometer-container"></div>
            <div style="margin-top: 2rem; text-align: center;">
                <a href="dashboard.php" class="btn-primary" style="margin-right: 1rem;">Back to Home</a>
                <a href="profile.php" class="btn-secondary">View All Attempts</a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</main>

<?php include '../includes/footer.php'; ?>
