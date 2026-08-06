<h1>
    Manage Pages
</h1>


<a href="/admin/pages/create"
class="btn btn-primary mb-3">

Create New Page

</a>


<?php if(empty($pages)): ?>

<div class="alert alert-info">

No pages found.

</div>


<?php else: ?>


<table class="table table-bordered">


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
class="btn btn-warning btn-sm">

Edit

</a>



<form action="/admin/pages/delete"
method="POST"
style="display:inline;">


<input 
type="hidden"
name="id"
value="<?= $page['id']; ?>">



<button 
class="btn btn-danger btn-sm">

Delete

</button>


</form>


</td>


</tr>


<?php endforeach; ?>


</tbody>


</table>


<?php endif; ?>