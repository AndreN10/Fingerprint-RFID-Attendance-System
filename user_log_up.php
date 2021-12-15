<?php
session_start();
?>
<table class="table table-striped table-borderless table-hover table-responsive caption-top table2excel">
  <caption></caption>
  <thead class="table-dark">
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Full Name</th>
      <th scope="col">Student/Teacher ID</th>

      <th scope="col">Device Department</th>
      <th scope="col">Date</th>
      <th scope="col">Time In</th>
      <th scope="col">Time Out</th>
      <!-- <th scope="col">Warning</th> -->
      <th scope="col">Delete Option</th>
    </tr>
  </thead>

  <tbody>
    <?php
    //Connect to database
    require './libs/students.php';
    connect_db();
    // $searchQuery = " ";
    // $Start_date = " ";
    // $End_date = " ";
    // $Start_time = " ";
    // $End_time = " ";
    // $Finger_sel = " ";

    // if (isset($_POST['log_date'])) {
    //   if ($_POST['date_sel'] != 0) {
    //       $_SESSION['seldate'] = $_POST['date_sel'];
    //   }
    //   else{
    //       $_SESSION['seldate'] = date("Y-m-d");
    //   }
    // }

    // if ($_POST['select_date'] == 1) {
    //     $_SESSION['seldate'] = date("Y-m-d");
    // }
    // else if ($_POST['select_date'] == 0) {
    //     $seldate = $_SESSION['seldate'];
    // }

    if (isset($_POST['log_date'])) {
      //Start date filter
      if ($_POST['date_sel_start'] != 0) {
        $Start_date = $_POST['date_sel_start'];
        $_SESSION['searchQuery'] = "checkindate='" . $Start_date . "'";
      } else {
        $Start_date = date("Y-m-d");
        $_SESSION['searchQuery'] = "checkindate='" . date("Y-m-d") . "'";
      }
      //End date filter
      if ($_POST['date_sel_end'] != 0) {
        $End_date = $_POST['date_sel_end'];
        $_SESSION['searchQuery'] = "checkindate BETWEEN '" . $Start_date . "' AND '" . $End_date . "'";
      }
      //Time-In filter
      if ($_POST['time_sel'] == "Time_in") {
        //Start time filter
        if ($_POST['time_sel_start'] != 0 && $_POST['time_sel_end'] == 0) {
          $Start_time = $_POST['time_sel_start'];
          $_SESSION['searchQuery'] .= " AND timein='" . $Start_time . "'";
        } elseif ($_POST['time_sel_start'] != 0 && $_POST['time_sel_end'] != 0) {
          $Start_time = $_POST['time_sel_start'];
        }
        //End time filter
        if ($_POST['time_sel_end'] != 0) {
          $End_time = $_POST['time_sel_end'];
          $_SESSION['searchQuery'] .= " AND timein BETWEEN '" . $Start_time . "' AND '" . $End_time . "'";
        }
      }
      //Time-out filter
      if ($_POST['time_sel'] == "Time_out") {
        //Start time filter
        if ($_POST['time_sel_start'] != 0 && $_POST['time_sel_end'] == 0) {
          $Start_time = $_POST['time_sel_start'];
          $_SESSION['searchQuery'] .= " AND timeout='" . $Start_time . "'";
        } elseif ($_POST['time_sel_start'] != 0 && $_POST['time_sel_end'] != 0) {
          $Start_time = $_POST['time_sel_start'];
        }
        //End time filter
        if ($_POST['time_sel_end'] != 0) {
          $End_time = $_POST['time_sel_end'];
          $_SESSION['searchQuery'] .= " AND timeout BETWEEN '" . $Start_time . "' AND '" . $End_time . "'";
        }
      }
      //Fingerprint filter
      if ($_POST['fing_sel'] != 0) {
        $Finger_sel = $_POST['fing_sel'];
        $_SESSION['searchQuery'] .= " AND id='" . $Finger_sel . "'";
      }
      // Department filter
      if ($_POST['dev_id'] != 0) {
        $dev_id = $_POST['dev_id'];
        $sql = "SELECT device_uid FROM devices WHERE id=?";
        $result = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($result, $sql)) {
          echo "SQL_Error";
          exit();
        } else {
          mysqli_stmt_bind_param($result, "i", $dev_id);
          mysqli_stmt_execute($result);
          $resultl = mysqli_stmt_get_result($result);
          if ($row = mysqli_fetch_assoc($resultl)) {
            $dev_uid = $row['device_uid'];
          }
        }
        $_SESSION['searchQuery'] .= " AND device_uid='" . $dev_uid . "'";
      }
    }

    if ($_POST['select_date'] == 1) {
      $Start_date = date("Y-m-d");
      $_SESSION['searchQuery'] = "checkindate='" . $Start_date . "'";
    }



    $sql2 = "select * from profile";
    $query2 = mysqli_query($conn, $sql2);
    $result2 = array();
    if ($query2) {
      while ($row2 = mysqli_fetch_assoc($query2)) {
        $result2[] = $row2;
      }
    }

    // $sql = "SELECT * FROM giamsat WHERE " . $_SESSION['searchQuery'] . " ORDER BY timeout DESC, timein";
    $sql = "SELECT * FROM giamsat WHERE " . $_SESSION['searchQuery'] . " ORDER BY timein DESC";
    $result = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($result, $sql)) {
      echo '<p class="error">SQL Error</p>';
    } else {
      mysqli_stmt_execute($result);
      $resultl = mysqli_stmt_get_result($result);
      if (mysqli_num_rows($resultl) > 0) {
        while ($row = mysqli_fetch_assoc($resultl)) {
          ?>
                <TR>
                  <TD><?php echo $row['id']; ?></TD>
                  <td><strong>
                      <?php
                      echo $row['ten'] . " " . $row['lname'];
                      ?></strong>
                  </td>
                  <TD><?php echo $row['mssv']; ?></TD>
                 
                  <TD><?php echo $row['device_dep']; ?></TD>
                  <TD><?php echo $row['checkindate']; ?></TD>
                  <TD><?php echo $row['timein']; ?></TD>
                  <TD><?php echo $row['timeout']; ?></TD>
                  <td>
                    <form id="deleteButton" method="post" action="student-delete.php">
                      <input type="hidden" name="stt" value="<?php echo $row['stt']; ?>" />
                      <input onclick="return confirm('Bạn có chắc muốn xóa không?');" class="btn btn-danger btn-xs" type="submit" name="delete" value="Xóa" />
                    </form>
                  </td>
                </TR>
          <?php
              }
      }
    }
    // echo $sql;
    ?>
  </tbody>
</table>