<?php
require 'includes/auth.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>
<?= htmlspecialchars(
    $currentPage['seo_title']
    ?? $settings['seo_title']
    ?? $settings['site_name']
    ?? 'Website'
) ?>
</title>

<meta
    name="description"
    content="<?= htmlspecialchars(
        $currentPage['seo_description']
        ?? $settings['seo_description']
        ?? ''
    ) ?>">

<meta name="description"
      content="A lightweight PHP CMS built from scratch with a custom admin dashboard.">

    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/app.js" defer></script>
</head>

<body>

<header class="topbar">

    <button class="menu-toggle" id="menuToggle">
        ☰
    </button>

   <div class="logo">
    <?= htmlspecialchars($settings['site_name'] ?? 'My CMS') ?>
    </div>

    <div class="user">
        Welcome,
        <strong><?= htmlspecialchars($_SESSION['username'] ?? 'Administrator'); ?></strong>
        <a href="logout.php">Logout</a>
    </div>

</header>

<div class="wrapper">

