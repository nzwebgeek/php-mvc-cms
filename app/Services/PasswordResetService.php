<?php
declare(strict_types=1);
namespace App\Services;

use App\Repositories\UserRepository;
use App\Services\Mailer;

class PasswordResetService
{
    public function __construct(
        private UserRepository $users,
        private Mailer $mailer,
         private PasswordService $passwords
    ) {
    }


    public function requestReset(
        string $email
    ): ServiceResult {

        $user = $this->users->findByEmail($email);


        /*
         * Always return the same message.
         * This prevents revealing whether an email exists.
         */
        if (!$user) {
            return ServiceResult::success(
                'If an account exists, a reset email has been sent.'
            );
        }


        $token = bin2hex(
            random_bytes(32)
        );


        $tokenHash = hash(
            'sha256',
            $token
        );

        $expires = date(
            'Y-m-d H:i:s',
            strtotime('+1 hour')
        );


        $saved = $this->users->savePasswordResetToken(
            $user['id'],
            $tokenHash,
            $expires
        );


        if (!$saved) {
            return ServiceResult::error(
                'Unable to create password reset request.'
            );
        }

            error_log(
        'RESET TOKEN LENGTH: ' . strlen($token)
    );

        $sent = $this->mailer->sendPasswordReset(
            $user['email'],
            $user['username'],
            $token
        );


        if (!$sent) {
            return ServiceResult::error(
                'Unable to send reset email.'
            );
        }


        return ServiceResult::success(
            'If an account exists, a reset email has been sent.'
        );
    }


    public function resetPassword(
        string $token,
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


        $tokenHash = hash(
            'sha256',
            $token
        );

        $user = $this->users->findByResetToken(
    $tokenHash
);

if (!$user) {
    die(
        'SERVICE TOKEN HASH: ' . $tokenHash .
        '<br>No matching user found'
    );
}

die(
    'SERVICE TOKEN HASH: ' . $tokenHash .
    '<br>User found: ' . $user['email']
);

       
      
        if (!$user) {
            return ServiceResult::error(
                'Invalid or expired reset link.'
            );
        }

        $hashedPassword = $this->passwords->hash($password);

        $updated = $this->users->updatePassword(
            $user['id'],
            $hashedPassword
        );


        if (!$updated) {
            return ServiceResult::error(
                'Unable to update password.'
            );
        }


        return ServiceResult::success(
            'Password has been reset successfully.'
        );
    }
}