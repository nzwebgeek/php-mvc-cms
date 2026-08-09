<?php
declare(strict_types=1);
?>

<div class="admin-card">

    <div class="admin-page-header">

        <div>
            <h1>Comments</h1>
            <p>Manage comments submitted by users.</p>
        </div>

    </div>


    <?php if (isset($_GET['success'])): ?>

        <?php if ($_GET['success'] === 'approved'): ?>

            <div class="alert-success">
                Comment approved successfully.
            </div>

        <?php elseif ($_GET['success'] === 'deleted'): ?>

            <div class="alert-success">
                Comment deleted successfully.
            </div>

        <?php endif; ?>

    <?php endif; ?>


    <?php if (isset($_GET['error'])): ?>

        <div class="alert-error">
            Something went wrong. Please try again.
        </div>

    <?php endif; ?>


    <!-- Pending comments summary -->

    <div class="comments-summary">

        <div class="comments-stat">

            <span class="comments-stat-label">
                Pending Comments
            </span>

            <span class="comments-stat-number">
                <?= (int) ($pendingCount ?? 0) ?>
            </span>

        </div>

    </div>


    <?php if (empty($comments)): ?>

        <div class="admin-card">

            <p>
                No comments found.
            </p>

        </div>

    <?php else: ?>

        <div class="admin-table-wrapper">

            <table class="admin-table">

                <thead>

                    <tr>

                        <th>ID</th>

                        <th>User</th>

                        <th>Post</th>

                        <th>Comment</th>

                        <th>Status</th>

                        <th>Date</th>

                        <th>Actions</th>

                    </tr>

                </thead>


                <tbody>

                <?php foreach ($comments as $comment): ?>

                    <tr>

                        <td>
                            <?= (int) $comment['id'] ?>
                        </td>


                        <td>
                            <?= htmlspecialchars(
                                $comment['username'] ?? 'Unknown',
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>


                        <td>
                            <?= htmlspecialchars(
                                $comment['post_title'] ?? 'Unknown post',
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>


                        <td class="comment-content">

                            <?= nl2br(
                                htmlspecialchars(
                                    $comment['comment'] ?? '',
                                    ENT_QUOTES,
                                    'UTF-8'
                                )
                            ) ?>

                        </td>


                        <td>

                            <?php if (
                                ($comment['status'] ?? '') === 'approved'
                            ): ?>

                                <span class="status verified">
                                    Approved
                                </span>

                            <?php else: ?>

                                <span class="status pending">
                                    Pending
                                </span>

                            <?php endif; ?>

                        </td>


                        <td>

                            <?= htmlspecialchars(
                                $comment['created_at'] ?? '',
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>

                        </td>


                        <td class="actions">

                            <?php if (
                                ($comment['status'] ?? '') !== 'approved'
                            ): ?>

                                <form
                                    method="POST"
                                    action="/admin/comments/approve"
                                    style="display:inline;"
                                >

                                    <input
                                        type="hidden"
                                        name="csrf_token"
                                        value="<?= htmlspecialchars(
                                            $csrfToken ?? '',
                                            ENT_QUOTES,
                                            'UTF-8'
                                              ) ?>"
                                            >
                                        <input type="hidden"
                                               name="id" 
                                               value="<?= (int) $comment['id'] ?>" 
                                            >

                                    <button
                                        type="submit"
                                        class="green-button"
                                    >
                                        Approve
                                    </button>

                                </form>

                            <?php endif; ?>


                            <form
                                method="POST"
                                action="/admin/comments/delete"
                                style="display:inline;"
                                onsubmit="return confirm('Delete this comment?');"
                            >

                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars( $csrfToken ?? '', ENT_QUOTES, 'UTF-8' ) ?>" >
                               
                            <input
                                    type="hidden"
                                    name="id"
                                    value="<?= (int) $comment['id'] ?>"
                                >

                                <button
                                    type="submit"
                                    class="red-button"
                                >
                                    Delete
                                </button>

                            </form>

                        </td>

                    </tr>

                <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    <?php endif; ?>

</div>