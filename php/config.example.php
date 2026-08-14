<?php
// config.example.php
// Skopiuj -> config.php i uzupełnij wartości (nie dodawaj config.php do repo).
// Alternatywnie możesz korzystać z env vars zamiast trzymania tu haseł.

$dbHost = getenv('DB_HOST') ?: 'localhost';
$dbName = getenv('DB_NAME') ?: 'zyskajnabank_app';
$dbUser = getenv('DB_USER') ?: 'zyskajnabank_app';
$dbPass = getenv('DB_PASS') ?: '123698745Kamil#1997Mnikami';

// Wprowadź swój Google Web Client ID (z Google Cloud Console)
$googleClientId = getenv('GOOGLE_CLIENT_ID') ?: 'YOUR_GOOGLE_CLIENT_ID.apps.googleusercontent.com';

$options = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
];

try {
  $pdo = new PDO("mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4", $dbUser, $dbPass, $options);
} catch (Exception $e) {
  http_response_code(500);
  header('Content-Type: application/json');
  echo json_encode(['error' => 'DB connection error']);
  exit;
}

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
