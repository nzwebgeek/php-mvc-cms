<div class="admin-card">

    <h1>
        Create User
    </h1>

    <a class="blue-button" href="/admin/users">
        ← Back to Users
    </a>

    <form method="POST" action="/admin/users/create">

        <div class="form-group">

            <label for="username">
                Username
            </label>

            <input
                type="text"
                id="username"
                name="username"
                required
            >

        </div>


        <div class="form-group">

            <label for="email">
                Email
            </label>

            <input
                type="email"
                id="email"
                name="email"
                required
            >

        </div>


        <div class="form-group">

            <label for="password">
                Password
            </label>

            <input
                type="password"
                id="password"
                name="password"
                required
            >

        </div>


        <div class="form-group">

            <label for="role">
                Role
            </label>

            <select id="role" name="role">

                <option value="User">
                    User
                </option>

                <option value="Admin">
                    Admin
                </option>

                <option value="Super Admin">
                    Super Admin
                </option>

            </select>

        </div>


        <button
            class="green-button"
            type="submit"
        >
            Create User
        </button>

    </form>

</div>