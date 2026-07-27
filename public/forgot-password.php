<?php

require_once __DIR__ . '/../bootstrap.php';

$message = "";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim(
        $_POST['email'] ?? ''
    );


    if ($email === '') {

        $message = "Please enter your email address.";

    } else {

        $result = $passwordResetService->requestReset(
            $email
        );

        $message = $result->message;
    }
}


include __DIR__ . '/includes/header.php';

?>

<main>

<section>

<h1>Reset Password</h1>

<form method="post">

<label for="email">
    Email
</label>

<input
    type="email"
    id="email"
    name="email"
    required
>

<button type="submit">
    Send Reset Link
</button>

</form>


<?php if ($message): ?>

<p>
    <?= htmlspecialchars($message) ?>
</p>

<?php endif; ?>


</section>

</main>

<?php include __DIR__ . '/includes/footer.php'; ?>