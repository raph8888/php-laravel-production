<?php
$servername = "mysqlv114";
$username = "copiadoramoc";
$password = "Copiadoramoc88";
$dbname = "copiadoramoc";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}
?>