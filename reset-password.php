<?php

// --------------------------------------------------
// Include the database connection
// --------------------------------------------------
require 'includes/db.php';

// --------------------------------------------------
// Get the reset token from the URL
// Example:
// reset_password.php?token=abc123
// --------------------------------------------------
$token = $_GET['token'] ?? '';

// Hash the token.
// The database stores the hashed version, not the plain token.
$tokenHash = hash('sha256', $token);

// Default values
$success = false;
$message = '';


// --------------------------------------------------
// Find the user that owns this reset token
// --------------------------------------------------
$findUser = $conn->prepare("
    SELECT id
    FROM users
    WHERE reset_token = ?
    AND reset_expires > NOW()
");

$findUser->bind_param("s", $tokenHash);
$findUser->execute();

$result = $findUser->get_result();
$user = $result->fetch_assoc();


// --------------------------------------------------
// If no matching user was found,
// the token is invalid or has expired.
// --------------------------------------------------
if (!$user) {

    $message = "Invalid or expired reset link.";

} else {

    // --------------------------------------------------
    // Has the user submitted the form?
    // --------------------------------------------------
    if ($_SERVER['REQUEST_METHOD'] === "POST") {

        // Get the password entered by the user
        $password = trim($_POST['password']);

        // --------------------------------------------------
        // Basic password validation
        // (We'll improve this later.)
        // --------------------------------------------------
        if (strlen($password) < 8) {

            $message = "Password must be at least 8 characters long.";

        } else {

            // Hash the password before storing it
            $hashedPassword = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            // --------------------------------------------------
            // Update the user's password
            // Remove the reset token so it cannot be reused
            // --------------------------------------------------
            $updatePassword = $conn->prepare("
                UPDATE users
                SET
                    password = ?,
                    reset_token = NULL,
                    reset_expires = NULL
                WHERE id = ?
            ");

            $updatePassword->bind_param(
                "si",
                $hashedPassword,
                $user['id']
            );

            $updatePassword->execute();

            // Check if the password was updated
            if ($updatePassword->affected_rows > 0) {

                $success = true;
                $message = "✅ Your password has been changed successfully.";

            } else {

                $message = "Unable to update your password. Please try again.";

            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Reset Password</title>

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
    width:400px;
}

h1{
    margin-top:0;
    text-align:center;
}

.message{
    margin-bottom:20px;
    color:#555;
}

.success{
    color:#28a745;
}

.error{
    color:#dc3545;
}

label{
    display:block;
    margin-bottom:8px;
}

input{
    width:100%;
    padding:12px;
    margin-bottom:20px;
    box-sizing:border-box;
}

button{
    width:100%;
    padding:12px;
    background:#007bff;
    color:#fff;
    border:none;
    cursor:pointer;
    border-radius:6px;
}

button:hover{
    background:#0056b3;
}

</style>

</head>

<body>

<div class="card">

<h1>Reset Password</h1>

<?php if ($message): ?>

<p class="message <?= $success ? 'success' : 'error'; ?>">
    <?= htmlspecialchars($message); ?>
</p>

<?php endif; ?>


<?php if (!$success && $user): ?>

<form method="post">

    <label for="password">New Password</label>

    <input
        id="password"
        type="password"
        name="password"
        required
        minlength="8"
    >

    <button type="submit">
        Reset Password
    </button>

</form>

<?php endif; ?>

</div>

</body>
</html>

<form method="post">

    <label>New Password</label>

    <input
        type="password"
        name="password"
        required
    >

    <button>Reset Password</button>

</form>