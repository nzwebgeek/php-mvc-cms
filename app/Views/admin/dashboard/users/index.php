<div class="admin-card">


    <!-- Success Alert -->
    <?php if (!empty($_SESSION['success'])): ?>

        <div class="alert-success">

            <?= htmlspecialchars($_SESSION['success']); ?>

        </div>


        <?php unset($_SESSION['success']); ?>


    <?php endif; ?>



    <h1>
        Users
    </h1>


    <a class="green-button" href="/admin/users/create">
        + Add User
    </a>


</div>





<div class="admin-card">


    <table class="admin-table">


        <thead>

            <tr>

                <th>
                    Username
                </th>


                <th>
                    Email
                </th>


                <th>
                    Role
                </th>


                <th>
                    Status
                </th>


                <th>
                    Actions
                </th>

            </tr>


        </thead>





        <tbody>


        <?php foreach ($users as $user): ?>


            <tr>


                <td>
                    <?= htmlspecialchars($user['username']) ?>
                </td>



                <td>
                    <?= htmlspecialchars($user['email']) ?>
                </td>



                <td>
                    <?= htmlspecialchars($user['role'] ?? 'User') ?>
                </td>





                <td>


                    <?php if (!empty($user['email_verified'])): ?>


                        <span class="status verified">
                            Verified
                        </span>


                    <?php else: ?>


                        <span class="status pending">
                            Pending
                        </span>


                    <?php endif; ?>


                </td>





                <td class="actions">


                    <a 
                    class="blue-button" 
                    href="/admin/users/edit?id=<?= $user['id'] ?>">
                        Edit
                    </a>





                    <?php if ($user['id'] != ($_SESSION['user_id'] ?? 0)): ?>



                        <form 
                        method="POST" 
                        action="/admin/users/delete">


                            <input 
                            type="hidden"
                            name="id"
                            value="<?= $user['id'] ?>">



                            <button 
                            class="red-button"
                            type="submit"
                            onclick="return confirm('Delete this user?');">

                                Delete

                            </button>



                        </form>



                    <?php else: ?>



                        <span class="green-button">

                            Current User

                        </span>



                    <?php endif; ?>



                </td>



            </tr>



        <?php endforeach; ?>



        </tbody>



    </table>



</div>