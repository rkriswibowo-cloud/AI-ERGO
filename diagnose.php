<?php
// Diagnostic script for login issues
require_once __DIR__ . '/core/App.php';
$app = new Core\App();

echo "=== AI-ERGO LOGIN DIAGNOSTIC ===\n\n";

// 1. Test DB connection
try {
    $db = Core\Database::getInstance();
    echo "[OK] Database connection successful\n";
} catch (Exception $e) {
    echo "[FAIL] Database connection: " . $e->getMessage() . "\n";
    exit;
}

// 2. Check if users table has data
$stmt = $db->query("SELECT COUNT(*) as cnt FROM users");
$count = $stmt->fetch(PDO::FETCH_ASSOC)['cnt'];
echo "[INFO] Users in database: {$count}\n";

if ($count == 0) {
    echo "[FAIL] No users found! The seed data was not imported.\n";
    echo "[FIX] Importing database.sql now...\n";
    $sqlFile = __DIR__ . '/database.sql';
    if (file_exists($sqlFile)) {
        $sql = file_get_contents($sqlFile);
        // Split by semicolons and execute each statement
        $statements = array_filter(array_map('trim', explode(';', $sql)));
        $executed = 0;
        foreach ($statements as $statement) {
            if (!empty($statement) && stripos($statement, 'CREATE DATABASE') === false && stripos($statement, 'USE ') === false) {
                try {
                    $db->exec($statement);
                    $executed++;
                } catch (PDOException $e) {
                    // Skip errors for existing tables/data
                }
            }
        }
        echo "[OK] Executed {$executed} SQL statements\n";
    }
    // Re-check
    $stmt = $db->query("SELECT COUNT(*) as cnt FROM users");
    $count = $stmt->fetch(PDO::FETCH_ASSOC)['cnt'];
    echo "[INFO] Users after import: {$count}\n";
}

// 3. List all users
echo "\n--- Users Table ---\n";
$stmt = $db->query("SELECT id, company_id, name, email, status, LEFT(password, 30) as pwd_preview FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($users as $u) {
    echo "  ID:{$u['id']} | {$u['email']} | status:{$u['status']} | pwd:{$u['pwd_preview']}...\n";
}

// 4. Test password verification
echo "\n--- Password Verification Test ---\n";
$stmt = $db->prepare("SELECT password FROM users WHERE email = :email");
$stmt->execute(['email' => 'admin@aiergo.com']);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row) {
    $hash = $row['password'];
    echo "  Stored hash: {$hash}\n";
    $result = password_verify('password123', $hash);
    echo "  password_verify('password123'): " . ($result ? 'TRUE (OK)' : 'FALSE (FAIL)') . "\n";
    
    if (!$result) {
        echo "  [FIX] Generating correct bcrypt hash and updating...\n";
        $newHash = password_hash('password123', PASSWORD_BCRYPT);
        echo "  New hash: {$newHash}\n";
        $upd = $db->prepare("UPDATE users SET password = :pwd WHERE email = :email");
        $upd->execute(['pwd' => $newHash, 'email' => 'admin@aiergo.com']);
        echo "  [OK] Password updated for admin@aiergo.com\n";
        
        // Update all demo users
        $upd = $db->prepare("UPDATE users SET password = :pwd");
        $upd->execute(['pwd' => $newHash]);
        echo "  [OK] All user passwords updated to password123\n";
    }
} else {
    echo "  [FAIL] admin@aiergo.com not found!\n";
}

// 5. Check user_roles
echo "\n--- User Roles ---\n";
$stmt = $db->query("SELECT ur.user_id, u.email, r.name as role_name FROM user_roles ur JOIN users u ON ur.user_id = u.id JOIN roles r ON ur.role_id = r.id");
$roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($roles as $r) {
    echo "  User {$r['user_id']} ({$r['email']}): {$r['role_name']}\n";
}
if (empty($roles)) {
    echo "  [FAIL] No user_roles found! Roles not assigned.\n";
}

// 6. Test the full login flow
echo "\n--- Full Login Flow Simulation ---\n";
$userModel = new App\Models\User();
$user = $userModel->findByEmail('admin@aiergo.com');
if ($user) {
    echo "  [OK] findByEmail returned user ID: {$user['id']}\n";
    echo "  [OK] User status: {$user['status']}\n";
    $pwdOk = password_verify('password123', $user['password']);
    echo "  [" . ($pwdOk ? 'OK' : 'FAIL') . "] Password verification: " . ($pwdOk ? 'PASS' : 'FAIL') . "\n";
    if ($pwdOk) {
        $userRoles = $userModel->getUserRoles($user['id']);
        echo "  [OK] User roles: " . implode(', ', $userRoles) . "\n";
    }
} else {
    echo "  [FAIL] findByEmail('admin@aiergo.com') returned null\n";
}

echo "\n=== DIAGNOSTIC COMPLETE ===\n";
