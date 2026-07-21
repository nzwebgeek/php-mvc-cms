<?php

require 'includes/auth.php';

require '../includes/db.php';
require '../includes/settings.php';

include 'includes/header.php';
include 'includes/sidebar.php';

?>

<main class="content">

<?php

$page = $_GET['page'] ?? 'dashboard';

switch ($page) {

    case 'users':
        include 'users.php';
        break;

    case 'delete-user':
        include 'delete-user.php';
        break;
        
     case 'edit-user':
        include 'edit-user.php';
        break;

    
     case 'edit-post':
        include 'edit-post.php';
        break;

    case 'create-user':
    include 'create-user.php';
    break;

    case 'roles':
        include 'roles.php';
        break;

    case 'pages':
        include 'pages.php';
        break;

    case 'create-page':
    include 'create-page.php';
    break;

    case 'posts':
        include 'posts.php';
        break;

    case 'create-post':
    include 'create-post.php';
    break;

    case 'delete-post':
        include 'delete-post.php';
        break;

    case 'media':
        include 'media.php';
        break;

    case 'upload-media':
        include 'upload-media.php';
        break;

    case 'upload-blog-image':
        include 'upload-blog-image.php';
        break;

    case 'settings':
        include 'settings.php';
        break;

    default:
        include 'admin_dashboard.php';
}

?>

</main>

<?php include 'includes/footer.php'; ?>