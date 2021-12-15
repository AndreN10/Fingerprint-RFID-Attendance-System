<?php  
//Connect to database
require './libs/students.php';
connect_db();

//Add user
if (isset($_POST['Add'])) {
     
    $user_id = $_POST['user_id'];
    $Uname = $_POST['name'];
    $Number = $_POST['number'];
    $Email = $_POST['email'];
    $dev_uid = $_POST['dev_uid'];
    $Gender = $_POST['gender'];
    
    $f_id = $_POST['f_id'];
    $add_fingerid = 1;
    
    ////////
    if ($f_id == 0) {
        echo "Enter a Fingerprint ID!";
        exit();
    } else {
        if ($f_id > 0 && $f_id < 128) {
            $sql = "SELECT * FROM devices WHERE id=?";
            $result = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($result, $sql)) {
                echo "SQL_Error";
                exit();
            } else {
                mysqli_stmt_bind_param($result, "i", $dev_uid);
                mysqli_stmt_execute($result);
                $resultl = mysqli_stmt_get_result($result);
                if ($row = mysqli_fetch_assoc($resultl)) {
                    $dev_name = $row['device_dep'];
                    $dev_uid = $row['device_uid'];
                }
            }
            $sql = "SELECT id FROM profile WHERE id=? AND device_uid=?";
            $result = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($result, $sql)) {
                echo "SQL_Error";
                exit();
            } else {
                mysqli_stmt_bind_param($result, "is", $f_id, $dev_uid);
                mysqli_stmt_execute($result);
                $resultl = mysqli_stmt_get_result($result);
                if (!$row = mysqli_fetch_assoc($resultl)) {

                    
                } else {
                    echo "This ID is already exist! Delete it from the scanner";
                    exit();
                }
            }
        } else {
            echo "The Fingerprint ID must be between 1 & 127";
            exit();
        }
    }

    ////////

    
    //check if there any selected user
    $sql = "SELECT add_card FROM profile WHERE stt=?";
    $result = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($result, $sql)) {
      echo "SQL_Error";
      exit();
    }
    else{
        mysqli_stmt_bind_param($result, "i", $user_id);
        mysqli_stmt_execute($result);
        $resultl = mysqli_stmt_get_result($result);
        if ($row = mysqli_fetch_assoc($resultl)) {

            if ($row['add_card'] == 0) {

                if (!empty($Uname) && !empty($Number) && !empty($Email)) {
                    //check if there any user had already the Serial Number
                    $sql = "SELECT mssv FROM profile WHERE mssv=? AND stt NOT like ?";
                    $result = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($result, $sql)) {
                        echo "SQL_Error";
                        exit();
                    }
                    else{
                        mysqli_stmt_bind_param($result, "di", $Number, $user_id);
                        mysqli_stmt_execute($result);
                        $resultl = mysqli_stmt_get_result($result);
                        if (!$row = mysqli_fetch_assoc($resultl)) {
                            $sql = "SELECT device_dep FROM devices WHERE device_uid=?";
                            $result = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($result, $sql)) {
                                echo "SQL_Error";
                                exit();
                            }
                            else{
                                mysqli_stmt_bind_param($result, "s", $dev_uid);
                                mysqli_stmt_execute($result);
                                $resultl = mysqli_stmt_get_result($result);
                                if ($row = mysqli_fetch_assoc($resultl)) {
                                    $dev_name = $row['device_dep'];
                                }
                                else{
                                    $dev_name = "All";
                                }
                            }
                            $sql="UPDATE profile SET id=?, add_fingerid=?, fname=?, mssv=?, gioitinh=?, email=?, user_date=CURDATE(), device_uid=?, device_dep=?, add_card=1 WHERE stt=?";
                            $result = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($result, $sql)) {
                                echo "SQL_Error_select_Fingerprint";
                                exit();
                            }
                            else{
                                mysqli_stmt_bind_param($result, "sssdssssi", $f_id, $add_fingerid, $Uname, $Number, $Gender, $Email, $dev_uid, $dev_name, $user_id );
                                mysqli_stmt_execute($result);

                                echo 1;
                                exit();
                            }
                        }
                        else {
                            echo "The serial number is already taken!";
                            exit();
                        }
                    }
                }
                else{
                    echo "Empty Fields";
                    exit();
                }
            }
            else{
                echo "This User is already exist";
                exit();
            }    
        }
        else {
            echo "There's no selected Card!";
            exit();
        }
    }
}
// Update an existance user 
if (isset($_POST['Update'])) {

    $user_id = $_POST['user_id'];
    $Uname = $_POST['name'];
    $Number = $_POST['number'];
    $Email = $_POST['email'];
    $dev_uid = $_POST['dev_uid'];
    $Gender = $_POST['gender'];

    //check if there any selected user
    $sql = "SELECT add_card FROM profile WHERE stt=?";
    $result = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($result, $sql)) {
      echo "SQL_Error";
      exit();
    }
    else{
        mysqli_stmt_bind_param($result, "i", $user_id);
        mysqli_stmt_execute($result);
        $resultl = mysqli_stmt_get_result($result);
        if ($row = mysqli_fetch_assoc($resultl)) {

            if ($row['add_card'] == 0) {
                echo "First, You need to add the User!";
                exit();
            }
            else{
                if (empty($Uname) && empty($Number) && empty($Email)) {
                    echo "Empty Fields";
                    exit();
                }
                else{
                    //check if there any user had already the Serial Number
                    $sql = "SELECT mssv FROM profile WHERE mssv=? AND stt NOT like ?";
                    $result = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($result, $sql)) {
                        echo "SQL_Error";
                        exit();
                    }
                    else{
                        mysqli_stmt_bind_param($result, "di", $Number, $user_id);
                        mysqli_stmt_execute($result);
                        $resultl = mysqli_stmt_get_result($result);
                        if (!$row = mysqli_fetch_assoc($resultl)) {
                            $sql = "SELECT device_dep FROM devices WHERE device_uid=?";
                            $result = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($result, $sql)) {
                                echo "SQL_Error";
                                exit();
                            }
                            else{
                                mysqli_stmt_bind_param($result, "s", $dev_uid);
                                mysqli_stmt_execute($result);
                                $resultl = mysqli_stmt_get_result($result);
                                if ($row = mysqli_fetch_assoc($resultl)) {
                                    $dev_name = $row['device_dep'];
                                }
                                else{
                                    $dev_name = "All";
                                }
                            }
                                    
                            if (!empty($Uname) && !empty($Email)) {

                                $sql="UPDATE profile SET fname=?, mssv=?, gioitinh=?, email=?, device_uid=?, device_dep=? WHERE stt=?";
                                $result = mysqli_stmt_init($conn);
                                if (!mysqli_stmt_prepare($result, $sql)) {
                                    echo "SQL_Error_select_Card";
                                    exit();
                                }
                                else{
                                    mysqli_stmt_bind_param($result, "sdssssi", $Uname, $Number, $Gender, $Email, $dev_uid, $dev_name, $user_id );
                                    mysqli_stmt_execute($result);

                                    echo 1;
                                    exit();
                                }
                            }
                        }
                        else {
                            echo "The serial number is already taken!";
                            exit();
                        }
                    }
                }
            }    
        }
        else {
            echo "There's no selected User to be updated!";
            exit();
        }
    }
}
// select fingerprint 
if (isset($_GET['select'])) {

    $finger_id = $_GET['card_uid'];

    // $sql="UPDATE profile SET fingerprint_select=0 WHERE device_uid=?";
    $sql="UPDATE profile SET card_select=0";
    $result = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($result, $sql)) {
        echo "SQL_Error_Select";
        exit();
    }
    else{
        // mysqli_stmt_bind_param($result, "s", $dev_uid);
        mysqli_stmt_execute($result);

        $sql="UPDATE profile SET card_select=1 WHERE card_uid=?";
        $result = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($result, $sql)) {
            echo "SQL_Error_select_Fingerprint";
            exit();
        }
        else{
            mysqli_stmt_bind_param($result, "i", $finger_id);
            mysqli_stmt_execute($result);

            // echo "User Fingerprint selected";
            // exit();
            header('Content-Type: application/json');
            $data = array();
            $sqls = "SELECT * FROM profile WHERE card_uid=?";
            $results = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($results, $sqls)) {
                echo "SQL_Error";
                exit();
            }
            else{
                mysqli_stmt_bind_param($results, "i", $finger_id);
                mysqli_stmt_execute($results);
                $resultls = mysqli_stmt_get_result($results); 
                if ($rows = mysqli_fetch_assoc($resultls)) {
                    foreach ($resultls as $rows) {
                        $data[] = $rows;
                    }
                }
            }
            $result->close();
            $conn->close();
            print json_encode($data);
        }
    }

     
}
// delete user 
if (isset($_POST['delete'])) {

    $user_id = $_POST['user_id'];
    $f_id = $_POST['f_id'];
    $dev_uid = $_POST['dev_uid'];

    if (empty($user_id)) {
        echo "There no selected user to remove";
        exit();
    } else {
        // $sql = "DELETE FROM profile WHERE stt=?";
        // $result = mysqli_stmt_init($conn);
        // if (!mysqli_stmt_prepare($result, $sql)) {
        //     echo "SQL_Error_delete";
        //     exit();
        // }
        // else{
        //     mysqli_stmt_bind_param($result, "i", $user_id);
        //     mysqli_stmt_execute($result);
        //     echo 1;
        //     exit();
        // }

        $sql = "UPDATE profile SET del_fingerid=1 WHERE id=? AND device_uid=?";
        $result = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($result, $sql)) {
            echo "SQL_Error_delete";
            exit();
        } else {
            mysqli_stmt_bind_param($result, "is", $f_id, $dev_uid);
            mysqli_stmt_execute($result);
            echo 1;
            exit();
        }
    }
}
?>