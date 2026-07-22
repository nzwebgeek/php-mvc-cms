<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$postId = 0;

if (isset($_GET['id'])) {
    $postId = (int) $_GET['id'];
}

if (isset($_POST['post_id'])) {
    $postId = (int) $_POST['post_id'];
}

if ($postId === 0) {
    die("No post selected.");
}


require_once 'includes/db.php';

$message = "";

/* ---------------- UPDATE ---------------- */
if (isset($_POST['update'])) {

    $id = (int)$_POST['edit_id'];
    $comment = trim($_POST['comment']);
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("UPDATE comments SET comment = ? WHERE id = ?  AND user_id = ?");
    $stmt->bind_param("sii", $comment, $id, $user_id);

    if ($stmt->execute()) {
        $message = "Comment updated.";
    } else {
        $message = "Error updating comment.";
    }

    $stmt->close();
}

/* ---------------- DELETE ---------------- */
if (isset($_POST['delete_id'])) {

    $id = (int)$_POST['delete_id'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("DELETE FROM comments WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $id, $user_id);

    if ($stmt->execute()) {
        $message = "Comment deleted.";
    } else {
        $message = "Error deleting comment.";
    }

    $stmt->close();
}


/* ---------------- CREATE ---------------- */
if (isset($_POST['comments'])) {

    $user_id = $_SESSION['user_id'];
    $post_id = (int)$_POST['post_id'];
    $comment = trim($_POST['comments']);
    $created_at = date('Y-m-d H:i:s');

    if (!empty($comment)) {

        $stmt = $conn->prepare("
            INSERT INTO comments 
            (post_id, user_id, comment, created_at)
            VALUES (?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "iiss",
            $post_id,
            $user_id,
            $comment,
            $created_at
        );

        if ($stmt->execute()) {
            $message = "Comment posted successfully!";
        } else {
            $message = "Error posting comment.";
        }

        $stmt->close();

    } else {
        $message = "Please enter a comment.";
    }
}
/* ---------------- EDIT STATE ---------------- */
$editing = isset($_POST['edit']) ? (int)$_POST['edit'] : 0;

include 'includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio</title>

    <link rel="stylesheet" href="css/comments.css">
    <script src="js/script.js" defer></script>
</head>

<body>

<div class="comments-container">

    <h2>Discussion</h2>

    <?php if (!empty($message)) : ?>
        <p class="message"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <!-- ADD COMMENT -->
    <form class="comment-form" method="post">

    <div class="avatar-placeholder">ME</div>

    <div class="form-body">

        <textarea name="comments" placeholder="Join the discussion..." required></textarea>

        <input type="hidden" name="post_id" value="<?= $postId ?>">

        <button type="submit">Post Comment</button>

    </div>

</form>

    <!-- COMMENTS LIST -->
    <ul class="comments-list">

    <?php
    $stmt = $conn->prepare("
    SELECT comments.*, users.username
    FROM comments
    JOIN users ON comments.user_id = users.id
    WHERE comments.post_id = ?
    ORDER BY comments.id DESC
    ");

$stmt->bind_param("i", $postId);
$stmt->execute();

$result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
    ?>

        <li class="comment-item">

            <article class="comment-card">

                <div class="avatar-placeholder">U</div>

                <div class="comment-content">

                    <div class="comment-header">
                        <span class="author-name"> <?= htmlspecialchars($row['username']) ?></span>
                    </div>
  
                    <!-- EDIT MODE -->
                    <?php if ($editing == $row['id']) { ?>

                        <form method="post">
                            <input type="hidden" name="edit_id" value="<?= $row['id'] ?>">

                            <textarea name="comment"><?= htmlspecialchars($row['comment']) ?></textarea>

                            <button type="submit" name="update">Save</button>
                        </form>

                    <?php } else { ?>

                        <!-- VIEW MODE -->
                        <p class="comment-text">
                            <?= htmlspecialchars($row['comment']) ?>
                        </p>

                        <?php if ($row['user_id'] == $_SESSION['user_id']) { ?>

                            <form method="post" style="display:inline;">
                                <input type="hidden" name="post_id" value="<?= $postId ?>">
                                <button type="submit" name="edit" value="<?= $row['id'] ?>">Edit</button>
                            </form>

                            <form method="post" style="display:inline;">
                                <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                                <button type="submit">Delete</button>
                            </form>

                        <?php } ?>

                    <?php } ?>

                </div>

            </article>

        </li>

    <?php } ?>

    </ul>
        <button id="toggleBtn">Change Color</button>

</div>

</body>
</html>

<?php
include 'includes/footer.php';
$conn->close();
?>