<!DOCTYPE html>

<html>

<head>
    <title>Home</title>
</head>

<body>

<h1>Pages</h1>

<ul>

<?php foreach ($pages as $page): ?>

<li>
    <a href="?page=<?= htmlspecialchars($page['slug']) ?>">
        <?= htmlspecialchars($page['title']) ?>
    </a>
</li>

<?php endforeach; ?>

</ul>

</body>

</html>