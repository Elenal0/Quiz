<!-- filename: admin/login.php -->
<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitizeInput($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND is_admin = 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['is_admin'] = 1;
        header("Location: dashboard.php");
        exit();
    } else {
        $errors[] = 'Invalid admin credentials.';
    }
}
$pageTitle = 'Admin Login - QuizMaster';
$cssPath = '../assets/css/styles.css';
?>
<?php include '../includes/header.php'; ?>
<main>
    <div class="container">
        <div class="form-container">
        <h2>Admin Login</h2>
        <?php if ($errors): ?>
            <div class="alert alert-error">
                <?php foreach ($errors as $e) echo '<p>'.htmlspecialchars($e).'</p>'; ?>
            </div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button class="btn-primary" type="submit" style="width:100%;">Login</button>
        </form>
        </div>
    </div>
</main>
<?php include '../includes/footer.php'; ?>
