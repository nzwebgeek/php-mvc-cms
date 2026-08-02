<?php
declare(strict_types=1);

namespace App\Services;

use App\Repositories\UserRepository;

class AuthService
{
    public function __construct(
    private UserRepository $users,
    private Mailer $mailer
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
    $_SESSION['role'] = $user['role'];

    return ServiceResult::success(
        'Login successful.'
    );
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

        $hashedPassword = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

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

    
}