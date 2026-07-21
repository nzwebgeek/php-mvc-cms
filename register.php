<?php

require 'includes/db.php';
require 'includes/settings.php';
require 'helpers/helper.php';

include 'includes/header.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];


    if ($password != $confirm_password) {
        $message = "Passwords do not match.";
    } else {

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Look up by Name
        $roleStmt = $conn->prepare("SELECT id FROM roles WHERE name = ?");
        $role = "User";
        $roleStmt->bind_param("s", $role);
        $roleStmt->execute();
        $result = $roleStmt->get_result();
        $roleRow = $result->fetch_assoc();

        $role_id = $roleRow['id'];

        // check if name exists first
            $check = $conn->prepare("
    SELECT id
    FROM users
    WHERE username = ? OR email = ?
");

$check->bind_param("ss", $username, $email);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    $message = "That username or email is already registered.";
} else {
 /**Generate token */
    $token = bin2hex(random_bytes(32));
    /*Generate token*/
    $stmt = $conn->prepare("
        INSERT INTO users (username, email, password, role_id, verification_token)
        VALUES (?, ?, ?, ?, ?)
    ");

    $stmt->bind_param("sssis", $username, $email, $hashedPassword, $role_id, $token);
   
    /*if ($stmt->execute()) {
        $message = "Registration successful!";
    }*/
    /*Verification Start*/
    if ($stmt->execute()) {

    $verifyLink = "http://stage-two.test/verify.php?token=" . $token;


    $subject = "Confirm your account";

    $body = "
    <h2>Welcome $username</h2>

    <p>Please confirm your email address by clicking this link:</p>

    <a href='$verifyLink'>
    Verify Account
    </a>
    ";


    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8\r\n";
    $headers .= "From: noreply@stage-one.com\r\n";


    mail(
        $email,
        $subject,
        $body,
        $headers
    );


    $message = "Registration successful. Please check your email to verify your account.";

}
    /*Verification End*/

    $stmt->close();
}

$check->close();
      

     
       

    }
}
?>

<main>
<section>

<h1>Register</h1>

<?php if (!empty($message)): ?>
    <p><?php echo htmlspecialchars($message); ?></p>
<?php endif; ?>

<form method="post">

<label for="username">Username</label>
<input type="text" id="username" name="username" required>

<label for="email">Email</label>
<input type="email" id="email" name="email" required>

<label for="password">Password</label>
<input type="password" id="password" name="password" required>

<label for="confirm_password">Confirm Password</label>
<input type="password" id="confirm_password" name="confirm_password" required>

<input type="submit" value="Register">

</form>
        <button id="toggleBtn">Change Color</button>

</section>

</main>

<?php include 'includes/footer.php'; ?>