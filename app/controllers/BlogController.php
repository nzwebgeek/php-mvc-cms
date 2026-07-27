<?php

class BlogController
{
    public function index()
    {
        $posts = $this->postModel->getPublishedPosts();

        $images = $this->postModel->getBlogImages();

        require '../Views/blog/index.php';
    }
}