<!-- filename: admin/questions.php -->
<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';
requireAdmin();

$stmt = $pdo->query("SELECT q.*, t.topic_name FROM questions q JOIN quiz_topics t ON q.topic_id = t.id ORDER BY q.id DESC");
$questions = $stmt->fetchAll();

$pageTitle = 'Manage Questions - Admin';
$cssPath = '../assets/css/styles.css';
?>
<?php include '../includes/header.php'; ?>
<main>
<div class="container">
    <h2 style="margin:2rem 0 1rem;">Manage Questions</h2>
    <a href="add-question.php" class="btn-primary" style="margin-bottom:1.5rem;">Add New Question</a>
    <table class="attempts-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Topic</th>
                <th>Question</th>
                <th>Options</th>
                <th>Correct</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($questions as $q): ?>
            <tr>
                <td><?php echo $q['id']; ?></td>
                <td><?php echo htmlspecialchars($q['topic_name']); ?></td>
                <td><?php echo htmlspecialchars(substr($q['question_text'],0,70)); ?>...</td>
                <td>
                    A: <?php echo htmlspecialchars($q['option_a']); ?> <br>
                    B: <?php echo htmlspecialchars($q['option_b']); ?> <br>
                    C: <?php echo htmlspecialchars($q['option_c']); ?> <br>
                    D: <?php echo htmlspecialchars($q['option_d']); ?>
                </td>
                <td><?php echo strtoupper($q['correct_option']); ?></td>
                <td>
                    <a href="edit-question.php?id=<?php echo $q['id']; ?>" class="btn-secondary" style="font-size:0.95em;">Edit</a>
                    <a href="delete-question.php?id=<?php echo $q['id']; ?>" class="btn-secondary" style="font-size:0.95em;color:#ef4444;" onclick="return confirm('Delete this question?');">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</main>
<?php include '../includes/footer.php'; ?>
