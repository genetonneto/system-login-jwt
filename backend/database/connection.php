<?php
$host = 'localhost';
$dbname = 'login_jwt';
$user = 'geneton';
$password = '34382201';

try {
    $pdo = new PDO("mysql:host=$host", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname`");

    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS jwt_user(
        jwt_id INT PRIMARY KEY AUTO_INCREMENT,
        jwt_email VARCHAR(255) NOT NULL UNIQUE,
        jwt_password VARCHAR(255) NOT NULL
        )
    ");
} catch (PDOException $error) {
    echo "Connection failed" . $error->getMessage();
}
