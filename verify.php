<?php

// Include the Database class
require 'app/Core/Database.php';

use App\Core\Database;

// Get a PDO database connection
$db = Database::connect();

// --------------------------------------------
// Get the verification token from the URL
// Example: verify.php?token=abc123
// --------------------------------------------
$token = trim($_GET['token'] ?? '');

// Default values
$success = false;
$message = '';

try {

    // Check if a token was supplied
    if ($token === '') {

        $message = "No verification token was supplied.";

    } else {

        // --------------------------------------------
        // Check if the verification token exists
        // --------------------------------------------
        $stmt = $db->prepare("
            SELECT id
            FROM users
            WHERE verification_token = ?
        ");

        // Execute the query and pass the token
        $stmt->execute([$token]);

        // Fetch the matching user (or false if none found)
        $user = $stmt->fetch();

        // If no user was found, the token is invalid
        if (!$user) {

            $message = "This verification link is invalid or has already been used.";

        } else {

            // --------------------------------------------
            // Verify the user's email
            // --------------------------------------------
            $stmt = $db->prepare("
                UPDATE users
                SET
                    email_verified = 1,
                    verification_token = NULL
                WHERE verification_token = ?
            ");

            // Execute the UPDATE query
            $stmt->execute([$token]);

            // Check if a row was updated
            if ($stmt->rowCount() > 0) {

                $success = true;
                $message = "🎉 Your email has been verified successfully! You can now log in to your account.";

            } else {

                $message = "Verification failed. Please try again.";

            }
        }
    }

} catch (PDOException $e) {

    // In production, log this instead of displaying it
    $message = "An unexpected database error occurred.";
    $success = false;

    // Uncomment during development only
    // die($e->getMessage());
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

<?php if ($success): ?>

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