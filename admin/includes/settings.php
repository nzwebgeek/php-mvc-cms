
/*settings loader*/
<?php

$result = $conn->query("SELECT * FROM site_settings WHERE id = 1");

$settings = $result->fetch_assoc();