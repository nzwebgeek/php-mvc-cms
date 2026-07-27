<?php include '../layouts/header.php'; ?>

<main class="blog-container">

<h1>Comments Section</h1>

<p>
Start a comment here. Feel free to leave a comment, but make sure to register first.
</p>

<div class="comment-content-box">

<?php foreach ($images as $image): ?>

    <img
        src="<?= htmlspecialchars($image['filepath']) ?>"
        alt="">

<?php endforeach; ?>

</div>

<div class="wrapper">

<?php foreach ($posts as $post): ?>

    <article>

        <h2><?= htmlspecialchars($post['title']) ?></h2>

        <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>

    </article>

<?php endforeach; ?>

</div>

</main>

<?php include '../layouts/footer.php'; ?>