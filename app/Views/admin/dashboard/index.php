<div class="admin-card">

<h1>
Admin Dashboard
</h1>


<p>
Welcome to the CMS administration area.
</p>


</div>



<div class="admin-stats">


<div class="stat-card">

<h2>
<?= $stats['users'] ?>
</h2>

<p>
Total Users
</p>

</div>



<div class="stat-card">

<h2>
<?= $stats['pages'] ?>
</h2>

<p>
Total Pages
</p>

</div>



<div class="stat-card">

<h2>
<?= $stats['posts'] ?>
</h2>

<p>
Total Posts
</p>

</div>



<div class="stat-card">

<h2>
<?= $stats['comments'] ?>
</h2>

<p>
Pending Comments
</p>
</div>

</div>

<!-- RECENT ACTIVITY -->

<div class="admin-card">

<h2>
Recent Activity
</h2>


<table class="admin-table">

<thead>

<tr>

<th>
Time
</th>

<th>
User
</th>

<th>
Action
</th>

</tr>

</thead>


<tbody>


<?php if(empty($activity)): ?>

<tr>

<td colspan="3">
No recent activity found.
</td>

</tr>


<?php else: ?>


<?php foreach($activity as $item): ?>


<tr>

<td>

<?= date(
    'd M Y, H:i',
    strtotime($item['created_at'])
) ?>

</td>


<td>

<?= htmlspecialchars(
    $item['username'] ?? 'System'
) ?>

</td>


<td>

<?= htmlspecialchars(
    $item['action']
) ?>

</td>


</tr>


<?php endforeach; ?>


<?php endif; ?>


</tbody>

</table>


</div>