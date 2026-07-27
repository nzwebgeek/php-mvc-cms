<?php

namespace App\Controllers;

use App\Models\Comment;

class CommentController
{
    public function __construct(
        private Comment $commentModel
    ){}

    public function index($postId)
    {
        return $this->commentModel->approvedByPost($postId);
    }

    public function store($postId,$userId,$comment)
    {
        return $this->commentModel->create(
            $postId,
            $userId,
            trim($comment)
        );
    }

    public function update($id,$userId,$comment)
    {
        return $this->commentModel->update(
            $id,
            $userId,
            trim($comment)
        );
    }

    public function delete($id,$userId)
    {
        return $this->commentModel->delete(
            $id,
            $userId
        );
    }
}