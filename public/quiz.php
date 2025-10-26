<!-- filename: public/quiz.php -->
<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';
requireLogin();

$topic = isset($_GET['topic']) ? sanitizeInput($_GET['topic']) : '';
$topic_id = getTopicIdByName($pdo, $topic);

if (!$topic_id) {
    header('Location: dashboard.php');
    exit();
}

$questions = getRandomQuestions($pdo, $topic_id, 10);

// If there are no questions for this topic
if (empty($questions)) {
    $_SESSION['error'] = "No questions available for this topic yet.";
    header('Location: dashboard.php');
    exit();
}

$pageTitle = "$topic Quiz - QuizMaster";
$cssPath = '../assets/css/styles.css';
$jsPath = '../assets/js/script.js';
?>
<?php include '../includes/header.php'; ?>

<main>
    <div class="container">
        <div class="quiz-container">
            <div class="quiz-header">
                <h2><?php echo htmlspecialchars($topic); ?> Quiz</h2>
                <div class="quiz-progress">
                    <div class="quiz-progress-bar" style="width:0%;"></div>
                </div>
            </div>
            <div class="question-container"></div>
            <div class="quiz-navigation" style="display:flex;">
                <button class="btn-secondary btn-prev">Previous</button>
                <button class="btn-secondary btn-next">Next</button>
                <button class="btn-primary btn-submit" style="display:none;">Submit Quiz</button>
            </div>
            
            <!-- Hidden form for quiz submission -->
            <form id="quiz-submit-form" method="POST" action="results.php" style="display:none;">
                <input type="hidden" name="topic" value="<?php echo htmlspecialchars($topic); ?>">
                <input type="hidden" name="topic_id" value="<?php echo $topic_id; ?>">
                <input type="hidden" name="answers" id="answers-input">
                <input type="hidden" name="score" id="score-input">
                <input type="hidden" name="total" id="total-input" value="<?php echo count($questions); ?>">
            </form>
            
            <!-- Quiz data for JS -->
            <script id="quiz-data" type="application/json">
                <?php
                    $qArray = [];
                    foreach ($questions as $q) {
                        $qArray[] = [
                            'id' => $q['id'],
                            'question_text' => $q['question_text'],
                            'option_a' => $q['option_a'],
                            'option_b' => $q['option_b'],
                            'option_c' => $q['option_c'],
                            'option_d' => $q['option_d'],
                            'correct_option' => $q['correct_option']
                        ];
                    }
                    echo json_encode($qArray);
                ?>
            </script>
        </div>
    </div>
</main>

<?php include '../includes/footer.php'; ?>
