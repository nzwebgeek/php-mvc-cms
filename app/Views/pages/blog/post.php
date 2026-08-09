<article class="blog-post">

    <h1>
        <?= htmlspecialchars($post['title'] ?? '') ?>
    </h1>

    <?php if (!empty($post['image_path'])): ?>
        <img
            src="<?= htmlspecialchars($post['image_path']) ?>"
            alt="<?= htmlspecialchars($post['title'] ?? '') ?>"
            class="post-image">
    <?php endif; ?>

    <?php if (!empty($post['created_at'])): ?>
        <p class="post-date">
            <?= htmlspecialchars($post['created_at']) ?>
        </p>
    <?php endif; ?>

    <div class="post-content">
        <?= nl2br(htmlspecialchars($post['content'] ?? '')) ?>
    </div>

</article>


<hr>


<section class="comments">

    <h2>Comments</h2>

    <?php if (isset($_GET['success']) && $_GET['success'] === 'comment'): ?>

        <p class="comment-success">
            Your comment has been submitted and is awaiting approval.
        </p>

    <?php endif; ?>


    <?php if (isset($_GET['error']) && $_GET['error'] === 'comment'): ?>

        <p class="comment-error">
            Please enter a valid comment.
        </p>

    <?php endif; ?>


    <?php if (!empty($comments)): ?>

        <?php foreach ($comments as $comment): ?>

            <article class="comment">

                <div class="comment-author">
                    <strong>
                        <?= htmlspecialchars($comment['username'] ?? 'User') ?>
                    </strong>
                </div>

                <div class="comment-date">
                    <?= htmlspecialchars($comment['created_at'] ?? '') ?>
                </div>

                <div class="comment-body">
                    <?= nl2br(htmlspecialchars($comment['comment'] ?? '')) ?>
                </div>

            </article>

        <?php endforeach; ?>

    <?php else: ?>

        <p>No comments yet.</p>

    <?php endif; ?>


    <?php if (isset($_SESSION['user_id'])): ?>

        <div class="comment-form">

            <h3>Leave a comment</h3>

            <form
                method="POST"
                action="/blog/comment/store"
            >

                <input
                    type="hidden"
                    name="post_id"
                    value="<?= (int) $post['id'] ?>"
                >

                <div>
                    <label for="comment">
                        Comment
                    </label>

                    <textarea
                        id="comment"
                        name="comment"
                        rows="5"
                        required
                    ></textarea>
                </div>

                <button type="submit">
                    Submit Comment
                </button>

            </form>

        </div>

    <?php else: ?>

        <p>
            Please
            <a href="/login">log in</a>
            to leave a comment.
        </p>

    <?php endif; ?>

</section>
```
