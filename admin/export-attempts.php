<!-- filename: admin/export-attempts.php -->
<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';
requireAdmin();

// Fetch all attempts with user details
$stmt = $pdo->query("
    SELECT 
        qa.id,
        u.username,
        u.email,
        qt.topic_name,
        qa.score,
        qa.total_questions,
        qa.attempt_date
    FROM quiz_attempts qa
    JOIN users u ON qa.user_id = u.id
    JOIN quiz_topics qt ON qa.topic_id = qt.id
    ORDER BY qa.attempt_date DESC
");
$attempts = $stmt->fetchAll();

// Set headers for CSV download
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="quiz_attempts_' . date('Y-m-d') . '.csv"');

// Open output stream
$output = fopen('php://output', 'w');

// Write CSV header
fputcsv($output, ['ID', 'Username', 'Email', 'Topic', 'Score', 'Total Questions', 'Percentage', 'Date']);

// Write data rows
foreach ($attempts as $attempt) {
    $percentage = round(($attempt['score'] / $attempt['total_questions']) * 100, 2);
    fputcsv($output, [
        $attempt['id'],
        $attempt['username'],
        $attempt['email'],
        $attempt['topic_name'],
        $attempt['score'],
        $attempt['total_questions'],
        $percentage . '%',
        date('Y-m-d H:i:s', strtotime($attempt['attempt_date']))
    ]);
}

fclose($output);
exit();
?>
