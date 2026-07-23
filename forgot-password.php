<?php
require 'includes/db.php';
require 'includes/settings.php';

include 'includes/header.php';
$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = trim($_POST['email']);

    $stmt = $conn->prepare("SELECT id FROM users WHERE email=?");
    $stmt->bind_param("s",$email);
    $stmt->execute();

    $result = $stmt->get_result();

    if($user = $result->fetch_assoc()){

        $token = bin2hex(random_bytes(32));
        $tokenHash = hash('sha256', $token);

        $expires = date("Y-m-d H:i:s", strtotime("+1 hour"));

        $stmt = $conn->prepare("
            UPDATE users
            SET
                reset_token=?,
                reset_expires=?
            WHERE id=?
        ");

        $stmt->bind_param(
            "ssi",
            $tokenHash,
            $expires,
            $user['id']
        );

$stmt->execute();
        $stmt->execute();

        $link = "http://stage-three.test/reset-password.php?token=".$token;

        // Mail example
        mail(
            $email,
            "Password Reset",
            "Click the following link:\n\n".$link
        );
    }

    // Never reveal if email exists
    $message = "If an account exists, a reset email has been sent.";
}
?>

<main>
    <section>
        <h1>Reset Password</h1>
        <form method="post">
            <label>Email</label>
            <input type="email" name="email" required>

            <button>Send Reset Link</button>
        </form>
        <?= htmlspecialchars($message) ?>

    </section>
</main>

<?php include 'includes/footer.php'; ?>