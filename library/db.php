<?php
$pdo = new PDO('mysql:host=localhost;dbname=library', 'root', '');
// إعدادات PDO لأخطاء
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
session_start();
?>

