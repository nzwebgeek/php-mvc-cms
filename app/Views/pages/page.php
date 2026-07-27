<?php require dirname(__DIR__) . '/layouts/header.php'; ?>


<h1>
    <?= htmlspecialchars($page['title']); ?>
</h1>


<div>

<?= nl2br(
    htmlspecialchars($page['content'])
); ?>

</div>


<a href="?page=home">
    Back home
</a>


<?php require dirname(__DIR__) . '/layouts/footer.php'; ?>