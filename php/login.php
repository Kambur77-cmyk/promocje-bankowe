<?php
// login.php
header('Content-Type: application/json');
require_once __DIR__ . '/config.php';

$input = json_decode(file_get_contents('php://input'), true) ?: $_POST;
$email = trim($input['email'] ?? '');
$password = $input['password'] ?? '';

if (!$email || !$password) {
  http_response_code(400);
  echo json_encode(['error' => 'Email i hasło wymagane']);
  exit;
}

try {
  $stmt = $pdo->prepare('SELECT id, password_hash, display_name FROM users WHERE email = ? LIMIT 1');
  $stmt->execute([$email]);
  $user = $stmt->fetch();
  if (!$user || !$user['password_hash'] || !password_verify($password, $user['password_hash'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Nieprawidłowy email lub hasło']);
    exit;
  }
  $_SESSION['user_id'] = $user['id'];
  echo json_encode(['ok' => true, 'user' => ['email' => $email, 'displayName' => $user['display_name']]]);
} catch (Exception $e) {
  http_response_code(500);
  echo json_encode(['error' => 'Błąd serwera']);
}
