<?php
declare(strict_types=1);

namespace App\Services;

use App\Repositories\UserRepository;

class AuthService
{
    public function __construct(
        private UserRepository $users
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

        return ServiceResult::success(
            'Login successful.',
            [
                'user' => $user
            ]
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

        return ServiceResult::success(
            'Registration successful.',
            [
                'token' => $token
            ]
        );
    }
}