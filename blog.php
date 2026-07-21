<?php

require 'includes/db.php';
require 'includes/settings.php';
require 'helpers/helper.php';
require 'helpers/admin-helper.php';

include 'includes/header.php';

?>

<main class="blog-container">

<h1>Comments Section</h1>

<p>
    <strong>Start a comment here:</strong>
    Feel free to leave a comment, but make sure to register first.
</p>

<div class="comment-content-box">
  
  <?php blogImages($conn); ?>
  

</div>

<div class="wrapper">
    <?php blogPosts($conn); ?>
</div>


</main>

<?php include 'includes/footer.php'; ?>