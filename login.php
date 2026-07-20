
<?php
session_start();


require 'db.php';
include 'includes/header.php';

$message = "";
$messageType = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    //$stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
    $stmt = $conn->prepare("
    SELECT
    u.id,
    u.username,
    u.password,
    u.email_verified,
    r.name AS role
FROM users u
LEFT JOIN roles r
    ON u.role_id = r.id
WHERE u.username = ?
");

    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    

    if ($user && password_verify($password, $user['password'])) {
        
       if (!$user['email_verified']) {
        $messageType = "warning";
        $message = "Please verify your email before logging in before you can access your account.";
        } 
        else {
        session_regenerate_id(true);

       $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        header("Location: dashboard.php");
        exit();
    }

    } else {
        $messageType = "error";
        $message = "Invalid username or password.";
    }

    $stmt->close();
}

?>
<main>
    <section>
        <h1>Login</h1>

       <?php if (!empty($message)): ?>
            <div class="alert <?php echo $messageType; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form action="" method="post">
            <label for="username">Username</label>
            <input
                type="text"
                id="username"
                name="username"
                placeholder="Your username..."
                required
            >

            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                placeholder="Your password..."
                required
            >

            <input type="submit" value="Login">
            <p>
    <a href="forgot-password.php">Forgot your password?</a>
</p>
        </form>

        <button id="toggleBtn">Change Color</button>

    </section>
</main>

<?php include 'includes/footer.php'; ?>