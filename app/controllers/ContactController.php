<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\PageRepository;
use App\Repositories\SettingsRepository;
use App\Services\Mailer;

class ContactController extends Controller
{
    public function __construct(
        private SettingsRepository $settings,
        private PageRepository $pages,
         private Mailer $mailer
    ) {
    }

    public function index(): void
    {
        $this->view('pages/contact/contact', [
            'settings' => $this->settings->get(),
            'pages'    => $this->pages->getAll(),
            'success'  => '',
            'error'    => '',
        ]);
    }

    public function send(): void
    {
        $data = [
            'settings' => $this->settings->get(),
            'pages'    => $this->pages->getAll(),
            'success'  => '',
            'error'    => '',
        ];

        $fname = filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $lname = filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $country = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $to = "fabricflannigan@gmail.com";
        $subject = "New Contact Form Submission from $fname $lname";

        $body = "First Name: $fname\n";
        $body .= "Last Name: $lname\n";
        $body .= "Email: $email\n";
        $body .= "Country: $country\n\n";
        $body .= "Message:\n$message";

       if ($email && $this->mailer->sendContactEmail(
    $to,
    "$fname $lname",
    $email,
    $country,
    $message
)) {
    $data['success'] = 'Email successfully sent!';
} else {
    $data['error'] = 'Failed to send email.';
}

        $this->view('pages/contact/contact', $data);
    }
}