<?php
require './libs/students.php';
 
// Thực hiện xóa
$uid = isset($_POST['uid']) ? (int)$_POST['uid'] : '';
$id = isset($_POST['id']) ? (int)$_POST['id'] : '';

// echo($uid);
// echo($id);


$stt =isset($_POST['stt']) ? (int)$_POST['stt'] : '';
$sttcmt =isset($_POST['sttcmt']) ? (int)$_POST['sttcmt'] : '';

// echo($id);

// if ($stt){
// 	connect_db();

//  	$sql = "delete from giamsat where stt = $stt";
// 	$query = mysqli_query($conn, $sql);
// // 	disconnect_db();
// 	header("location: show.php");
// }


if ($uid){
    

	$data = get_student($uid);

    $image = $data['img'];

    if ($image != 'user.png') {
        unlink("images/$image");
    } 

	delete_student($uid);
	
	$sql1 = "delete from tongket where id = $id";
	$query1 = mysqli_query($conn, $sql1);

	$sql2 = "delete from giamsat where id = $id";
	$query2 = mysqli_query($conn, $sql2);

	$sql3 = "delete from messages where outgoing_msg_id = $uid or incoming_msg_id = $uid";
	$query3 = mysqli_query($conn, $sql3);
	header("location: student-list.php");
    
}
else
	header("location: student-list.php");
?>