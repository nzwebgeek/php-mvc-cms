<?php
$page = $_GET['page'] ?? 'dashboard';
?>

<aside class="sidebar">
    <ul>
        <li><a href="../index.php">🏠 Main</a></li>
        <li><a href="index.php?page=dashboard">🏠 Dashboard</a></li>
        <li><a href="index.php?page=users">👤 Users</a></li>
        <li><a href="index.php?page=roles">🛡 Roles</a></li>
        <li><a href="index.php?page=pages">📄 Pages</a></li>
        <li><a href="index.php?page=create-page">📝Create Page</a></li>
        <li><a href="index.php?page=posts">📝 Posts</a></li>
        <li><a href="index.php?page=comments">Comments</a></li>
        <li><a href="index.php?page=media">🖼 Media</a></li>
        <li><a href="index.php?page=settings">⚙ Settings</a></li>
    <li><a href="index.php?page=upload-blog-image
    ">🖼 Upload Blog Image</a></li>
    </ul>
</aside>