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
<meta name="description"
      content="<?= htmlspecialchars($pageDescription, ENT_QUOTES, 'UTF-8') ?>">
<?php endif; ?>


<meta name="robots" content="index, follow">

<link rel="stylesheet" href="/assets/css/style.css">
<script src="/assets/js/script.js" defer></script>
<title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></title>

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
        <li><a href="/">Home</a></li> 
        <li><a href="/blog">Blog</a></li> 
        <li><a href="/dashboard">Dashboard</a></li> 
            
        <li>
            <form method="POST" action="/logout" class="logout-form">
                <input
                    type="hidden"
                    name="csrf_token"
                    value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>"
                >
                <button type="submit" class="logout-link">Logout</button>
            </form>
        </li>



        <?php else : ?>
        <li><a href="/">Home</a></li> 
        <li><a href="/blog">Blog</a></li> 
        <li><a href="/register">Register</a></li> 
        <li><a href="/contact">Contact</a></li> 
        <li><a href="/login">Login</a></li> 
        <?php endif;?>
    </ul>
    </nav>
</header>
    