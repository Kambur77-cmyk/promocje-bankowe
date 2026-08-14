<?php
// google_signin.php
header('Content-Type: application/json');
require_once __DIR__ . '/config.php';

$input = json_decode(file_get_contents('php://input'), true) ?: $_POST;
$id_token = $input['id_token'] ?? '';

if (!$id_token) {
  http_response_code(400);
  echo json_encode(['error' => 'id_token wymagany']);
  exit;
}

$verifyUrl = "https://oauth2.googleapis.com/tokeninfo?id_token=" . urlencode($id_token);
$resp = @file_get_contents($verifyUrl);
if ($resp === false) {
  http_response_code(400);
  echo json_encode(['error' => 'Nie można zweryfikować tokena']);
  exit;
}
$payload = json_decode($resp, true);
if (!isset($payload['aud']) || $payload['aud'] !== $googleClientId) {
  http_response_code(403);
  echo json_encode(['error' => 'Nieprawidłowy audience']);
  exit;
}

$email = $payload['email'] ?? null;
$googleId = $payload['sub'] ?? null;
$displayName = $payload['name'] ?? $email;

if (!$email || !$googleId) {
  http_response_code(400);
  echo json_encode(['error' => 'Brak danych w tokenie']);
  exit;
}

try {
  $stmt = $pdo->prepare('SELECT id, google_id FROM users WHERE google_id = ? OR email = ? LIMIT 1');
  $stmt->execute([$googleId, $email]);
  $user = $stmt->fetch();
  if ($user) {
    if (empty($user['google_id'])) {
      $upd = $pdo->prepare('UPDATE users SET google_id = ? WHERE id = ?');
      $upd->execute([$googleId, $user['id']]);
    }
    $_SESSION['user_id'] = $user['id'];
  } else {
    $ins = $pdo->prepare('INSERT INTO users (email, display_name, google_id) VALUES (?, ?, ?)');
    $ins->execute([$email, $displayName, $googleId]);
    $_SESSION['user_id'] = $pdo->lastInsertId();
  }
  echo json_encode(['ok' => true, 'user' => ['email' => $email, 'displayName' => $displayName]]);
} catch (Exception $e) {
  http_response_code(500);
  echo json_encode(['error' => 'Błąd serwera']);
}
