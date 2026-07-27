<?php

namespace App\Services;

use App\Repositories\CommentRepository;

class CommentService
{
    public function __construct(
        private CommentRepository $comments
    ) {
    }


    public function create(
        int $postId,
        int $userId,
        string $comment
    ): ServiceResult {


        if (trim($comment) === '') {

            return ServiceResult::error(
                'Please enter a comment.'
            );
        }


        $success = $this->comments->create(
            $postId,
            $userId,
            trim($comment)
        );


        if (!$success) {

            return ServiceResult::error(
                'Error posting comment.'
            );
        }


        return ServiceResult::success(
            'Comment submitted and waiting for approval.'
        );
    }


    public function update(
        int $id,
        int $userId,
        string $comment
    ): ServiceResult {


        if (trim($comment) === '') {

            return ServiceResult::error(
                'Comment cannot be empty.'
            );
        }


        $success = $this->comments->update(
            $id,
            $userId,
            trim($comment)
        );


        return $success
            ? ServiceResult::success('Comment updated.')
            : ServiceResult::error('Error updating comment.');
    }


    public function delete(
        int $id,
        int $userId
    ): ServiceResult {


        $success = $this->comments->delete(
            $id,
            $userId
        );


        return $success
            ? ServiceResult::success('Comment deleted.')
            : ServiceResult::error('Error deleting comment.');
    }


    public function getComments(
        int $postId
    ): array {

        return $this->comments->findApprovedByPost(
            $postId
        );
    }
}