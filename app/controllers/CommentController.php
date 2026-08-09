<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\CommentRepository;
use App\Services\AuthService;

class CommentController extends Controller
{
    public function __construct(
        private AuthService $authService,
        private CommentRepository $commentRepository
    ) {
    }

    /**
     * Store a new comment from a logged-in user.
     *
     * New comments are saved as "pending"
     * until approved by an administrator.
     */
    public function store(): void
    {
        $this->authService->requireLogin();

        $postId = (int) ($_POST['post_id'] ?? 0);
        $comment = trim($_POST['comment'] ?? '');

        $userId = $this->authService->currentUserId();

        if (!$userId) {
            header('Location: /login');
            exit;
        }

        if ($postId <= 0 || $comment === '') {
            header(
                'Location: /blog/post?id=' . $postId . '&error=comment'
            );
            exit;
        }

        $success = $this->commentRepository->create(
            $postId,
            $userId,
            $comment
        );

        if ($success) {
            header(
                'Location: /blog/post?id=' . $postId . '&success=comment'
            );
            exit;
        }

        header(
            'Location: /blog/post?id=' . $postId . '&error=comment'
        );
        exit;
    }

    /**
     * Display all comments in the admin dashboard.
     */
    public function index(): void
    {
        $this->authService->requireAdmin();

        $comments = $this->commentRepository->allForAdmin();

        $this->view(
            'admin/dashboard/comments/index',
            [
                'title' => 'Manage Comments',
                'comments' => $comments,
                'pendingCount' => $this->commentRepository->countPending(),
            ],
            'admin'
        );
    }

    /**
     * Approve a pending comment.
     */
    public function approve(): void
    {
        $this->authService->requireAdmin();

        $id = (int) ($_POST['id'] ?? 0);

        if ($id <= 0) {
            header('Location: /admin/comments?error=comment');
            exit;
        }

        $success = $this->commentRepository->approve($id);

        if ($success) {
            header(
                'Location: /admin/comments?success=approved'
            );
            exit;
        }

        header(
            'Location: /admin/comments?error=approve'
        );
        exit;
    }

    /**
     * Delete a comment from the admin dashboard.
     */
    public function delete(): void
    {
        $this->authService->requireAdmin();

        $id = (int) ($_POST['id'] ?? 0);

        if ($id <= 0) {
            header(
                'Location: /admin/comments?error=comment'
            );
            exit;
        }

        $success = $this->commentRepository->deleteByAdmin($id);

        if ($success) {
            header(
                'Location: /admin/comments?success=deleted'
            );
            exit;
        }

        header(
            'Location: /admin/comments?error=delete'
        );
        exit;
    }
}
