<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        <?= htmlspecialchars($title ?? 'Admin') ?>
    </title>


    <link rel="stylesheet" href="/assets/css/admin.css">

</head>


<body>

<header class="admin-header">

    <div class="admin-logo">
        CMS Admin
    </div>


    <div class="admin-user">

        Welcome,
        <?= htmlspecialchars($_SESSION['username'] ?? 'Admin') ?>


        <a href="/logout">
            Logout
        </a>

    </div>


</header>