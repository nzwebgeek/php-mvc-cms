<div class="admin-card">
    <h1>
    Manage Pages
</h1>


<?php if(isset($_GET['success'])): ?>

<div class="alert alert-success">

<?php

switch($_GET['success']) {

case 'created':
echo "Page created successfully.";
break;

case 'updated':
echo "Page updated successfully.";
break;

case 'deleted':
echo "Page deleted successfully.";
break;

}

?>

</div>

<?php endif; ?>


<?php if(isset($_GET['error'])): ?>

<div class="alert alert-danger">

<?php

switch($_GET['error']) {

case 'protected':
echo "This page cannot be deleted because it is a core website page.";
break;

}

?>

</div>

<?php endif; ?>


<a href="/admin/pages/create"
class="green-button">

Create New Page

</a>


<?php if(empty($pages)): ?>

<div class="alert alert-info">

No pages found.

</div>


<?php else: ?>


<table class="admin-table">


<thead>

<tr>

<th>
Title
</th>

<th>
Slug
</th>

<th>
Status
</th>

<th>
Actions
</th>

</tr>

</thead>


<tbody>


<?php foreach($pages as $page): ?>


<tr>

<td>

<?= htmlspecialchars($page['title']); ?>

</td>


<td>

<?= htmlspecialchars($page['slug']); ?>

</td>


<td>

<?= htmlspecialchars($page['status']); ?>

</td>


<td>


<a href="/admin/pages/edit?id=<?= $page['id']; ?>"
class="blue-button">

Edit

</a>



<form action="/admin/pages/delete"
method="POST"
style="display:inline;">

<input
    type="hidden"
    name="csrf_token"
    value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>"
>

<input 
type="hidden"
name="id"
value="<?= $page['id']; ?>">



<button 
class="red-button"
onclick="return confirm('Are you sure you want to delete this page?');">

Delete

</button>


</form>


</td>


</tr>


<?php endforeach; ?>


</tbody>


</table>


<?php endif; ?>
</div>