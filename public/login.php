
// filename: public/login.php
<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';

// Redirect if already logged in
if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit();
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitizeInput($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email)) {
        $errors[] = 'Email is required.';
    }

    if (empty($password)) {
        $errors[] = 'Password is required.';
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id, username, email, password, is_admin FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['is_admin'] = $user['is_admin'];

            // Redirect based on user type
            if ($user['is_admin']) {
                header('Location: ../admin/dashboard.php');
            } else {
                header('Location: dashboard.php');
            }
            exit();
        } else {
            $errors[] = 'Invalid email or password.';
        }
    }
}

$pageTitle = 'Login - QuizMaster';
$cssPath = '../assets/css/styles.css';
$jsPath = '../assets/js/script.js';
?>

<?php include '../includes/header.php'; ?>

<main>
    <div class="container">
        <div class="form-container">
            <h2 style="text-align: center; margin-bottom: 2rem; color: var(--text-primary);">Login to Your Account</h2>
            
            <?php if (!empty($errors)): ?>
                <div class="alert alert-error">
                    <?php foreach ($errors as $error): ?>
                        <p><?php echo htmlspecialchars($error); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" class="form-control" 
                           value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <button type="submit" class="btn-primary" style="width: 100%; margin-bottom: 1rem;">Login</button>
                
                <p style="text-align: center; color: var(--text-secondary);">
                    Don't have an account? <a href="register.php" style="color: var(--primary-color);">Register here</a>
                </p>
            </form>

            <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid var(--border-color);">
                <h3 style="text-align: center; margin-bottom: 1rem; color: var(--text-primary);">Demo Credentials</h3>
                <div style="background: var(--background-color); padding: 1rem; border-radius: var(--border-radius); font-size: 0.9rem;">
                    <p><strong>Admin Account:</strong></p>
                    <p>Email: admin@example.com</p>
                    <p>Password: Admin@123</p>
                    <br>
                    <p><strong>Test User Account:</strong></p>
                    <p>Email: user@example.com</p>
                    <p>Password: User@123</p>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include '../includes/footer.php'; ?>
