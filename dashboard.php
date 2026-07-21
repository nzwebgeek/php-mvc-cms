<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

$message = "";

if (isset($_GET['saved'])) {
    $message = "Colours saved successfully.";
}

include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


/* ==========================================
   Save Theme Colours
========================================== */
if (isset($_POST['save_colors'])) {

    $theme = $_POST['theme_color'];
    $background = $_POST['background_color'];
    $text = $_POST['text_color'];

    $stmt = $conn->prepare("
        UPDATE users
        SET theme_color=?,
            background_color=?,
            text_color=?
        WHERE id=?
    ");

    $stmt->bind_param(
        "sssi",
        $theme,
        $background,
        $text,
        $_SESSION['user_id']
    );

    $stmt->execute();
    $stmt->close();

    header("Location: dashboard.php?saved=1");
    exit();
}
/* ==========================================
   Upload Image
========================================== */

if (isset($_POST['submit'])) {

    $uploadDir = "uploads/";

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // No file selected
    if (!isset($_FILES['image'])) {

        $message = "Please select an image.";

    // PHP upload error
    } elseif ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {

        switch ($_FILES['image']['error']) {

            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $message = "Image is too large.";
                break;

            default:
                $message = "Upload failed.";
        }

    } else {

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        $extension = strtolower(
            pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION)
        );

        // Check file extension
        if (!in_array($extension, $allowedExtensions)) {

            $message = "Only JPG, JPEG, PNG, GIF and WebP images are allowed.";

        // Check file size (20MB)
        } elseif ($_FILES['image']['size'] > (20 * 1024 * 1024)) {

            $message = "Image must be under 10MB.";

        } else {

            // Verify MIME type
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $_FILES['image']['tmp_name']);
            finfo_close($finfo);

            $allowedMime = [
                'image/jpeg',
                'image/png',
                'image/gif',
                'image/webp'
            ];

            if (!in_array($mime, $allowedMime)) {

                $message = "Invalid image type.";

            } else {

                // Generate unique filename
                $newFileName = uniqid('img_', true) . '.' . $extension;
                $filePath = $uploadDir . $newFileName;

                // Move uploaded file
                if (move_uploaded_file($_FILES['image']['tmp_name'], $filePath)) {

                    $stmt = $conn->prepare("
                        INSERT INTO images (filename, filepath)
                        VALUES (?, ?)
                    ");

                    $stmt->bind_param(
                        "ss",
                        $newFileName,
                        $filePath
                    );

                    if ($stmt->execute()) {

                        $imageId = $conn->insert_id;
                        $stmt->close();

                        $stmt = $conn->prepare("
                            UPDATE users
                            SET image_id = ?
                            WHERE id = ?
                        ");

                        $stmt->bind_param(
                            "ii",
                            $imageId,
                            $_SESSION['user_id']
                        );

                        if ($stmt->execute()) {

                            $message = "Image uploaded successfully.";

                        } else {

                            $message = "Failed to update user profile.";

                        }

                        $stmt->close();

                    } else {

                        $message = "Database error: " . $stmt->error;
                        $stmt->close();

                    }

                } else {

                    $message = "Failed to upload image.";

                }
            }
        }
    }
}
/* ==========================================
   Load User
========================================== */

$stmt = $conn->prepare("
    SELECT
        u.username,
        u.theme_color,
        u.background_color,
        u.text_color,
        i.filepath
    FROM users u
    LEFT JOIN images i
        ON u.image_id = i.id
    WHERE u.id = ?
");

$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();

$user = $stmt->get_result()->fetch_assoc();

$stmt->close();

include 'includes/my-header.php';
?>

<style>

:root{
    --theme: <?= htmlspecialchars($user['theme_color'] ?: '#007bff'); ?>;
    --background: <?= htmlspecialchars($user['background_color'] ?: '#ffffff'); ?>;
    --text: <?= htmlspecialchars($user['text_color'] ?: '#222'); ?>;

    --card:#ffffff;
    --shadow:0 10px 30px rgba(0,0,0,.08);
    --radius:18px;
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{

    font-family:Arial, Helvetica, sans-serif;
    background:linear-gradient(135deg,#eef2f7,#dfe8f7);

}

.main-body{

    max-width:1400px;
    margin:40px auto;
    background:transparent;

}

.header{

    background:linear-gradient(135deg,var(--theme),#3958ff);

    color:white;

    padding:35px;

    border-radius:20px;

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:25px;

    box-shadow:var(--shadow);

}

.header h1{

    font-size:36px;

}

.header h2{

    font-size:16px;

    margin-top:8px;

    font-weight:normal;

    opacity:.9;

}

.dashboard{

    display:grid;

    grid-template-columns:280px 1fr;

    gap:25px;

}

.sidebar{

    background:var(--card);

    border-radius:var(--radius);

    box-shadow:var(--shadow);

    overflow:hidden;

}

.profile-card{

    background:var(--theme);

    color:white;

    padding:30px;

    text-align:center;

}
.profile-image{
    width:180px;
    height:180px;
    border-radius:50%;
    object-fit:cover;
    border:6px solid var(--theme);
    display:block;
    margin:0 auto;
}
.profile-card img{

width:120px;

height:120px;

object-fit:cover;

border-radius:50%;

border:6px solid white;

box-shadow:0 10px 25px rgba(0,0,0,.25);

transition:.3s;

}

.profile-card .placeholder{

    width:140px;

    height:140px;

    border-radius:50%;

    background:white;

    color:#777;

    display:flex;

    justify-content:center;

    align-items:center;

    margin:auto auto 20px;

}

.profile-card h3{

    font-size:24px;

}

.profile-card p{

    margin-top:10px;

    opacity:.85;

}

.profile-card img:hover{

transform:scale(1.05);

}

.menu{

    padding:20px;

}

.menu a{

    display:block;

    padding:14px 18px;

    margin-bottom:10px;

    border-radius:10px;

    background:#f5f5f5;

    text-decoration:none;

    color:#333;

    transition:.25s;

    font-weight:bold;

}

.menu a:hover{

    background:var(--theme);

    color:white;

    transform:translateX(5px);

}

.content{

    background:var(--card);

    border-radius:var(--radius);

    padding:35px;

    box-shadow:var(--shadow);

    color:#333;

}

.content h3{

    margin-bottom:15px;

    font-size:30px;

}

.content h4{

    color:#777;

    margin-bottom:25px;

}

.content img{

max-width:100%;

height:auto;

}

.card{

    background:#fafafa;

    border:1px solid #ececec;

    border-radius:15px;

    padding:25px;

    margin-bottom:35px;

    position:relative;
    
    overflow:hidden;
}

.card::before{

content:"";

position:absolute;

left:0;
top:0;

width:5px;

height:100%;

background:var(--theme);

}

button,
input[type=submit]{

    background:var(--theme);

    color:white;

    border:none;

    padding:12px 24px;

    border-radius:10px;

    cursor:pointer;

    font-size:15px;

}

button,
input[type=submit]{

    transition:.25s;

}

button:hover,
input[type=submit]:hover{

    transform:translateY(-2px);

    box-shadow:0 8px 18px rgba(0,0,0,.15);

}

form p{

    margin-bottom:15px;

}

form{

    display:flex;
    flex-direction:column;
    gap:15px;
    animation:fadeIn .3s ease;
}

@keyframes fadeIn{

from{

opacity:0;
transform:translateY(15px);

}

to{

opacity:1;
transform:translateY(0);

}

}

input[type=color]{

    width:100%;
    height:60px;
    border:none;
    border-radius:12px;
    cursor:pointer;
    background:none;
    margin-bottom:20px;

}

input[type=file]{

    padding:15px;
    border:2px dashed #ddd;
    border-radius:12px;
    background:#fafafa;

}
.message{

    background:#d4edda;

    color:#155724;

    padding:15px;

    border-radius:10px;

    margin-top:25px;

}

.post-links a{

display:block;

padding:20px;

margin-bottom:15px;

border-radius:15px;

background:white;

border:1px solid #eee;

text-decoration:none;

color:#333;

transition:.25s;

box-shadow:0 4px 10px rgba(0,0,0,.05);

}

.post-links a:hover{

transform:translateY(-3px);

box-shadow:0 10px 25px rgba(0,0,0,.12);

background:var(--theme);

color:white;

}

.post-links small{

opacity:.8;

}

.footer{

    margin-top:25px;

    background:var(--theme);

    color:white;

    padding:20px;

    text-align:center;

    border-radius:15px;

}

@media(max-width:900px){

.dashboard{

grid-template-columns:1fr;

}

.header{

flex-direction:column;

text-align:center;

gap:20px;

}

}

.card h2{

margin-bottom:20px;

color:var(--theme);

}

.card h4{

margin-top:20px;

margin-bottom:8px;

color:#444;

}

.card form{

margin-top:20px;

}

.card input[type=file]{

width:100%;

padding:12px;

background:#fafafa;

border-radius:10px;

border:1px solid #ddd;

}

.card button,
.card input[type=submit]{

margin-top:20px;

width:100%;

font-size:16px;

padding:15px;

}

.card{

transition:.25s;
background:#fff;

border:none;

border-radius:16px;

padding:30px;

box-shadow:0 8px 25px rgba(0,0,0,.08);

margin-bottom:25px;
}

.card:hover{

transform:translateY(-3px);

box-shadow:0 15px 35px rgba(0,0,0,.12);

}

</style>

<div class="main-body">

<div class="header">

    <div>

        <h1>Dashboard</h1>

        <h2>Manage your account settings and profile</h2>

    </div>

    <div style="text-align:right;">

        <h3>
            Welcome,
            <?= htmlspecialchars($user['username']); ?> 👋
        </h3>

        <p><?= date("l, F j, Y"); ?></p>

    </div>

</div>

<div class="dashboard">
<?php
/* ==========================================
   Load Posts
========================================== */

$stmt = $conn->prepare("
    SELECT id, title
    FROM posts
    ORDER BY id DESC
");

$stmt->execute();

$posts = $stmt->get_result();

$stmt->close();
?>
<?php
/*check becomes:*/
?>
<!--Menu-->
<aside class="sidebar">

<div class="profile-card">

<?php if (!empty($user['filepath'])) : ?>

    <img src="<?= htmlspecialchars($user['filepath']); ?>" alt="Profile">

<?php else : ?>

    <div class="placeholder">
        No Image
    </div>

<?php endif; ?>

<h3><?= htmlspecialchars($user['username']); ?></h3>

<p>User Dashboard</p>

</div>

<nav class="menu">

<a href="#" id="showPosts">
📝 Edit Posts
</a>

<a href="change_password.php">
🔒 Change Password
</a>

<a href="#" class="show-form" data-form="uploadForm">
🖼 Upload Profile Image
</a>

<a href="#" class="show-form" data-form="profileForm">
🎨 Theme Colours
</a>
<?php if (in_array($_SESSION['role'] ?? '', ['Super Admin','Admin'])): ?>

<a href="/admin/login.php">
⚙ Admin Panel
</a>

<?php endif; ?>
<a href="logout.php">
🚪 Logout
</a>

</nav>

</aside>

<main class="content">
<!--Menu-->


       <h3>Welcome back, <?= htmlspecialchars($user['username']); ?> 👋</h3>

<h4>
Manage your account settings using the options on the left.
</h4>

<div class="card">

<h2>Profile Overview</h2>

<p>
This is your personal dashboard where you can:
</p>

<ul style="margin-top:20px; line-height:2;">

<li>✔ Change your password</li>

<li>✔ Upload a profile picture</li>

<li>✔ Customise your colours</li>

<li>✔ Edit your homepage posts</li>

<?php if (in_array($_SESSION['role'] ?? '', ['Super Admin','Admin'])): ?>

<li>✔ Access the Admin Panel</li>

<?php endif; ?>

</ul>

</div> 

<div class="card">

<h2>Your Profile Image</h2>

<br>

<?php if (!empty($user['filepath'])) : ?>

<img
    src="<?= htmlspecialchars($user['filepath']); ?>"
    class="profile-image"
    alt="Profile Picture">

<?php else : ?>

<div style="text-align:center;padding:40px;">

<h3>No Profile Image</h3>

<p>

Upload one using the menu on the left.

</p>

</div>

<?php endif; ?>

</div>

<div class="card form"
     id="uploadForm"
     style="display:none;">

    <h2>Upload Profile Image</h2>

    <p>Maximum size: 5MB</p>

    <form method="post"
          enctype="multipart/form-data">

        <p>Select image to upload:</p>

        <input
            type="file"
            name="image"
            accept="image/*"
            required>

        <input
            type="submit"
            name="submit"
            value="Upload Image">

    </form>

</div>

<div class="card form"
     id="profileForm"
     style="display:none;">

<h2>Theme Colours</h2>

<form method="post">

<h4>Theme Colour</h4>

<input
    type="color"
    name="theme_color"
    value="<?= htmlspecialchars($user['theme_color'] ?: '#007bff'); ?>">

<h4>Background Colour</h4>

<input
    type="color"
    name="background_color"
    value="<?= htmlspecialchars($user['background_color'] ?: '#ffffff'); ?>">

<h4>Text Colour</h4>

<input
    type="color"
    name="text_color"
    value="<?= htmlspecialchars($user['text_color'] ?: '#000000'); ?>">

<button
type="submit"
name="save_colors">

Save Colours

</button>

</form>

</div>


        <?php if ($message): ?>

            <div class="message">
                <?= htmlspecialchars($message); ?>
            </div>

        <?php endif; ?>
<br>

<div
class="card post-links"
id="postList"
style="display:none;">

<h2>📝 Edit Homepage Posts</h2>

<p style="margin-bottom:25px;">
Select a post to edit.
</p>

<?php while ($post = $posts->fetch_assoc()) : ?>

<a href="edit-index.php?id=<?= $post['id']; ?>">

<strong><?= htmlspecialchars($post['title']); ?></strong>

<br>

<small>
Click to edit this post
</small>

</a>

<?php endwhile; ?>

</div>

  </main>
<script>

document.querySelectorAll(".show-form").forEach(function(link){

link.addEventListener("click",function(e){

e.preventDefault();

let id=this.dataset.form;

document.querySelectorAll(".form").forEach(function(f){

if(f.id!==id){

f.style.display="none";

}

});

let form=document.getElementById(id);

if(form.style.display==="block"){

form.style.display="none";

}else{

form.style.display="block";

form.scrollIntoView({

behavior:"smooth",

block:"start"

});

}

});

});

document.getElementById("showPosts").addEventListener("click",function(e){

e.preventDefault();

let list=document.getElementById("postList");

if(list.style.display==="block"){

list.style.display="none";

}else{

list.style.display="block";

list.scrollIntoView({

behavior:"smooth"

});

}

});

</script>
<div class="footer">
    <h4>
        User Dashboard • <?= date('F j, Y'); ?>
    </h4>
</div>