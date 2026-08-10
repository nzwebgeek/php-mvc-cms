<?php
declare(strict_types=1);
/*AuthService handles authentication/session logic*/
namespace App\Services;

use App\Repositories\UserRepository;
/*--Add Authentication Functions here, AuthService handles registration/authentication logic--*/
class AuthService
{
    public function __construct(
    private UserRepository $users,
    private Mailer $mailer,
    private PasswordService $passwords
    ) {
    }

   public function login(
    
    string $username,
    string $password
): ServiceResult {

    $user = $this->users->findByUsername($username);

    if (!$user) {
        return ServiceResult::error(
            'Invalid username or password.'
        );
    }

    if (!password_verify($password, $user['password'])) {
        return ServiceResult::error(
            'Invalid username or password.'
        );
    }

    if (!$user['email_verified']) {
        return ServiceResult::warning(
            'Please verify your email before logging in.'
        );
    }

    session_regenerate_id(true);

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = strtolower($user['role']);
    
    return ServiceResult::success(
        'Login successful.'
    );
}

public function logout(): void
{
    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();

        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }

    session_destroy();
}

public function register(
    string $username,
    string $email,
    string $password,
    string $confirmPassword
): ServiceResult {

    if ($password !== $confirmPassword) {
        return ServiceResult::error(
            'Passwords do not match.'
        );
    }
    
    $passwordError = $this->passwords->validate($password);

    if ($passwordError !== null) {
        return ServiceResult::error($passwordError);
    }


    if ($this->users->usernameOrEmailExists($username, $email)) {
        return ServiceResult::error(
            'That username or email is already registered.'
        );
    }

    $roleId = $this->users->findRoleIdByName('User');

    if (!$roleId) {
        return ServiceResult::error(
            'Default role not found.'
        );
    }

        $token = bin2hex(random_bytes(32));

       $hashedPassword = $this->passwords->hash($password);

        $success = $this->users->createUser(
            $username,
            $email,
            $hashedPassword,
            $roleId,
            $token
        );

        if (!$success) {
    return ServiceResult::error(
        'Registration failed.'
    );
}

        $this->mailer->sendVerificationEmail(
            $email,
            $username,
            $token
        );

        return ServiceResult::success(
            'Registration successful. Please check your email to verify your account.'
        );
    }

      // Existing methods...

    public function isLoggedIn(): bool
    {
        return isset($_SESSION['user_id']);
    }

    public function isSuperAdmin(): bool{
    return ($_SESSION['role'] ?? '') === 'super admin';
    }

    public function isAdmin(): bool
    {
        $role = strtolower($_SESSION['role'] ?? '');

        return in_array(
            $role,
            [
                'admin',
                'super admin'
            ],
            true
        );
    }

    public function requireLogin(): void{
        if (!$this->isLoggedIn()) {
            header('Location: /login');
            exit;
        }
    }

    public function requireAdmin(): void
    {
        $this->requireLogin();

        if (!$this->isAdmin()) {
            header('Location: /dashboard');
            exit;
        }
    }

    public function requireSuperAdmin(): void{
        $this->requireAdmin();

        if (!$this->isSuperAdmin()) {
            header('Location: /admin/users');
            exit;
        }
    }

    public function currentUserId(): ?int
    {
        return $_SESSION['user_id'] ?? null;
    }

    public function currentUsername(): ?string
    {
        return $_SESSION['username'] ?? null;
    }

    public function currentRole(): ?string
    {
        return $_SESSION['role'] ?? null;
    }


    
}