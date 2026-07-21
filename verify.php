<?php

require 'includes/db.php';

$token = trim($_GET['token'] ?? '');

if ($token === '') {
    $message = "No verification token was supplied.";
    $success = false;
} else {

    $check = $conn->prepare("
        SELECT id, email_verified
        FROM users
        WHERE verification_token = ?
    ");

    $check->bind_param("s", $token);
    $check->execute();

    $result = $check->get_result();

    if ($result->num_rows === 0) {
        $message = "This verification link is invalid or has already been used.";
        $success = false;
    } else {

        $stmt = $conn->prepare("
            UPDATE users
            SET
                email_verified = 1,
                verification_token = NULL
            WHERE verification_token = ?
        ");

        $stmt->bind_param("s", $token);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $message = "🎉 Your email has been verified successfully! You can now log in to your account.";
            $success = true;
        } else {
            $message = "Verification failed. Please try again.";
            $success = false;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Email Verification</title>

<style>
body{
    margin:0;
    font-family:Arial, Helvetica, sans-serif;
    background:#f4f6f9;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.card{
    background:#fff;
    padding:40px;
    border-radius:12px;
    box-shadow:0 10px 25px rgba(0,0,0,.12);
    max-width:500px;
    text-align:center;
}

.icon{
    font-size:60px;
    margin-bottom:20px;
}

.success{
    color:#28a745;
}

.error{
    color:#dc3545;
}

h1{
    margin:0 0 15px;
}

p{
    color:#555;
    line-height:1.6;
}

.btn{
    display:inline-block;
    margin-top:25px;
    padding:12px 24px;
    background:#007bff;
    color:#fff;
    text-decoration:none;
    border-radius:6px;
}

.btn:hover{
    background:#0056b3;
}
</style>
</head>
<body>

<div class="card">

<?php if($success): ?>
    <div class="icon success">✓</div>
    <h1>Email Verified</h1>
<?php else: ?>
    <div class="icon error">✖</div>
    <h1>Verification Error</h1>
<?php endif; ?>

<p><?= htmlspecialchars($message) ?></p>

<a href="login.php" class="btn">Go to Login</a>

</div>

</body>
</html>