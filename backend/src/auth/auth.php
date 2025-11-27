<?php
session_start();

use Firebase\JWT\JWT;
use Dotenv\Dotenv;

require_once __DIR__ . '/../../database/connection.php';
require_once __DIR__ . '/../../vendor/autoload.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

function jwtAuth($pdo, $email, $password)
{
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

    if (empty($email) || empty($password)) {
        http_response_code(400);
        echo json_encode(['Success' => false, 'message' => 'Email and password are required']);
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM jwt_user WHERE jwt_email = :email");
    $stmt->execute(['email' => $email]);
    $userFound = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$userFound) {
        http_response_code(401);
        echo json_encode(["Success" => false, 'message' => "User not found"]);
        exit;
    }

    if (!password_verify($password, $userFound['jwt_password'])) {
        http_response_code(401);
        echo json_encode(["Success" => false, "message" => "Incorret password"]);
        exit;
    }

    $key = $_ENV['JWT_SECRET_KEY'];
    $payload = [
        "exp" => time() + 3600,
        "iat" => time(),
        "email" => $email
    ];

    $jwt = JWT::encode($payload, $key, 'HS256');
    $_SESSION['jwtToken'] = $jwt;
    return [
        'Success' => true,
        'jwtToken' => $jwt
        // 'redirect' => '../dashboard.php'
    ];
}
