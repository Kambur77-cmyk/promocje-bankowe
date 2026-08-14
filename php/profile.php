<?php
// profile.php
header('Content-Type: application/json');
require_once __DIR__ . '/config.php';

if (empty($_SESSION['user_id'])) {
  http_response_code(401);
  echo json_encode(['error' => 'Unauthorized']);
  exit;
}

try {
  $stmt = $pdo->prepare('SELECT id, email, display_name FROM users WHERE id = ? LIMIT 1');
  $stmt->execute([$_SESSION['user_id']]);
  $user = $stmt->fetch();
  if (!$user) {
    http_response_code(404);
    echo json_encode(['error' => 'User not found']);
    exit;
  }
  echo json_encode(['user' => $user]);
} catch (Exception $e) {
  http_response_code(500);
  echo json_encode(['error' => 'Błąd serwera']);
}
