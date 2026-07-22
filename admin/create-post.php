<?php


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$error = "";
$error = "";

// Load media library
$mediaResult = $conn->query("
    SELECT id, filename, original_name, alt_text
    FROM media
    ORDER BY original_name
");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    $featured_media_id = !empty($_POST['featured_media_id'])
    ? (int)$_POST['featured_media_id']
    : null;

    $slug = strtolower($title);
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
    $slug = trim($slug, '-');

    if ($title === "" || $content === "") {

        $error = "Please complete all fields.";

    } else {

       $stmt = $conn->prepare("
            INSERT INTO posts
            (user_id, title, slug, featured_media_id, content, created_at)
            VALUES (?, ?, ?, ?, ?, NOW())
        ");

      $stmt->bind_param(
            "issis",
            $_SESSION['user_id'],
            $title,
            $slug,
            $featured_media_id,
            $content
        );

                if ($stmt->execute()) {

            $newPostId = $stmt->insert_id;

            // Option 1 (Recommended)
            header("Location: index.php?page=posts&success=1");
            exit;

            /*
            // Option 2
            // Redirect straight to the public post
            header("Location: ../post.php?id=" . $newPostId);
            exit;
            */

        } else {

            $error = "Unable to create the post.";

        }

        $stmt->close();
    }
}
?>

<h1>Create New Post</h1>

<?php if ($error): ?>
    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="post">

    <p>
        <label>Title</label><br>
        <input
            type="text"
            name="title"
            style="width:100%;"
            required>
    </p>

<p>

    <label>Featured Image</label><br>

    <select
        name="featured_media_id"
        style="width:100%;">

        <option value="">
            -- No Image --
        </option>

        <?php while ($image = $mediaResult->fetch_assoc()): ?>

            <option value="<?= $image['id'] ?>">

                <?= htmlspecialchars($image['original_name']) ?>

            </option>

        <?php endwhile; ?>

    </select>

</p>    

    <p>
        <label>Content</label><br>
        <textarea
            name="content"
            rows="12"
            style="width:100%;"
            required></textarea>
    </p>

    <button type="submit" class="button">
        Publish Post
    </button>

    <a class="button" href="index.php?page=posts">
        Cancel
    </a>

</form>