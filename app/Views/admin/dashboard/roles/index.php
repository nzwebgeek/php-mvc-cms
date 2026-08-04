<div class="admin-card">


<!-- SUCCESS MESSAGE -->

<?php if (!empty($_SESSION['success'])): ?>

<div class="alert-success">

<?= htmlspecialchars($_SESSION['success']) ?>

</div>

<?php unset($_SESSION['success']); ?>

<?php endif; ?>



<!-- ERROR MESSAGE -->

<?php if (!empty($_SESSION['error'])): ?>

<div class="alert-error">

<?= htmlspecialchars($_SESSION['error']) ?>

</div>

<?php unset($_SESSION['error']); ?>

<?php endif; ?>



<h1>
Roles
</h1>


<a class="green-button"
href="/admin/roles/create">

+ Add Role

</a>


</div>





<div class="admin-card">


<table class="admin-table">


<thead>

<tr>

<th>
Name
</th>


<th>
Description
</th>


<th>
Actions
</th>


</tr>

</thead>





<tbody>


<?php foreach($roles as $role): ?>


<tr>


<td>
<?= htmlspecialchars($role['name']) ?>
</td>



<td>
<?= htmlspecialchars($role['description']) ?>
</td>



<td class="actions">



<a class="blue-button"
href="/admin/roles/edit?id=<?= $role['id'] ?>">

Edit

</a>





<form method="POST"
action="/admin/roles/delete"
style="display:inline;">


<input 
type="hidden"
name="id"
value="<?= $role['id'] ?>">



<button 
class="red-button"
type="submit"
onclick="return confirm('Delete this role?');">

Delete

</button>


</form>



</td>


</tr>


<?php endforeach; ?>


</tbody>


</table>


</div>