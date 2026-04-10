<?php
session_start();

include dirname(__DIR__) . '/P/pass.php';
// Connect to MySQL
$connect = new mysqli($hostname, $user, $passcode, $database);


// Connection error check
if ($connect->connect_error) {
    die("Could not connect: " . $connect->connect_error);
}

// We need our information from the 
$query = $connect->prepare("Select id, username, password from accounts where username=? and password=?");
$username = $_SESSION['username'];
$password = $_SESSION['password'];
$query->bind_param("ss", $username, $password);
$query->execute();
$result = $query->get_result();

if ($result->num_rows>0) {
    $row = $result->fetch_assoc();

    $_SESSION['id'] = $row['id'];
    $_SESSION['logstatus'] = TRUE;
    header("Location:welcome.php");
} else {
    header("Location:signin.php");
}
$connect->close();



