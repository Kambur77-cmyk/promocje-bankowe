<?php
// register.php
header('Content-Type: application/json');
require_once __DIR__ . '/config.php';

$input = json_decode(file_get_contents('php://input'), true) ?: $_POST;
$email = trim($input['email'] ?? '');
$password = $input['password'] ?? '';
$displayName = trim($input['displayName'] ?? ($email));

if (!$email || !$password) {
  http_response_code(400);
  echo json_encode(['error' => 'Email i hasło wymagane']);
  exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  http_response_code(400);
  echo json_encode(['error' => 'Nieprawidłowy email']);
  exit;
}

try {
  $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
  $stmt->execute([$email]);
  if ($stmt->fetch()) {
    http_response_code(400);
    echo json_encode(['error' => 'Użytkownik o takim emailu już istnieje']);
    exit;
  }

  $hash = password_hash($password, PASSWORD_DEFAULT);
  $ins = $pdo->prepare('INSERT INTO users (email, password_hash, display_name) VALUES (?, ?, ?)');
  $ins->execute([$email, $hash, $displayName]);
  $_SESSION['user_id'] = $pdo->lastInsertId();
  echo json_encode(['ok' => true, 'user' => ['email' => $email, 'displayName' => $displayName]]);
} catch (Exception $e) {
  http_response_code(500);
  echo json_encode(['error' => 'Błąd serwera']);
}
