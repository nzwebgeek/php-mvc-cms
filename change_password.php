<?php
require 'includes/db.php';
require 'includes/settings.php';
require 'helpers/helper.php';

include 'includes/header.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $userId = $_SESSION['user_id'];

    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword !== $confirmPassword) {
        die("New passwords do not match.");
    }

    if (strlen($newPassword) < 8) {
        die("Password must be at least 8 characters.");
    }

    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        die("User not found.");
    }

    if (!password_verify($currentPassword, $user['password'])) {
        die("Current password is incorrect.");
    }

    $newHash = password_hash($newPassword, PASSWORD_DEFAULT);

    $update = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    $update->bind_param("si", $newHash, $userId);

    if ($update->execute()) {
        session_regenerate_id(true);
        $success = "Password changed successfully.";
    } else {
        $error = "Error changing password.";
    }
}
?>

<form action="" method="post">
    <label>Current Password</label>
    <input type="password" name="current_password" required>

    <label>New Password</label>
    <input type="password" name="new_password" required>

    <label>Confirm Password</label>
    <input type="password" name="confirm_password" required>

    <button type="submit">Change Password</button>
</form>

<?php
if (isset($success)) echo "<p>$success</p>";
if (isset($error)) echo "<p>$error</p>";

include 'includes/footer.php';
?>