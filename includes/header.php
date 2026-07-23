<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Temporarily disabled during development
/*
if (!empty($settings['maintenance_mode']) && !isset($_SESSION['user_id'])) {
    die("
        <h1>Website Under Maintenance</h1>
        <p>Please check back later.</p>
    ");
}
*/
?>



<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<?php
$pageTitle = $page['seo_title']
    ?? ($settings['seo_title'] ?? null)
    ?? ($settings['site_name'] ?? null)
    ?? 'Website';

$pageDescription = $page['seo_description']
    ?? ($settings['seo_description'] ?? '');
?>

<?php if (!empty($pageDescription)): ?>

<?php endif; ?>


<meta name="robots" content="index, follow">

<link rel="stylesheet" href="css/style.css">
<script src="js/script.js" defer></script>

</head>
 <?php
$theme = strtolower($settings['theme'] ?? 'light');
?>
<body class="theme-<?= htmlspecialchars($theme, ENT_QUOTES, 'UTF-8') ?>">


<div class="container" id="container">

<header>
    <h1>
        <?= htmlspecialchars($settings['site_name'] ?? 'My Website', ENT_QUOTES, 'UTF-8'); ?>
    </h1>
   
    <nav>
        <ul id="welcome">
           <li>
    Welcome <?= htmlspecialchars($_SESSION['username'] ?? 'Guest', ENT_QUOTES, 'UTF-8'); ?>           
        </li>
        </ul>
      <ul>
        <?php if (isset($_SESSION['user_id'])): ?>        
        <li><a href="index.php">Home</a></li> 
        <li><a href="blog.php">Blog</a></li> 
        <li><a href="dashboard.php">Dashboard</a></li> 
        <li><a href="logout.php">Logout</a> </li>
        <?php else : ?>
        <li><a href="index.php">Home</a></li> 
        <li><a href="blog.php">Blog</a></li> 
        <li><a href="register.php">Register</a></li> 
        <li><a href="contact.php">Contact</a></li> 
        <li><a href="login.php">Login</a></li> 
        <?php endif;?>
    </ul>
    </nav>
</header>
    