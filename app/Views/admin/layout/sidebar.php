```php
<aside class="admin-sidebar" id="adminSidebar">

    <nav>

        <a href="/">
            ← View Public Site
        </a>


        <a href="/admin">
            Dashboard
        </a>


        <a href="/admin/users">
            Users
        </a>


        <a href="/admin/roles">
            Roles
        </a>


        <a href="/admin/posts">
            Posts
        </a>


        <a href="/admin/pages">
            Pages
        </a>


        <a href="/admin/comments">
            Comments
        </a>


        <a href="/admin/media">
            Media
        </a>


        <a href="/admin/settings">
            Settings
        </a>


    <form method="POST" action="/logout" class="admin-logout-form">
    <input
        type="hidden"
        name="csrf_token"
        value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>"
    >

    <button type="submit" class="admin-logout-button">
        Logout
    </button>
</form>
    </nav>

</aside>


<main class="admin-content">
```
