<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
session_start();
include_once "../libs/students.php";
connect_db();

$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$role = mysqli_real_escape_string($conn, $_POST['role']);

$check = mysqli_real_escape_string($conn, $_POST['rem']);

if (!empty($username) && !empty($password) && !empty($role)) {
    // echo($role);
    $sql = mysqli_query($conn, "SELECT * FROM profile WHERE taikhoan = '{$username}' AND role = '{$role}'");
    if (mysqli_num_rows($sql) > 0) {
        $row = mysqli_fetch_assoc($sql);
        $user_pass = md5($password);
        $enc_pass = $row['matkhau'];

        if ($user_pass === $enc_pass) {
            $status = "Active now"; # Set status online
            $sql2 = mysqli_query($conn, "UPDATE profile SET status = '{$status}' WHERE unique_id = {$row['unique_id']}");
            if ($sql2) {

                if ($check == "true") {
                    // setcookie('id', '', time() - 3600);
                    // setcookie('ID', '', time() - 3600);
                    // setcookie('idddd', '', time() - 3600);

                    setcookie('id', $row['unique_id'], time() + 3600, '/');                   
                }
                $_SESSION['unique_id'] = $row['unique_id'];
                $_SESSION['id'] = $row['id'];
                $_SESSION['role'] = $role;

                $sub_query = "
				INSERT INTO login_details 
	     		(user_id) 
	     		VALUES ('" . $row['id'] . "')
				";

                $sql_query = mysqli_query($conn, $sub_query);
                $_SESSION['login_details_id'] = mysqli_insert_id($conn);

                if ($role === "1") {
                    echo "admin";
                } else if ($role === "2") {
                    echo "supervisor";
                } else if ($role === "3") {
                    echo "user";
                }
            } else {
                echo "Something went wrong. Please try again!";
            }
        } else {
            echo "Username or Password is Incorrect!";
        }
    } else {
        echo "$username - This username does not Exist!";
    }
} else {
    echo "All input fields are required!";
}
