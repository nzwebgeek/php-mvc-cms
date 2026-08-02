<?php
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