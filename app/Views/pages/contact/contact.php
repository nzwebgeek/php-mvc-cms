<main>
    <section>
        <h1>Contact Us</h1>

        <?php if (!empty($success)): ?>
            <p class="success"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form action="/contact" method="post">

            <label for="fname">First Name</label>
            <input type="text" id="fname" name="fname" required>

            <label for="lname">Last Name</label>
            <input type="text" id="lname" name="lname" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="country">Country</label>
            <select id="country" name="country">
                <option>Australia</option>
                <option>Canada</option>
                <option>USA</option>
                <option>New Zealand</option>
                <option>U.K</option>
            </select>

            <label for="message">Feedback Below</label>
            <textarea id="message" name="message" rows="8"></textarea>

            <input type="submit" value="Submit">

        </form>

        <button id="toggleBtn">Change Color</button>

    </section>
</main>