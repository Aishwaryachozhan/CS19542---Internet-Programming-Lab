<?php
$host = 'localhost';
$db = 'job_portal';
$user = 'root';
$pass = 'valli';

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

