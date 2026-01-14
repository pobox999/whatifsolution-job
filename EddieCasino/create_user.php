<?php
/**
 * Helper script to create a test user in the database
 * Usage: php create_user.php [username] [email] [password]
 */

require_once __DIR__ . '/db.php';

// Get command line arguments or use defaults
$username = $argv[1] ?? 'admin';
$email = $argv[2] ?? 'admin@example.com';
$password = $argv[3] ?? 'admin123';

// Hash the password
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

try {
    $pdo = db();
    
    // Insert user
    $stmt = $pdo->prepare("
        INSERT INTO users (username, email, password_hash)
        VALUES (:username, :email, :password_hash)
    ");
    
    $stmt->execute([
        'username' => $username,
        'email' => $email,
        'password_hash' => $passwordHash
    ]);
    
    echo "✅ User created successfully!\n";
    echo "Username: $username\n";
    echo "Email: $email\n";
    echo "Password: $password\n";
    echo "\nYou can now login with these credentials.\n";
    
} catch (PDOException $e) {
    if ($e->getCode() == 23000) {
        // Duplicate entry
        echo "❌ Error: User '$username' or email '$email' already exists.\n";
    } else {
        echo "❌ Database error: " . $e->getMessage() . "\n";
    }
    exit(1);
}
