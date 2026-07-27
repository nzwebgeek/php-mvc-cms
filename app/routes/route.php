<?php
require '../bootstrap.php';

$controller = new CommentController($commentModel);

if(isset($_POST['update']))
{
    $controller->update(
        $_POST['edit_id'],
        $_SESSION['user_id'],
        $_POST['comment']
    );
}

if(isset($_POST['delete_id']))
{
    $controller->delete(
        $_POST['delete_id'],
        $_SESSION['user_id']
    );
}

if(isset($_POST['comments']))
{
    $controller->store(
        $_POST['post_id'],
        $_SESSION['user_id'],
        $_POST['comments']
    );
}

$comments = $controller->index($postId);

require '../views/comments/index.php';
?>