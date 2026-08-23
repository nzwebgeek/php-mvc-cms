<main>

    <section>

        <h1>Reset your password</h1>

        <?php if (!empty($message)): ?>

            <div class="alert <?= htmlspecialchars(
                $messageType ?? '',
                ENT_QUOTES,
                'UTF-8'
            ) ?>">
                <?= htmlspecialchars(
                    $message,
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>
            </div>

        <?php endif; ?>

        <form action="/reset-password" method="post">

            <input
                type="hidden"
                name="csrf_token"
                value="<?= htmlspecialchars(
                    $csrfToken ?? '',
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>"
            >

            <input
                type="hidden"
                name="token"
                value="<?= htmlspecialchars(
                    $token ?? '',
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>"
            >

            <label for="password">
                New Password
            </label>

            <input
                type="password"
                id="password"
                name="password"
                placeholder="Enter your new password..."
                required
            >

            <label for="confirm_password">
                Confirm New Password
            </label>

            <input
                type="password"
                id="confirm_password"
                name="confirm_password"
                placeholder="Confirm your new password..."
                required
            >

            <input
                type="submit"
                value="Reset Password"
            >

            <p>
                <a href="/login">
                    Back to login
                </a>
            </p>

        </form>

    </section>

</main>