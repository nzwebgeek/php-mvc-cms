<!DOCTYPE html>

<html>

<head>
    <title><?= htmlspecialchars($page['title']) ?></title>
</head>

<body>

<h1><?= htmlspecialchars($page['title']) ?></h1>

<p><?= nl2br(htmlspecialchars($page['content'])) ?></p>

<p><a href="?page=home">Back</a></p>

</body>

</html>