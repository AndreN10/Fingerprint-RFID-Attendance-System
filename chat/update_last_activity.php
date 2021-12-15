<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

session_start();
include_once "../libs/students.php";
connect_db();
if(!isset($_SESSION['unique_id'])){
header("location: ../index.php");
}


//update_last_activity.php

$last_activity = date("Y-m-d H:i:s"); 

$query = "
UPDATE login_details 
SET last_activity = '$last_activity' 
WHERE login_details_id = '".$_SESSION["login_details_id"]."'
";
// $sql_query = mysqli_query($conn,$sub_query);
$statement = $conn->prepare($query);

$statement->execute();


// echo($last_activity);

?>

