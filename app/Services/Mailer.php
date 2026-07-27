<?php

declare(strict_types=1);

namespace App\Services;

class Mailer
{
    private string $appUrl;
    private string $from;

    public function __construct(
        string $appUrl,
        string $from
    ) {
        $this->appUrl = $appUrl;
        $this->from = $from;
    }


    public function sendPasswordReset(
        string $email,
        string $username,
        string $token
    ): bool {

        $link = $this->appUrl .
            '/reset-password?token=' .
            $token;


        $subject = 'Password Reset';

        $message = "
            Hello {$username},

            Click the link below to reset your password:

            {$link}
        ";


        return mail(
            $email,
            $subject,
            $message
        );
    }
}