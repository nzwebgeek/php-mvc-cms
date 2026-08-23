<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\UserRepository;

class VerifyController extends Controller
{
    public function __construct(
        private readonly UserRepository $users
    ) {
    }


    public function verify(): void
    {
        $token = $_GET['token'] ?? '';

        if ($token === '') {
            $this->view('auth/verify', [
                'message' => 'Invalid verification link.'
            ]);

            return;
        }


        $success = $this->users->verifyEmail(
            $token
        );


        if (!$success) {

            $this->view('auth/verify', [
                'message' => 'Verification failed or link expired.'
            ]);

            return;
        }


       header('Location: /login?verified=1');
exit;
    }
}