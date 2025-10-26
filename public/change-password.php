<!-- filename: public/change-password.php -->
<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';
requireLogin();

$errors = [];
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old_password = $_POST['old_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
    if (!$user || !password_verify($old_password, $user['password'])) {
        $errors[] = 'Old password is incorrect.';
    } elseif (!validatePassword($new_password)) {
        $errors[] = 'New password must be at least 8 characters long and contain uppercase, lowercase, number, and special character.';
    } elseif ($new_password !== $confirm_password) {
        $errors[] = 'New passwords do not match.';
    } else {
        $stmt = $pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
        $stmt->execute([password_hash($new_password, PASSWORD_DEFAULT), $_SESSION['user_id']]);
        $success = 'Password changed successfully!';
    }
}
$pageTitle = 'Change Password';
$cssPath = '../assets/css/styles.css';
$jsPath = '../assets/js/script.js';
?>
<?php include '../includes/header.php'; ?>
<main>
    <div class="container">
        <div class="form-container">
            <h2 style="text-align:center;margin-bottom:2rem;">Change Password</h2>
            <?php if ($errors): ?>
                <div class="alert alert-error">
                    <?php foreach ($errors as $err) echo '<p>'.htmlspecialchars($err).'</p>'; ?>
                </div>
            <?php elseif ($success): ?>
                <div class="alert alert-success">
                    <p><?php echo htmlspecialchars($success); ?></p>
                </div>
            <?php endif; ?>
            <form method="post">
                <div class="form-group">
                    <label>Old Password</label>
                    <input type="password" name="old_password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>New Password</label>
                    <input type="password" name="new_password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Confirm New Password</label>
                    <input type="password" name="confirm_password" class="form-control" required>
                </div>
                <button type="submit" class="btn-primary" style="width:100%;">Change Password</button>
            </form>
        </div>
    </div>
</main>
<?php include '../includes/footer.php'; ?>
