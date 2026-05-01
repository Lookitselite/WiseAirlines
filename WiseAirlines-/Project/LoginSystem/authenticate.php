<?php
session_start();

include('/home/tr1158/p/secret.php');
// Connect to MySQL
$connect = mysqli_connect($db_server,$user,$password,$db_names); 


// Connection error check
if ($connect->connect_error) {
    die("Could not connect: " . $connect->connect_error);
}

// We need our information from the 
$query = $connect->prepare("Select account_id, username, password, adminStatus from accounts where username=? and password=?");
$username = $_SESSION['username'];
$password = $_SESSION['password'];
$query->bind_param("ss", $username, $password);
$query->execute();
$result = $query->get_result();

if ($result->num_rows>0) {
    $row = $result->fetch_assoc();

    $_SESSION['adminStatus'] = 0;

    if ($row['adminStatus'] === 1) {
        $equery = $connect->prepare("Select role from employees where employee_id=?");
        $equery->bind_param("i", $row['account_id']);
        $query->execute();
        $result = $query->get_result();
        $_SESSION['employeeRole'] = $result;
        $_SESSION['adminStatus'] = 1;
    }

    $_SESSION['id'] = $row['account_id'];
    $_SESSION['logstatus'] = TRUE;

    header("Location:welcome.php");
} else {
    header("Location:signin.php");
    exit();
}
$connect->close();



