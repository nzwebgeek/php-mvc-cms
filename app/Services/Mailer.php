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

    public function sendVerificationEmail(
        string $email,
        string $username,
        string $token
    ): bool {
        $verifyLink = $this->appUrl .
            '/verify?token=' .
            $token;

        $subject = 'Confirm your account';

        $body = "
            <h2>Welcome {$username}</h2>

            <p>Please confirm your email address by clicking this link:</p>

            <a href=\"{$verifyLink}\">
                Verify Account
            </a>
        ";

        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8\r\n";
        $headers .= "From: {$this->from}\r\n";

        return mail(
            $email,
            $subject,
            $body,
            $headers
        );
    }

    public function sendContactEmail(
        string $to,
        string $name,
        string $email,
        string $country,
        string $message
    ): bool {
        $subject = "New Contact Form Submission from {$name}";

        $body = "
            New contact form submission:

            Name: {$name}
            Email: {$email}
            Country: {$country}

            Message:
            {$message}
        ";

        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type:text/plain;charset=UTF-8\r\n";
        $headers .= "From: {$this->from}\r\n";
        $headers .= "Reply-To: {$email}\r\n";

        return mail(
            $to,
            $subject,
            $body,
            $headers
        );
    }
}
