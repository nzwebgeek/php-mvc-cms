<?php

require 'app/Core/Database.php';

use App\Core\Database;

$db = Database::connect();

echo "Connected!";