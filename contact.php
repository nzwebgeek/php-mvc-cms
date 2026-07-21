<?php

require 'includes/db.php';
require 'includes/settings.php';
require 'helpers/helper.php';

include 'includes/header.php';

?>



<main>
<!-- A generic thematic grouping of content -->
    <section>
    <h1>Contact Us</h1>
      
      <form action="" method="post">
        <label for="fname">First Name</label>
        <input type="text" id="fname" name="fname" placeholder="Your first name.." required>

        <label for="lname">Last Name</label>
        <input type="text" id="lname" name="lname" placeholder="Your last name.." required>

        
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Your email.." required>
        
        
        <label for="country">Country</label>
        <select id="country" name="country" required>
            <option value="australia">Australia</option>
            <option value="canada">Canada</option>
            <option value="usa">USA</option>
            <option value="new zealand">New Zealand</option>
            <option value="uk">U.K</option>

  </select>
  <label for="textarea">Feedback Below</label>
  <textarea name="message" id="" cols="50" rows="8"></textarea>
  
  <input type="submit" value="Submit" name="submit">

</form>
          <button id="toggleBtn">Change Color</button>

    </section>
</main>

<?php
if(isset($_POST['submit'])) {
    // Sanitize and validate inputs
    $fname = filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lname = filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);    
    $country = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_SPECIAL_CHARS);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Set email parameters
    $to = "fabricflannigan@gmail.com"; // Change to your desired recipient email
    $subject = "New Contact Form Submission from $fname $lname";
    
    $body = "First Name: $fname\n";
    $body .= "Last Name: $lname\n\n";
    $body .= "Country: $country\n\n";
    $body .= "Message:\n$message";

    // Set headers
    $headers = "From: $email" . "\r\n" .
               "Reply-To: $email" . "\r\n" .
               "X-Mailer: PHP/" . phpversion();

    // Send the email and check status
    if(mail($to, $subject, $body, $headers)) {
        echo "Email successfully sent! Check your Mailpit dashboard.";
    } else {
        echo "Failed to send email.";
    }
}
?>



<?php include 'includes/footer.php'; ?>