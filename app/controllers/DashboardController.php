<?php

declare(strict_types=1);

namespace App\Controllers;

/* Loads Content */
use App\Core\Controller;
use App\Repositories\UserRepository;
use App\Repositories\PostRepository;
use App\Repositories\ImageRepository;
use App\Services\CsrfService;
use App\Services\PasswordService;

class DashboardController extends Controller
{
    public function __construct(
        private UserRepository $users,
        private PostRepository $posts,
        private ImageRepository $images,
        private CsrfService $csrf,
        private PasswordService $passwords
    ) {
    }

    /* =========================================================
       AUTH HELPERS
       ========================================================= */

    private function currentUser(): array
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $user = $this->users->findById(
            (int) $_SESSION['user_id']
        );

        if ($user === null) {
            session_destroy();

            header('Location: /login');
            exit;
        }

        return $user;
    }

    /* =========================================================
       MAIN DASHBOARD
       ========================================================= */

    public function index(): void
    {
        $user = $this->currentUser();

        // Only show this user's posts
        $posts = $this->posts->findByUser(
            (int) $user['id']
        );

        $panel = $_GET['panel'] ?? 'home';

        // Which posts action are we performing?
        $action = $_GET['action'] ?? null;

        // Inline post editor
        $editPost = null;

        if (isset($_GET['edit'])) {
            $editPost = $this->posts->findByIdAndUser(
                (int) $_GET['edit'],
                (int) $user['id']
            );
        }

        $this->view(
            'dashboard/index',
            [
                'user' => $user,
                'posts' => $posts,
                'panel' => $panel,
                'action' => $action,
                'editPost' => $editPost,
                'csrfToken' => $this->csrf->token()
            ],
            'dashboard'
        );
    }

    /* =========================================================
       CHANGE PASSWORD
       ========================================================= */

    public function changePassword(): void
    {
        $this->csrf->requireValidToken();

        $user = $this->currentUser();

        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        $hash = $this->users->findPasswordHashById(
            (int) $user['id']
        );

        if (!$hash || !password_verify($currentPassword, $hash)) {
            $_SESSION['message'] =
                'Current password is incorrect.';

            header(
                'Location: /dashboard?panel=password'
            );

            exit;
        }

        if ($newPassword !== $confirmPassword) {
            $_SESSION['message'] =
                'New passwords do not match.';

            header(
                'Location: /dashboard?panel=password'
            );

            exit;
        }

        $passwordError = $this->passwords->validate(
            $newPassword
        );

        if ($passwordError !== null) {
            $_SESSION['message'] = $passwordError;

            header(
                'Location: /dashboard?panel=password'
            );

            exit;
        }

        $newHash = $this->passwords->hash(
            $newPassword
        );

        $this->users->updatePassword(
            (int) $user['id'],
            $newHash
        );

        $_SESSION['message'] =
            'Password updated successfully.';

        header(
            'Location: /dashboard?panel=password'
        );

        exit;
    }

    /* =========================================================
       THEME
       ========================================================= */

    private function validColour(string $colour): bool
    {
        return preg_match(
            '/^#[0-9A-Fa-f]{6}$/',
            $colour
        ) === 1;
    }

    public function saveTheme(): void
    {
        $this->csrf->requireValidToken();

        $user = $this->currentUser();

        $theme = $_POST['theme_color'] ?? '#007bff';
        $background = $_POST['background_color'] ?? '#ffffff';
        $text = $_POST['text_color'] ?? '#000000';

        foreach ([$theme, $background, $text] as $colour) {
            if (!$this->validColour($colour)) {
                $_SESSION['message'] =
                    'Invalid colour selected.';

                header('Location: /dashboard');

                exit;
            }
        }

        $this->users->updateTheme(
            (int) $user['id'],
            $theme,
            $background,
            $text
        );

        $_SESSION['message'] =
            'Theme updated successfully.';

        header('Location: /dashboard');

        exit;
    }

    /* =========================================================
       IMAGE UPLOAD
       ========================================================= */

    public function uploadImage(): void
    {
        // CSRF protection
        $this->csrf->requireValidToken();

        // Make sure user is logged in
        $user = $this->currentUser();

        // Make sure a file was submitted
        if (
            !isset($_FILES['image']) ||
            $_FILES['image']['error'] !== UPLOAD_ERR_OK
        ) {
            $_SESSION['message'] =
                'Please select an image.';

            header(
                'Location: /dashboard/upload-image'
            );

            exit;
        }

        try {
            $imageId = $this->images->upload(
                $_FILES['image']
            );

            $this->users->updateImage(
                (int) $user['id'],
                $imageId
            );

            $_SESSION['message'] =
                'Image uploaded successfully.';
        } catch (\Throwable $e) {
            $_SESSION['message'] =
                'Image upload failed.';
        }

        header('Location: /dashboard');

        exit;
    }

    /* =========================================================
       SLUG HELPER
       ========================================================= */

    private function makeSlug(string $title): string
    {
        $slug = strtolower($title);

        // Replace anything that is not a letter or number
        // with a hyphen.
        $slug = preg_replace(
            '/[^a-z0-9]+/',
            '-',
            $slug
        );

        // Remove leading/trailing hyphens
        return trim($slug, '-');
    }

    /* =========================================================
       EDIT POST
       ========================================================= */
public function editPost(): void
{
    $user = $this->currentUser();

    $id = (int)($_GET['id'] ?? 0);

    $post = $this->posts->findByIdAndUser(
        $id,
        (int)$user['id']
    );

    if (!$post) {
        $_SESSION['message'] = "Post not found.";
        header('Location: /dashboard?panel=posts');
        exit;
    }

    $this->view(
        'dashboard/posts/edit',
        [
            'user' => $user,
            'post' => $post,
            'csrfToken' => $this->csrf->token()
        ],
        'dashboard'
    );
}

    /* =========================================================
       UPDATE POST
       ========================================================= */

    public function updatePost(): void
    {
        $this->csrf->requireValidToken();

        $user = $this->currentUser();

        $id = (int) ($_GET['id'] ?? 0);

        $data = $_POST;

        if (empty(trim($data['slug'] ?? ''))) {
            $data['slug'] = $this->makeSlug(
                $data['title'] ?? ''
            );
        }

        $this->posts->update(
            $id,
            (int) $user['id'],
            $data
        );

        $_SESSION['message'] =
            'Post updated successfully.';

        header(
            'Location: /dashboard?panel=posts'
        );

        exit;
    }

    /* =========================================================
       CREATE POST
       ========================================================= */

    public function storePost(): void
    {
        $this->csrf->requireValidToken();

        $user = $this->currentUser();

        $data = $_POST;

        // Auto-generate slug if left empty
        if (empty(trim($data['slug'] ?? ''))) {
            $data['slug'] = $this->makeSlug(
                $data['title'] ?? ''
            );
        }

        $this->posts->create(
            (int) $user['id'],
            $data
        );

        $_SESSION['message'] =
            'Post created successfully.';

        header(
            'Location: /dashboard?panel=posts'
        );

        exit;
    }
}

