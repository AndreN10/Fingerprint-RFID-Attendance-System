<?php // Sending message 
    session_start();
    include_once "../../libs/students.php";
    
    if(isset($_SESSION['unique_id'])){
        // include_once "config.php";
        connect_db();
        $outgoing_id = $_SESSION['unique_id'];
        $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
        $message = mysqli_real_escape_string($conn, $_POST['message']);

        
        $h = date('H');
        $mi = date('i');
        $s = date('s');
        $d = date('d');
        $m = date('m');
        $y = date('Y');
        $timeint = mktime($h, $mi, $s, $m, $d , $y);
        $date = date('d/m/Y-H:i:s',$timeint);

        if(!empty($message)){
            $sql = mysqli_query($conn, "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg, timestamp)
                                        VALUES ({$incoming_id}, {$outgoing_id}, '{$message}', '{$date}')") or die();
        }
    }else{
        header("location: ../../index.php");
    }


    
?>