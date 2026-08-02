<main class="blog-container">

<h1>Comments Section</h1>

<p>
    <strong>Start a comment here:</strong>
    Feel free to leave a comment, but make sure to register first.
</p>

<!-- TOP TWO FEATURED IMAGES -->
<section class="comment-content-box">

    <div class="comment-content-img">

        <img
            src="/uploads/laravel.png"
            alt="Laravel blog image">

    </div>


    <div class="comment-content-img">

        <img
            src="/uploads/php.jpg"
            alt="PHP blog image">

    </div>

</section>


<!-- BLOG POSTS -->
<section class="wrapper">


<?php foreach ($posts as $post): ?>

<article class="blog-card">


<h2>
<?= htmlspecialchars(
    $post['title'],
    ENT_QUOTES,
    'UTF-8'
) ?>
</h2>


<p>
By admin
</p>


<p>
<?= htmlspecialchars(
    substr($post['content'], 0, 120),
    ENT_QUOTES,
    'UTF-8'
) ?>
...
</p>


<a href="/blog/post?id=<?= (int)$post['id'] ?>">
Read More
</a>


</article>


<?php endforeach; ?>


</section>


</main>