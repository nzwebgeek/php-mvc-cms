<main>

<section>

<h1>Register</h1>

<?php if (!empty($message)): ?>
    <p>
        <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>
    </p>
<?php endif; ?>


<form method="post">

<label for="username">Username</label>
<input 
    type="text" 
    id="username" 
    name="username"
    value="<?= htmlspecialchars($username ?? '') ?>"
    required
>


<label for="email">Email</label>
<input 
    type="email" 
    id="email" 
    name="email"
    value="<?= htmlspecialchars($email ?? '') ?>"
    required
>


<label for="password">Password</label>
<input 
    type="password" 
    id="password" 
    name="password"
    required
>


<label for="confirm_password">Confirm Password</label>
<input 
    type="password" 
    id="confirm_password" 
    name="confirm_password"
    required
>


<input type="submit" value="Register">

</form>


<button id="toggleBtn">
    Change Color
</button>


</section>

</main>