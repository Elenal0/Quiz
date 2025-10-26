

<?php
function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validatePassword($password) {
    // At least 8 characters, 1 uppercase, 1 lowercase, 1 number, 1 special character
    return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password);
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit();
    }
}

function requireAdmin() {
    if (!isAdmin()) {
        header('Location: ../public/index.php');
        exit();
    }
}

function getTopicIdByName($pdo, $topicName) {
    $stmt = $pdo->prepare("SELECT id FROM quiz_topics WHERE topic_name = ?");
    $stmt->execute([$topicName]);
    $result = $stmt->fetch();
    return $result ? $result['id'] : false;
}
function getRandomQuestions($pdo, $topicId, $limit = 10) {
    $limit = (int)$limit; // make sure it’s a number
    $stmt = $pdo->prepare("SELECT * FROM questions WHERE topic_id = ? ORDER BY RAND() LIMIT $limit");
    $stmt->execute([$topicId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



function calculateGrade($score, $total) {
    $percentage = ($score / $total) * 100;
    if ($percentage >= 90) return 'A+';
    if ($percentage >= 80) return 'A';
    if ($percentage >= 70) return 'B+';
    if ($percentage >= 60) return 'B';
    if ($percentage >= 50) return 'C';
    return 'F';
}
?>
