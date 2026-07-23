<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database configuration
$host = "localhost";      // Database host
$dbname = "test3_db";      // Database name
$username = "root";       // Database username
$password = "";           // Database password


// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check if connection error exists
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//echo "Connected successfully";