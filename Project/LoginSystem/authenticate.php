<?php
session_start();

include('/home/apw1043/p/dhb.inc');
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

    if ($row['adminStatus'] === 1) { 
        $equery = $connect->prepare("SELECT role FROM employees WHERE employee_id=?");
        $equery->bind_param("i", $row['account_id']);
        $equery->execute(); 
        $eresult = $equery->get_result();
        
        $erow = $eresult->fetch_assoc();
        $_SESSION['role'] = $erow['role'];
        
        $equery->close();
    }

    $_SESSION['id'] = $row['account_id'];
    $_SESSION['logstatus'] = TRUE;
    header("Location:welcome.php");
    exit();
} else {
    header("Location:signin.php");
    exit();
}
$connect->close();
?>


