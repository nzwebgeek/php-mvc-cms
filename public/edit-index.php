<?php

session_start();

require_once __DIR__ . '/../bootstrap.php';


if (!isset($_SESSION['user_id'])) {

    header(
        "Location: login.php"
    );

    exit;
}


$postId = (int)($_GET['id'] ?? $_POST['post_id'] ?? 0);


if ($postId === 0) {

    die("No post selected.");
}


$message = "";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    if (isset($_POST['comments'])) {

        $result = $commentService->create(
            $postId,
            $_SESSION['user_id'],
            $_POST['comments']
        );

        $message = $result->message;
    }


    if (isset($_POST['update'])) {

        $result = $commentService->update(
            (int)$_POST['edit_id'],
            $_SESSION['user_id'],
            $_POST['comment']
        );

        $message = $result->message;
    }


    if (isset($_POST['delete_id'])) {

        $result = $commentService->delete(
            (int)$_POST['delete_id'],
            $_SESSION['user_id']
        );

        $message = $result->message;
    }
}


$comments = $commentService->getComments(
    $postId
);


include 'includes/header.php';