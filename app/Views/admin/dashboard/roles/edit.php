<div class="admin-card">

<h1>
Edit Role
</h1>


<form method="POST" action="/admin/roles/update">


<input
type="hidden"
name="id"
value="<?= $role['id'] ?>"
>


<label>
Role Name
</label>

<br>

<input
type="text"
name="name"
value="<?= htmlspecialchars($role['name']) ?>"
required
>


<br><br>


<label>
Description
</label>

<br>

<textarea
name="description"
rows="5"
cols="40"
required><?= htmlspecialchars($role['description']) ?></textarea>


<br><br>


<button 
class="green-button"
type="submit">

Save Changes

</button>


<a 
class="blue-button"
href="/admin/roles">

Cancel

</a>


</form>


</div>