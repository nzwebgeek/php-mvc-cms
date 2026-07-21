<?php
require '../includes/db.php';
// Select User
$stmt = $conn->prepare("SELECT COUNT(*) AS total FROM users");
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();

$total_users = $row['total'];

// Select Pages
$stmt = $conn->prepare("SELECT COUNT(*) AS total FROM pages");
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();

$total_pages = $row['total'];

// Select Posts
$stmt = $conn->prepare("SELECT COUNT(*) AS total FROM posts");
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();

$total_posts = $row['total'];
// Example data (replace with database queries)


$totalComments = 14;
$todayVisitors = 542;


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background:#f5f6fa;
        }

        .card{
            border:none;
            border-radius:10px;
            box-shadow:0 2px 8px rgba(0,0,0,.08);
        }

        .stat{
            font-size:30px;
            font-weight:bold;
        }
    </style>
</head>
<body>

<div class="container py-4">

    <h2 class="mb-4">Admin Dashboard</h2>

    <div class="row g-4">

        <div class="col-md-3">
            <div class="card text-center p-3">
                <h6>Total Users</h6>
                <div class="stat"><?= $total_users ?></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center p-3">
                <h6>Total Pages</h6>
                <div class="stat"><?= $total_pages  ?></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center p-3">
                <h6>Total Posts</h6>
                <div class="stat"><?= $total_posts ?></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center p-3">
                <h6>Pending Comments</h6>
                <div class="stat"><?= $totalComments ?></div>
            </div>
        </div>

    </div>

    <div class="row mt-4">

        <div class="col-lg-8">

            <div class="card p-3">

                <h4>Recent Activity</h4>

                <table class="table table-striped mt-3">
                    <thead>
                    <tr>
                        <th>Time</th>
                        <th>User</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>09:30</td>
                            <td>Admin</td>
                            <td>Created Homepage</td>
                        </tr>

                        <tr>
                            <td>09:10</td>
                            <td>John</td>
                            <td>Uploaded banner.jpg</td>
                        </tr>

                        <tr>
                            <td>08:45</td>
                            <td>Admin</td>
                            <td>Updated Contact Page</td>
                        </tr>
                    </tbody>

                </table>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="card p-3">

                <h4>Quick Actions</h4>

                <div class="d-grid gap-2 mt-3">

                    <a href="index.php?page=create-page" class="btn btn-primary">New Page</a>

                    <a href="index.php?page=create-post" class="btn btn-success">New Post</a>

                    <a href="index.php?page=create-user" class="btn btn-warning">Add User</a>

                    <a href="index.php?page=media" class="btn btn-info">Upload Media</a>

                    <a href="index.php?page=settings" class="btn btn-secondary">Settings</a>

                </div>

            </div>

            <div class="card p-3 mt-4">

                <h4>Website Stats</h4>

                <hr>

                <p><strong>Visitors Today:</strong> <?= $todayVisitors ?></p>

                <p><strong>Disk Usage:</strong> 41%</p>

                <p><strong>PHP Version:</strong> <?= phpversion(); ?></p>

                <p><strong>Server Time:</strong> <?= date("d M Y H:i"); ?></p>

            </div>

        </div>

    </div>

</div>

</body>
</html>