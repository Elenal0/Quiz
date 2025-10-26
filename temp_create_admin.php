<!-- filename: temp_create_admin.php -->
<?php
// Place this in your quiz-app root directory temporarily
require_once 'config/database.php';

$password = 'Admin@123';
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

echo "Generated hash for 'Admin@123': " . $hashedPassword . "<br>";

// Insert or update admin user
try {
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password, is_admin) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE password = ?, is_admin = ?");
    $stmt->execute(['admin', 'admin@example.com', $hashedPassword, 1, $hashedPassword, 1]);
    echo "Admin user created/updated successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
