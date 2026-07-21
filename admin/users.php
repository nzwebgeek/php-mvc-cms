<?php
require 'includes/auth.php';
require __DIR__ . '/../includes/db.php';

$sql = "
SELECT
    u.id,
    u.username,
    u.email,
    r.name AS role
FROM users u
LEFT JOIN roles r ON u.role_id = r.id
ORDER BY u.username
";

$result = $conn->query($sql);

$users = $result->fetch_all(MYSQLI_ASSOC);

?>

<h1>Users</h1>

<a href="index.php?page=create-user" class="button">+ Add User</a>

<table>
<tr>
    <th>Name</th>
    <th>Email</th>
    <th>Role</th>
    <th>Actions</th>
</tr>

<?php foreach ($users as $user): ?>

<tr>
    <td><?= htmlspecialchars($user['username']) ?></td>
    <td><?= htmlspecialchars($user['email']) ?></td>
    <td><?= htmlspecialchars($user['role']) ?></td>
    <td>
       <a class="button" href="index.php?page=edit-user&id=<?= $user['id'] ?>">Edit</a> 
        <a class="delete-button" href="index.php?page=delete-user&id=<?= $user['id'] ?>"
         onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
    </td>
</tr>

<?php endforeach; ?>

</table>