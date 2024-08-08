<?php
require 'db.php';

$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare('SELECT * FROM books WHERE id = ?');
$stmt->execute([$id]);
$book = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$book) {
    echo 'الكتاب غير موجود.';
    exit;
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفاصيل الكتاب</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>تفاصيل الكتاب</h1>
        <p><a href="index.php">العودة إلى المكتبة</a></p>
    </header>
    <main>
        <h2><?= htmlspecialchars($book['title']) ?></h2>
        <p><strong>المؤلف:</strong> <?= htmlspecialchars($book['author']) ?></p>
        <br>
        <br>
        <p><?= htmlspecialchars($book['description']) ?></p>
        <br>
        <br>
        <img src="<?= htmlspecialchars($book['cover_path']) ?>" alt="غلاف الكتاب" style="max-width: 200px;">
        <br>
        <br>
        <a href="<?= htmlspecialchars($book['file_path']) ?>" download>تحميل الكتاب</a>
    </main>
</body>
</html>

