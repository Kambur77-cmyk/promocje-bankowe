<?php
// config.php
// Uwaga: ten plik zawiera poświadczenia bazy zgodnie z prośbą. Nie publikuj w publicznych repo jeśli nie chcesz ujawnić danych.

$dbHost = 'localhost';
$dbName = 'zyskajnabank_app';
$dbUser = 'zyskajnabank_app';
$dbPass = '123698745Kamil#1997Mnikami';

// Wstaw swój Google Client ID jeśli chcesz użyć Google Sign-In
$googleClientId = 'YOUR_GOOGLE_CLIENT_ID.apps.googleusercontent.com';

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
