<?php

require 'includes/db.php';
require 'includes/settings.php';

include 'includes/header.php';
include 'helpers/helper.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid post ID.");
}

$postId = (int) $_GET['id'];

$sql = "SELECT posts.*, users.username
        FROM posts
        JOIN users
        ON posts.user_id = users.id
        WHERE posts.id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i",$postId);

$stmt->execute();

$result = $stmt->get_result();

$post = $result->fetch_assoc();

?>

<div class="post-page">

    <article class="post-card">

        <h1 class="post-title">
            <?= htmlspecialchars($post['title']) ?>
        </h1>

        <div class="post-meta">
            By <strong><?= htmlspecialchars($post['username']) ?></strong>
        </div>

        <div class="post-content">
            <?= nl2br(htmlspecialchars($post['content'])) ?>
        </div>

    </article>

    <section class="comments-section">

        <h2 class="comments-heading">
            Comments
        </h2>

        <?php comments($conn, $postId); ?>

    </section>

</div>
<?php include 'includes/footer.php'; ?>