<?php

require_once __DIR__ . '/db.php';

$stmt = $conn->prepare("SELECT * FROM site_settings WHERE id = 1");
$stmt->execute();

$result = $stmt->get_result();

$settings = $result->fetch_assoc();
/*This creates a reusable $settings array.*/