<?php
// for LOCAL SERVER setup
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "epiz_33155713_treasury";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}