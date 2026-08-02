
<main class="post-page">

<article class="post-card">


<h1 class="post-title">
<?= htmlspecialchars(
    $post['title'],
    ENT_QUOTES,
    'UTF-8'
) ?>
</h1>


<!-- Temporary featured image placeholder -->
<?php if (!empty($post['image_path'])): ?>

<img
    src="/<?= htmlspecialchars(
        $post['image_path'],
        ENT_QUOTES,
        'UTF-8'
    ) ?>"
    alt="<?= htmlspecialchars(
        $post['title'],
        ENT_QUOTES,
        'UTF-8'
    ) ?>"
    class="post-image"
>

<?php endif; ?>



<div class="post-meta">

By 
<strong>
<?= htmlspecialchars(
    $post['username'] ?? 'admin',
    ENT_QUOTES,
    'UTF-8'
) ?>
</strong>

</div>



<div class="post-content">

<?= nl2br(
    htmlspecialchars(
        $post['content'],
        ENT_QUOTES,
        'UTF-8'
    )
) ?>

</div>


</article>



<section class="comments-section">

<h2 class="comments-heading">
Comments
</h2>


<p>
Login to leave a comment.
</p>


</section>



<a href="/blog" class="back-link">
← Back to Blog
</a>



</main>