<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<?php
$pageTitle = $page['seo_title']
    ?? $settings['seo_title']
    ?? $settings['site_name']
    ?? 'Website';

$pageDescription = $page['seo_description']
    ?? $settings['seo_description']
    ?? '';
?>

<title>
<?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?>
</title>

<?php if (!empty($pageDescription)): ?>

<meta 
    name="description" 
    content="<?= htmlspecialchars($pageDescription, ENT_QUOTES, 'UTF-8') ?>"
>

<?php endif; ?>

<title><?= htmlspecialchars($pageTitle) ?></title>

<?php if (!empty($pageDescription)): ?>
<meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">
<?php endif; ?>

<meta name="robots" content="index, follow">

<link rel="stylesheet" href="css/style.css">
<script src="js/script.js" defer></script>

</head>
<body>
 

<div class="container" id="container">

<header>
    <nav>
        <ul>
           <li>
            Welcome <?= htmlspecialchars($_SESSION['username'] ?? 'Guest'); ?>
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
    