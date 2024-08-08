<?php
require 'db.php';

// التحقق من تسجيل الدخول
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $author = $_POST['author'] ?? '';
    $description = $_POST['description'] ?? '';

    $uploadDir = 'books/';
    $filePath = '';

    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $fileName = basename($_FILES['file']['name']);
        $uploadFile = $uploadDir . $fileName;
        
        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
            $filePath = $uploadFile;
        } else {
            $error = 'فشل تحميل ملف الكتاب.';
        }
    } else {
        $error = 'ملف الكتاب غير موجود أو حدث خطأ أثناء تحميله.';
    }

    $coverPath = '';
    if (isset($_FILES['cover']) && $_FILES['cover']['error'] === UPLOAD_ERR_OK) {
        $coverName = basename($_FILES['cover']['name']);
        $uploadCover = $uploadDir . $coverName;
        
        if (move_uploaded_file($_FILES['cover']['tmp_name'], $uploadCover)) {
            $coverPath = $uploadCover;
        } else {
            $error = 'فشل تحميل غلاف الكتاب.';
        }
    }

    if ($filePath && $coverPath) {
        $stmt = $pdo->prepare('INSERT INTO books (title, author, description, file_path, cover_path) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$title, $author, $description, $filePath, $coverPath]);
        header('Location: index.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة كتاب</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>إضافة كتاب</h1>
        <a href="index.php">العودة إلى المكتبة</a>
    </header>
    <main>
        <?php if (isset($error)): ?>
            <p><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form action="add_book.php" method="post" enctype="multipart/form-data">
            <label for="title">عنوان الكتاب:</label>
            <input type="text" id="title" name="title" required>
            
            <label for="author">مؤلف الكتاب:</label>
            <input type="text" id="author" name="author" required>
            
            <label for="description">وصف الكتاب:</label>
            <textarea id="description" name="description" required></textarea>
            
            <label for="file">ملف الكتاب:</label>
            <input type="file" id="file" name="file" accept=".pdf" required>
            
            <label for="cover">غلاف الكتاب:</label>
            <input type="file" id="cover" name="cover" accept="image/*" required>
            
            <button type="submit">إضافة الكتاب</button>
        </form>
    </main>
</body>
</html>

