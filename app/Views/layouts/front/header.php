<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">


<title>
<?= htmlspecialchars(
    $seoTitle ?? $settings['site_name'] ?? 'Website'
); ?>
</title>


<link rel="stylesheet" href="/css/style.css">

<script src="/js/script.js" defer></script>

</head>


<body class="theme-<?= htmlspecialchars(
    $settings['theme'] ?? 'light'
); ?>">


<div class="container">


<header>

<h1>
<?= htmlspecialchars(
    $settings['site_name'] ?? 'My Website'
); ?>
</h1>


<nav>

<ul>

<li>
Welcome
<?= htmlspecialchars(
    $_SESSION['username'] ?? 'Guest'
); ?>
</li>


<li>
<a href="?page=home">
Home
</a>
</li>


<li>
<a href="?page=blog">
Blog
</a>
</li>


<?php if(isset($_SESSION['user_id'])): ?>

<li>
<a href="?page=dashboard">
Dashboard
</a>
</li>

<li>
<a href="?page=logout">
Logout
</a>
</li>


<?php else: ?>

<li>
<a href="?page=register">
Register
</a>
</li>


<li>
<a href="?page=login">
Login
</a>
</li>

<?php endif; ?>


</ul>

</nav>

</header>