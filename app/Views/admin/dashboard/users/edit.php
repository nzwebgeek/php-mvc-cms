<div class="admin-card">

<h1>
Edit User
</h1>


<form method="POST" action="/admin/users/edit">


<input 
type="hidden"
name="id"
value="<?= $user['id'] ?>"
>


<label>
Username
</label>

<br>

<input 
type="text"
name="username"
value="<?= htmlspecialchars($user['username']) ?>"
>


<br><br>


<label>
Email
</label>

<br>

<input 
type="email"
name="email"
value="<?= htmlspecialchars($user['email']) ?>"
>


<br><br>


<label>
Role
</label>

<br>

<select name="role">


<option
<?= $user['role'] === 'User' ? 'selected' : '' ?>
>
User
</option>


<option
<?= $user['role'] === 'Admin' ? 'selected' : '' ?>
>
Admin
</option>


<option
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