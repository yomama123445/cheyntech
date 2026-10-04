<?php
require_once __DIR__ . '/session.php';
if (empty($_SESSION['user_id']) || ($_SESSION['user_role'] ?? '') !== 'admin') {
    header('Location: ../login.php?error=unauthorized');
    exit;
}
$_SESSION['csrf_token'] = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$pageTitle       = $pageTitle       ?? 'Admin | Cheyn Gadgets';
$pageDescription = $pageDescription ?? 'Cheyn Gadgets Admin Panel';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
  <meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">
  <title><?= htmlspecialchars($pageTitle) ?></title>
  <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
  <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
  <link rel="icon" type="image/png" href="../assets/img/favicon-32.png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="<?= asset_url('../assets/css/style.css') ?>">
</head>
<body>
