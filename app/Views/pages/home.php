<?php require dirname(__DIR__) . '/layouts/header.php'; ?>


<h1>Home Page</h1>

<?php foreach ($pages as $page): ?>

    <article>

        <h2>
            <?= htmlspecialchars($page['title']); ?>
        </h2>

        <p>
            <?= htmlspecialchars($page['content']); ?>
        </p>

        <a href="?page=<?= htmlspecialchars($page['slug']); ?>">
            Read more
        </a>

    </article>

<?php endforeach; ?>


<?php require dirname(__DIR__) . '/layouts/footer.php'; ?>