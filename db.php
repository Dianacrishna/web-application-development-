<?php

// Create database connection object

$conn = new mysqli("localhost", "root", "", "workshop_db");

// Check connection

if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);

}
?>
