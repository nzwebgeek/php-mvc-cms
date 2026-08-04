<div class="admin-card">


    <h1>
        Create User
    </h1>


    <a class="blue-button" href="/admin/users">
        ← Back to Users
    </a>


</div>





<div class="admin-card">


<form method="POST" action="/admin/users/create">



    <div class="form-group">

        <label>
            Username
        </label>


        <input 
        type="text"
        name="username"
        required>

    </div>





    <div class="form-group">

        <label>
            Email
        </label>


        <input 
        type="email"
        name="email"
        required>

    </div>





    <div class="form-group">

        <label>
            Password
        </label>


        <input 
        type="password"
        name="password"
        required>

    </div>





    <div class="form-group">

        <label>
            Role
        </label>


        <select name="role">


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
    type="submit">

        Create User

    </button>



</form>


</div>