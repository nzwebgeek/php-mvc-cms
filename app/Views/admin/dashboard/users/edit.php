<?php
/** @var array $user */
?>
<div class="admin-card">

<h1>
Edit User
</h1>


<form method="POST" action="/admin/users/update">

<input
    type="hidden"
    name="csrf_token"
    value="<?= htmlspecialchars(
        $csrfToken ?? '',
        ENT_QUOTES,
        'UTF-8'
    ) ?>"
>

<input 
type="hidden"
name="id"
value="<?= (int)$user['id'] ?>">


<label>
Username
</label>

<br>

<input
    type="text"
    name="username"
    value="<?= htmlspecialchars(
        $user['username'] ?? '',
        ENT_QUOTES,
        'UTF-8'
    ) ?>"
>


<br><br>


<label>
Email
</label>

<br>

<input
    type="email"
    name="email"
    value="<?= htmlspecialchars(
        $user['email'] ?? '',
        ENT_QUOTES,
        'UTF-8'
    ) ?>"
>


<br><br>


<label>
Role
</label>

<br>

<select name="role">


<option 
value="User"
<?= $user['role'] === 'User' ? 'selected' : '' ?>
>
User
</option>



<option 
value="Admin"
<?= $user['role'] === 'Admin' ? 'selected' : '' ?>
>
Admin
</option>



<option 
value="Super Admin"
<?= $user['role'] === 'Super Admin' ? 'selected' : '' ?>
>
Super Admin
</option>


</select>


<br><br>


<button type="submit">
Save Changes
</button>


</form>

</div>