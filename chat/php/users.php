<?php
    date_default_timezone_set('Asia/Ho_Chi_Minh');

    session_start();
    include_once "../../libs/students.php";
	connect_db();

    if(isset($_SESSION['unique_id'])) {
        $outgoing_id = $_SESSION['unique_id'];
        $sql = "SELECT * FROM profile WHERE NOT unique_id = {$outgoing_id} ORDER BY id ASC";
        $query = mysqli_query($conn, $sql);
        $output = "";
        if(mysqli_num_rows($query) == 0){
            $output .= "No users are available to chat";
        }elseif(mysqli_num_rows($query) > 0){
            include_once "data.php";
        }
        echo $output;
        

        $sql2 = "SELECT * FROM profile WHERE NOT unique_id = {$outgoing_id} ORDER BY id ASC";
        $query2 = mysqli_query($conn, $sql2);


        if (mysqli_num_rows($query2) > 0) {
            while($row = mysqli_fetch_assoc($query2)) {
                $status = '';
                $current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
                $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
                $user_last_activity = fetch_user_last_activity($row['id'], $conn);
                // echo($row['lname']);
                // echo("<br>");
                // echo("Current time: $current_timestamp");
                // echo("<br>");
                // echo("last activity: $user_last_activity");
                // echo("<br>");
                // echo($row['status']);
                // echo("<br>");

                if($user_last_activity > $current_timestamp)
                    {   
                        $status = 'Active Now';
                        $sql3 = mysqli_query($conn, "UPDATE profile SET status = '{$status}' WHERE id={$row['id']}");
                        $query3 = mysqli_query($conn, $sql3);

                    }
                    else
                    {
                        $status = 'Offline now';
                        $sql3 = mysqli_query($conn, "UPDATE profile SET status = '{$status}' WHERE id={$row['id']}");
                        $query3 = mysqli_query($conn, $sql3);
                    }
            }
            
            
        }
    
    } else {
        echo("Oops, there's a problem");
    }
    

   

    
?>