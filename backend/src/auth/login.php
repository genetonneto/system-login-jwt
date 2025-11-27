<?php 
session_start();
require_once __DIR__ . '/auth.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// $data = json_decode(file_get_contents('php://input'), true);
// $email = $data['email'] ?? '';
// $password = $data['password'] ?? '';

// $result = jwtAuth($pdo, $email, $password);
// echo json_encode($result);

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

$result = jwtAuth($pdo, $email, $password);
// echo json_encode($result);
if ($result['Success']) {
    $result['redirect'] = 'http://localhost:8000/backend/src/auth/dashboard.php';
}

echo json_encode($result);