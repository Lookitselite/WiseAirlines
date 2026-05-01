<?php
session_start();
if(isset($_SESSION['logstatus'])) {
    header("Location:../index.php");
    exit;
}
?>