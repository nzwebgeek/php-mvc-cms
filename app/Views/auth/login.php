<main>
    <section>
        <h1>Login</h1>

        <?php if (!empty($message)): ?>
            <div class="alert <?= htmlspecialchars($messageType) ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <form action="/login" method="post">

            <label for="username">Username</label>

        <input
            type="hidden"
            name="csrf_token"
            value="<?= htmlspecialchars(
                $csrfToken,
                ENT_QUOTES,
                'UTF-8'
            ) ?>"
        >
                
         <input
                type="text"
                id="username"
                name="username"
                value="<?= htmlspecialchars($username ?? '') ?>"
                placeholder="Your username..."
                required
            >

            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                placeholder="Your password..."
                required
            >

            <input type="submit" value="Login">

            <p>
                <a href="/forgot-password">
                    Forgot your password?
                </a>
            </p>

        </form>

    </section>
</main>