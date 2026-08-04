<aside class="sidebar">


    <div class="profile-card">


        <?php if (!empty($user['filepath'])): ?>


            <img
                src="<?= htmlspecialchars($user['filepath']) ?>"
                class="profile-image"
                alt="<?= htmlspecialchars($user['username']) ?>'s profile image"
            >


        <?php else: ?>


            <div class="profile-placeholder">
                No Image
            </div>


        <?php endif; ?>



        <h3>
            <?= htmlspecialchars($user['username']) ?>
        </h3>

    </div>

    <nav class="dashboard-menu">


        <a href="/dashboard?panel=posts">
            📝 Edit Posts
        </a>



        <a href="/dashboard?panel=password">
            🔒 Change Password
        </a>



        <a href="/dashboard?panel=upload">
            🖼 Upload Image
        </a>



        <a href="/dashboard?panel=theme">
            🎨 Theme Colours
        </a>

          <?php if (
            in_array(
                strtolower($user['role'] ?? ''),
                ['admin','super admin'],
                true
            )
        ): ?>

        <a href="/admin">
            ⚙ Admin Panel
        </a>

<?php endif; ?>
        <a href="/logout">
            🚪 Logout
        </a>


    </nav>


</aside>