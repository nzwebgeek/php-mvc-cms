<?php if (!empty($_SESSION['error'])): ?>

<div class="alert-error">

<?= htmlspecialchars($_SESSION['error']) ?>

</div>

<?php unset($_SESSION['error']); ?>

<?php endif; ?>

<div class="admin-card">

<h1>
Create Role
</h1>



<form method="POST" action="/admin/roles/create">



<label>
Role Name
</label>

<br>

<input
type="text"
name="name"
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
required></textarea>


<br><br>



<button
class="green-button"
type="submit">

Create Role

</button>



<a
class="blue-button"
href="/admin/roles">

Cancel

</a>



</form>


</div>