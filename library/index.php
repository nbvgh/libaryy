<?php
require 'db.php';

$stmt = $pdo->query('SELECT * FROM books ORDER BY upload_date DESC');
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>المكتبة</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>المكتبة</h1>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="add_book.php">إضافة كتاب</a>
            <a href="logout.php">تسجيل الخروج</a>
        <?php else: ?>
            <a href="login.php">تسجيل الدخول</a>
        <?php endif; ?>
    </header>
    <main>
        <section>
            <?php if (count($books) > 0): ?>
                <ul>
                    <?php foreach ($books as $book): ?>
                        <li>
                            <a href="book_details.php?id=<?= $book['id'] ?>">
                                <img src="<?= htmlspecialchars($book['cover_path']) ?>" alt="غلاف الكتاب" style="max-width: 100px;">
                                <?= htmlspecialchars($book['title']) ?> - <?= htmlspecialchars($book['author']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>لا توجد كتب في المكتبة حالياً.</p>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>

