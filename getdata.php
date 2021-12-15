<?php  
//Connect to database
require './libs/students.php';
connect_db();
date_default_timezone_set('Asia/Ho_Chi_Minh');
$d = date("Y-m-d");
$t = date("H:i:s");


$gio = date('H');
$phut = date('i');
$giay = date('s');
$ngay = date('d');
$gioint = mktime($gio, $phut, $giay, 0, 0, 0);


if (isset($_GET['FingerID']) && isset($_GET['device_token']) && $_GET['FingerID'] != 0) {
    
    $fingerID = $_GET['FingerID'];
    $device_uid = $_GET['device_token'];

    $sql = "SELECT * FROM devices WHERE device_uid=?";
    $result = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($result, $sql)) {
        echo "SQL_Error_Select_device";
        exit();
    }
    else{
        mysqli_stmt_bind_param($result, "s", $device_uid);
        mysqli_stmt_execute($result);
        $resultl = mysqli_stmt_get_result($result);
        if ($row = mysqli_fetch_assoc($resultl)){
            $device_mode = $row['device_mode'];
            $device_dep = $row['device_dep'];
            if ($device_mode == 1) {
                $sql = "SELECT * FROM profile WHERE id=? AND device_uid=?";
                $result = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($result, $sql)) {
                    echo "SQL_Error_Select_card";
                    exit();
                }
                else{
                    mysqli_stmt_bind_param($result, "ss", $fingerID, $device_uid);
                    mysqli_stmt_execute($result);
                    $resultl = mysqli_stmt_get_result($result);
                    if ($row = mysqli_fetch_assoc($resultl)){
                        //*****************************************************
                        //An existed fingerprint has been detected for Login or Logout
                        if ($row['fname'] != "None" && $row['add_fingerid'] == 0){
                            $Uname = $row['fname'];
                            $lname = $row['lname'];
                            $Number = $row['mssv'];
                            $card_uid = $row['card_uid'];
                            
                            
                            $sql = "SELECT * FROM giamsat WHERE id=? AND checkindate=? AND timeout=''";
                            $result = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($result, $sql)) {
                                echo "SQL_Error_Select_logs";
                                exit();
                            }
                            else{
                                mysqli_stmt_bind_param($result, "ss", $fingerID, $d);
                                mysqli_stmt_execute($result);
                                $resultl = mysqli_stmt_get_result($result);
                                //*****************************************************
                                //Login
                                if (!$row = mysqli_fetch_assoc($resultl)){
                                    // echo($Uname);  echo('<br>');
                                    // echo($Number); echo('<br>');
                                    // echo($fingerID); echo('<br>');
                                    // echo($device_uid); echo('<br>');
                                    // echo($device_dep); echo('<br>');
                                    // echo($d); echo('<br>');
                                    // echo($t); echo('<br>');
                                    // echo($timeout); echo('<br>');
                                    
                                    
                                    

                                    $sql = "INSERT INTO giamsat (ten, lname, mssv, id, device_uid, device_dep,checkindate, timein, timeout, card_uid) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                                    $result = mysqli_stmt_init($conn);
                                    if (!mysqli_stmt_prepare($result, $sql)) {
                                        echo "SQL_Error_Select_login1";
                                        exit();
                                    }
                                    else{
                                        $timeout = "00:00:00";
                                        mysqli_stmt_bind_param($result, "ssdissssss", $Uname, $lname, $Number, $fingerID, $device_uid, $device_dep, $d, $t, $timeout, $card_uid);
                                        mysqli_stmt_execute($result);

                                        echo "login".$Uname;
                                        exit();
                                    }
                                }
                                //*****************************************************
                                //Logout
                                else{
                                    
                                     //

                                    $sql = "UPDATE tongket   SET presentcount = presentcount+1  WHERE id = $fingerID ";

                                    $query = mysqli_query($conn, $sql);
                                    //
                                    
                                    
                                    $sql="UPDATE giamsat SET card_out=1, timeout=?, fingerout=1 WHERE id=? AND checkindate=? AND fingerout=0";
                                    $result = mysqli_stmt_init($conn);
                                    if (!mysqli_stmt_prepare($result, $sql)) {
                                        echo "SQL_Error_insert_logout1";
                                        exit();
                                    }
                                    else{
                                        mysqli_stmt_bind_param($result, "sis", $t, $fingerID, $d);
                                        mysqli_stmt_execute($result);

                                        echo "logout".$Uname;
                                        exit();
                                    }
                                }
                            }
                        }
                        else{
                            echo "Not registerd!";
                            exit();
                        }
                    }
                    else{
                        echo "Not found!";
                        exit();
                    }
                }
            }
            else if ($device_mode == 0) {
                //New Fingerprint has been added
                $sql = "SELECT * FROM profile WHERE id=? AND device_uid=?";
                $result = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($result, $sql)) {
                    echo "SQL_Error_Select_card";
                    exit();
                }
                else{
                    mysqli_stmt_bind_param($result, "ss", $fingerID, $device_uid);
                    mysqli_stmt_execute($result);
                    $resultl = mysqli_stmt_get_result($result);
                    if ($row = mysqli_fetch_assoc($resultl)){
                        echo "available";
                        exit();
                    }
                    else{
                        $sql = "INSERT INTO profile ( device_uid, device_dep, id, user_date, add_fingerid) VALUES (?, ?, ?, CURDATE(), 0)";
                        $result = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($result, $sql)) {
                            echo "SQL_Error_Select_add";
                            exit();
                        }
                        else{
                            mysqli_stmt_bind_param($result, "sss", $device_uid, $device_dep, $fingerID );
                            mysqli_stmt_execute($result);

                            echo "succesful";
                            exit();
                        }
                    }
                }    
            }
        }
        else{
            echo "Invalid Device!";
            exit();
        }
    }          
}
if (isset($_GET['Get_Fingerid']) && isset($_GET['device_token'])) {
    
    $device_uid = $_GET['device_token'];

    $sql = "SELECT * FROM devices WHERE device_uid=?";
    $result = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($result, $sql)) {
        echo "SQL_Error_Select_device";
        exit();
    }
    else{
        mysqli_stmt_bind_param($result, "s", $device_uid);
        mysqli_stmt_execute($result);
        $resultl = mysqli_stmt_get_result($result);
        if ($row = mysqli_fetch_assoc($resultl)){

            if ($_GET['Get_Fingerid'] == "get_id") {
                $sql= "SELECT id FROM profile WHERE add_fingerid=1 AND device_uid=? LIMIT 1";
                $result = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($result, $sql)) {
                    echo "SQL_Error_Select";
                    exit();
                }
                else{
                    mysqli_stmt_bind_param($result, "s", $device_uid);
                    mysqli_stmt_execute($result);
                    $resultl = mysqli_stmt_get_result($result);
                    if ($row = mysqli_fetch_assoc($resultl)) {
                        echo "add-id".$row['id'];
                        exit();
                    }
                    else{
                        echo "Nothing";
                        exit();
                    }
                }
            }
            else{
                exit();
            }
        }
        else{
            echo "Invalid Device";
            exit();
        }
    }
}
if (isset($_GET['Check_mode']) && isset($_GET['device_token'])) {
    
    $device_uid = $_GET['device_token'];

    $sql = "SELECT * FROM devices WHERE device_uid=?";
    $result = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($result, $sql)) {
        echo "SQL_Error_Select_device";
        exit();
    }
    else{
        mysqli_stmt_bind_param($result, "s", $device_uid);
        mysqli_stmt_execute($result);
        $resultl = mysqli_stmt_get_result($result);
        if ($row = mysqli_fetch_assoc($resultl)){
            if ($_GET['Check_mode'] == "get_mode") {
                $sql= "SELECT device_mode FROM devices WHERE device_uid=?";
                $result = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($result, $sql)) {
                    echo "SQL_Error_Select";
                    exit();
                }
                else{
                    mysqli_stmt_bind_param($result, "s", $device_uid);
                    mysqli_stmt_execute($result);
                    $resultl = mysqli_stmt_get_result($result);
                    if ($row = mysqli_fetch_assoc($resultl)) {
                        echo "mode".$row['device_mode'];
                        exit();
                    }
                    else{
                        echo "Nothing";
                        exit();
                    }
                }
            }
            else{
                exit();
            }
        }
        else{
            echo "Invalid Device";
            exit();
        }
    }  
}
if (!empty($_GET['confirm_id']) && isset($_GET['device_token'])) {

    $fingerid = $_GET['confirm_id'];
    $device_uid = $_GET['device_token'];

    $sql = "SELECT * FROM devices WHERE device_uid=?";
    $result = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($result, $sql)) {
        echo "SQL_Error_Select_device";
        exit();
    }
    else{
        mysqli_stmt_bind_param($result, "s", $device_uid);
        mysqli_stmt_execute($result);
        $resultl = mysqli_stmt_get_result($result);
        if ($row = mysqli_fetch_assoc($resultl)){

            $sql="UPDATE profile SET fingerprint_select=0 WHERE fingerprint_select=1 AND device_uid=?";
            $result = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($result, $sql)) {
                echo "SQL_Error_Select";
                exit();
            }
            else{
                mysqli_stmt_bind_param($result, "s", $device_uid);
                mysqli_stmt_execute($result);
                
                $sql="UPDATE profile SET add_fingerid=0, fingerprint_select=1 WHERE id=? AND device_uid=?";
                $result = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($result, $sql)) {
                    echo "SQL_Error_Select";
                    exit();
                }
                else{
                    mysqli_stmt_bind_param($result, "ss", $fingerid, $device_uid);
                    mysqli_stmt_execute($result);
                    echo "Fingerprint has been added!";
                    exit();
                }
            }  
        }
        else{
            echo "Invalid Device";
            exit();
        }
    } 
}
if (isset($_GET['DeleteID']) && isset($_GET['device_token'])) {

    $device_uid = $_GET['device_token'];
    if ($_GET['DeleteID'] == "check") {
        $sql = "SELECT * FROM devices WHERE device_uid=?";
        $result = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($result, $sql)) {
            echo "SQL_Error_Select_device";
            exit();
        }
        else{
            mysqli_stmt_bind_param($result, "s", $device_uid);
            mysqli_stmt_execute($result);
            $resultl = mysqli_stmt_get_result($result);
            if ($row = mysqli_fetch_assoc($resultl)){
                $sql = "SELECT id FROM profile WHERE del_fingerid=1 AND device_uid=? LIMIT 1";
                $result = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($result, $sql)) {
                    echo "SQL_Error_Select";
                    exit();
                }
                else{
                    mysqli_stmt_bind_param($result, "s", $device_uid);
                    mysqli_stmt_execute($result);
                    $resultl = mysqli_stmt_get_result($result);
                    if ($row = mysqli_fetch_assoc($resultl)) {
                        
                        echo "del-id".$row['id'];

                        $sql = "DELETE FROM profile WHERE del_fingerid=1";
                        $result = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($result, $sql)) {
                            echo "SQL_Error_delete";
                            exit();
                        }
                        else{
                            mysqli_stmt_execute($result);
                            exit();
                        }
                    }
                    else{
                        echo "nothing";
                        exit();
                    }
                }
            }
            else{
                echo "Invalid Device";
                exit();
            }
        }
    }
    else{
        exit();
    }
}




