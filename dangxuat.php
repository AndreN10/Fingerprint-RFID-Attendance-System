
<?php
session_start();

$_SESSION = array();
// setcookie('id', '', time() - 3600);
//     setcookie('ID', '', time() - 3600);
if (isset($_COOKIE['id'])) {
    unset($_COOKIE['remember_user']);
    setcookie('id', null, -1, '/'); 
    
    // include_once "config.php";
    // $logout_id = mysqli_real_escape_string($conn, $_GET['logout_id']);
    // if(isset($logout_id)){
    //     $status = "Offline now";
    //     $sql = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id={$_GET['logout_id']}");
    //     if($sql){
    // session_unset();
    // session_destroy();
    session_destroy();
    header("location: index.php");
    // }
    // }else{
    //     header("location: ../users.php");
    // }
} else {
    session_destroy();
    header("location: index.php");
}
?>