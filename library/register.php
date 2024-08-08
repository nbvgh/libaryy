<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $admin_code = $_POST['admin_code'] ?? '';

    // الرمز السري المطلوب (يجب أن يكون مخزنًا بأمان في مكان غير مرئي)
    $required_admin_code = '775343129';  // استبدل هذا برمزك الحقيقي

    if ($admin_code === $required_admin_code) {
        if (!empty($username) && !empty($email) && !empty($password)) {
            // تجزئة كلمة المرور
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // إدخال المستخدم الجديد إلى قاعدة البيانات
            $stmt = $pdo->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
            $stmt->execute([$username, $email, $hashed_password]);

            // إعادة التوجيه إلى صفحة تسجيل الدخول أو الرئيسية
            header('Location: login.php');
            exit;
        } else {
            $error = 'يجب ملء جميع الحقول.';
        }
    } else {
        $error = 'الرمز السري غير صحيح.';
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل مستخدم جديد</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>تسجيل مستخدم جديد</h1>
    </header>
    <main>
        <?php if (isset($error)): ?>
            <p><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form action="register.php" method="post">
            <label for="username">اسم المستخدم:</label>
            <input type="text" id="username" name="username" required>

            <label for="email">البريد الإلكتروني:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">كلمة المرور:</label>
            <input type="password" id="password" name="password" required>

            <label for="admin_code">الرمز السري:</label>
            <input type="password" id="admin_code" name="admin_code" required>

            <button type="submit">تسجيل</button>
        </form>
    </main>
</body>
</html>

