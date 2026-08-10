```php
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?= $title ?? 'Admin Dashboard'; ?></title>

<link rel="stylesheet" href="/assets/css/admin.css">

<header class="admin-header">

    <div class="admin-header-left">

        <button
            type="button"
            class="admin-menu-toggle"
            id="adminMenuToggle"
            aria-label="Open navigation menu"
            aria-expanded="false"
            aria-controls="adminSidebar"
        >
            <span></span>
            <span></span>
            <span></span>
        </button>

        <div class="admin-logo">
            Admin Dashboard
        </div>

    </div>


    <div class="admin-user">

        <?php if (isset($user)): ?>

            <span>
                <?= htmlspecialchars($user['username']) ?>
            </span>

        <?php endif; ?>

    </div>

</header>


<div
    class="admin-sidebar-overlay"
    id="adminSidebarOverlay"
></div>
```