//////////////////////////////////////////////////









if (isset($_GET['card_uid']) && isset($_GET['device_token'])) {
    
    $card_uid = $_GET['card_uid'];
    $device_uid = $_GET['device_token'];

    $sql = "SELECT * FROM devices WHERE device_uid=?";
    $result = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($result, $sql)) {
        echo "SQL_Error_Select_device";
        exit();
    }
    else{
        mysqli_stmt_bind_param($result, "s", $device_uid);
        mysqli_stmt_execute($result);
        $resultl = mysqli_stmt_get_result($result);
        if ($row = mysqli_fetch_assoc($resultl)){
            $device_mode = $row['device_mode'];
            $device_dep = $row['device_dep'];
            if ($device_mode == 1) {
                $sql = "SELECT * FROM profile WHERE card_uid=?";
                $result = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($result, $sql)) {
                    echo "SQL_Error_Select_card";
                    exit();
                }
                else{
                    mysqli_stmt_bind_param($result, "s", $card_uid);
                    mysqli_stmt_execute($result);
                    $resultl = mysqli_stmt_get_result($result);
                    if ($row = mysqli_fetch_assoc($resultl)){
                        //*****************************************************
                        //An existed Card has been detected for Login or Logout
                        if ($row['add_card'] == 1){
                        if ($row['device_uid'] == $device_uid || $row['device_uid'] == 0){
                                $Uname = $row['fname'];
                                $lname = $row['lname'];
                                $Number = $row['mssv'];
                                $f_id = $row['id'];
                                
                                $sql = "SELECT * FROM giamsat WHERE card_uid=? AND checkindate=? AND card_out=0";
                                $result = mysqli_stmt_init($conn);
                                if (!mysqli_stmt_prepare($result, $sql)) {
                                    echo "SQL_Error_Select_logs";
                                    exit();
                                }
                                else{
                                    mysqli_stmt_bind_param($result, "ss", $card_uid, $d);
                                    mysqli_stmt_execute($result);
                                    $resultl = mysqli_stmt_get_result($result);
                                    //*****************************************************
                                    //Login
                                    if (!$row = mysqli_fetch_assoc($resultl)){

                                        $sql = "INSERT INTO giamsat (ten, lname, id, mssv, card_uid, device_uid, device_dep, checkindate, timein, timeout) VALUES (?, ?, ? ,?, ?, ?, ?, ?, ?, ?)";
                                        $result = mysqli_stmt_init($conn);
                                        if (!mysqli_stmt_prepare($result, $sql)) {
                                            echo "SQL_Error_Select_login1";
                                            exit();
                                        }
                                        else{
                                            $timeout = "00:00:00";
                                            mysqli_stmt_bind_param($result, "sssdssssss", $Uname, $lname, $f_id, $Number, $card_uid, $device_uid, $device_dep, $d, $t, $timeout);
                                            mysqli_stmt_execute($result);

                                            echo "login".$Uname;
                                            exit();
                                        }
                                    }
                                    //*****************************************************
                                    //Logout
                                    else{
                                        $sql="UPDATE giamsat SET timeout=?, fingerout=1, card_out=1 WHERE card_uid=? AND checkindate=? AND card_out=0";
                                        $result = mysqli_stmt_init($conn);
                                        if (!mysqli_stmt_prepare($result, $sql)) {
                                            echo "SQL_Error_insert_logout1";
                                            exit();
                                        }
                                        else{
                                            mysqli_stmt_bind_param($result, "sss", $t, $card_uid, $d);
                                            mysqli_stmt_execute($result);

                                            echo "logout".$Uname;
                                            exit();
                                        }
                                    }
                                }
                            }
                            else {
                                echo "Not Allowed!";
                                exit();
                            }
                        }
                        else if ($row['add_card'] == 0){
                            echo "Not registerd!";
                            exit();
                        }
                    }
                    else{
                        echo "Not found!";
                        exit();
                    }
                }
            }
            else if ($device_mode == 0) {
                //New Card has been added
                $sql = "SELECT * FROM profile WHERE card_uid=?";
                $result = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($result, $sql)) {
                    echo "SQL_Error_Select_card";
                    exit();
                }
                else{
                    mysqli_stmt_bind_param($result, "s", $card_uid);
                    mysqli_stmt_execute($result);
                    $resultl = mysqli_stmt_get_result($result);
                    //The Card is available
                    if ($row = mysqli_fetch_assoc($resultl)){
                        $sql = "SELECT card_select FROM profile WHERE card_select=1";
                        $result = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($result, $sql)) {
                            echo "SQL_Error_Select";
                            exit();
                        }
                        else{
                            mysqli_stmt_execute($result);
                            $resultl = mysqli_stmt_get_result($result);
                            
                            if ($row = mysqli_fetch_assoc($resultl)) {
                                $sql="UPDATE profile SET card_select=0";
                                $result = mysqli_stmt_init($conn);
                                if (!mysqli_stmt_prepare($result, $sql)) {
                                    echo "SQL_Error_insert";
                                    exit();
                                }
                                else{
                                    mysqli_stmt_execute($result);

                                    $sql="UPDATE profile SET card_select=1 WHERE card_uid=?";
                                    $result = mysqli_stmt_init($conn);
                                    if (!mysqli_stmt_prepare($result, $sql)) {
                                        echo "SQL_Error_insert_An_available_card";
                                        exit();
                                    }
                                    else{
                                        mysqli_stmt_bind_param($result, "s", $card_uid);
                                        mysqli_stmt_execute($result);

                                        echo "available";
                                        exit();
                                    }
                                }
                            }
                            else{
                                $sql="UPDATE profile SET card_select=1 WHERE card_uid=?";
                                $result = mysqli_stmt_init($conn);
                                if (!mysqli_stmt_prepare($result, $sql)) {
                                    echo "SQL_Error_insert_An_available_card";
                                    exit();
                                }
                                else{
                                    mysqli_stmt_bind_param($result, "s", $card_uid);
                                    mysqli_stmt_execute($result);

                                    echo "available";
                                    exit();
                                }
                            }
                        }
                    }
                    //The Card is new
                    else{
                        $sql="UPDATE profile SET card_select=0";
                        $result = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($result, $sql)) {
                            echo "SQL_Error_insert";
                            exit();
                        }
                        else{
                            mysqli_stmt_execute($result);

                            // echo($card_uid);
                            // echo('<br>');
                            // echo($device_uid);
                            // echo('<br>');
                            // echo($device_dep);
                            // echo('<br>');
                            $ran_id = rand(time(), 100000000);

                            $sql = "INSERT INTO profile (unique_id, card_uid, card_select, device_uid, device_dep, user_date) VALUES (?, ?, 1, ?, ?, CURDATE())";
                            $result = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($result, $sql)) {
                                echo "SQL_Error_Select_add";
                                exit();
                            }
                            else{
                                mysqli_stmt_bind_param($result, "ssss",$ran_id, $card_uid, $device_uid, $device_dep );
                                mysqli_stmt_execute($result);

                                echo "succesful";
                                exit();
                            }
                        }
                    }
                }    
            }
        }
        else{
            echo "Invalid Device!";
            exit();
        }
    }          
}




?>
