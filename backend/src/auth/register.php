<?php
require_once __DIR__ . '/../../database/connection.php';
require_once __DIR__ . '/../../vendor/autoload.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");

$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if (empty($email) || empty($password)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Email and password are required']);
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM jwt_user WHERE jwt_email = :email");
$stmt->execute(['email' => $email]);
$userExists = $stmt->fetch(PDO::FETCH_ASSOC);

if ($userExists) {
    http_response_code(409);
    echo json_encode(['success' => false, 'message' => 'Email alredy register']);
    exit;
}

$passwordHash = password_hash($password, PASSWORD_DEFAULT);

try {
    $sql = "INSERT INTO jwt_user (jwt_email, jwt_password) VALUES (:email, :password)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'email' => $email,
        'password' => $passwordHash
    ]);
    echo json_encode([
        "success" => true,
        "message" => "success register user",
        "redirect" => "/frontend/index.html"
    ]);
    exit;
} catch (PDOException $error) {
    echo json_encode(["success" => false, "message" => "Failed register user: " . $error->getMessage()]);
}
