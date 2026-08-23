<main>

    <section>

        <h1>Forgot your password?</h1>

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

        <p>
            Enter your email address and, if an account exists,
            we will send you a password reset link.
        </p>

        <form action="/forgot-password" method="post">

            <input
                type="hidden"
                name="csrf_token"
                value="<?= htmlspecialchars(
                    $csrfToken ?? '',
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>"
            >

            <label for="email">
                Email
            </label>

            <input
                type="email"
                id="email"
                name="email"
                value="<?= htmlspecialchars(
                    $email ?? '',
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>"
                placeholder="Your email address..."
                required
            >

            <input
                type="submit"
                value="Send Reset Link"
            >

            <p>
                <a href="/login">
                    Back to login
                </a>
            </p>

        </form>

    </section>

</main>