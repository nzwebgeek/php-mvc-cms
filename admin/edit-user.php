<?php
require 'includes/auth.php';
require '../includes/db.php';


$id = (int)$_GET['id'];

$stmt = $conn->prepare("
SELECT
    id,
    username,
    email,
    role_id
FROM users
WHERE id = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();

$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
    die("User not found.");
}
?>
<h1>Edit User</h1>

<form action="update-user.php" method="POST">

<input type="hidden" name="id"
       value="<?= $user['id'] ?>">

<label>Username</label>

<input type="text"
       name="username"
       value="<?= htmlspecialchars($user['username']) ?>">

<label>Email</label>

<input type="email"
       name="email"
       value="<?= htmlspecialchars($user['email']) ?>">

<label>Role</label>

<select name="role_id">

<?php

$roles = $conn->query("SELECT id,name FROM roles");

while($role = $roles->fetch_assoc()):

?>

<option
value="<?= $role['id'] ?>"
<?= $role['id']==$user['role_id'] ? 'selected' : '' ?>>

<?= htmlspecialchars($role['name']) ?>

</option>

<?php endwhile; ?>

</select>

<button class="button" type="submit">
Save Changes
</button>

</form>