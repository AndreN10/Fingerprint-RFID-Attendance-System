<div class="table-responsive " style="max-height: 870px;">
  <table class="table table-striped table-borderless table-hover table-responsive caption-top">
    <thead class="table-light table-striped table-borderless">
      <tr>
        <th scope="col">Finger .ID</th>
        <th scope="col">Name</th>
        <th scope="col">Gender</th>
        <th scope="col">S.No</th>
        <th scope="col">Date</th>
        <th scope="col">Department</th>
        <th scope="col">Dev.Status</th>
      </tr>
    </thead>
    <tbody class="">
      <?php
      //Connect to database
      require './libs/students.php';
      connect_db();
      // require 'connectDB.php';

      $sql = "SELECT * FROM profile WHERE del_fingerid=0 AND id!=0 ORDER BY stt DESC";
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
              <TD><?php
                  if ($row['fingerprint_select'] == 1) {
                    echo "<span><i class='fa fa-check' title='The selected UID'></i></span>";
                  }
                  $fingerid = $row['id'];
                  $device_uid = $row['device_uid'];
                  ?>
                <form>
                  <button type="button" class="select_btn" data-id="<?php echo $fingerid; ?>" name="<?php echo $device_uid; ?>" title="select this UID"><?php echo $fingerid; ?></button>
                </form>
              </TD>
              <TD><?php echo $row['fname'] . " " . $row['lname']; ?></TD>
              <TD><?php echo $row['gioitinh']; ?></TD>
              <TD><?php echo $row['mssv']; ?></TD>
              <TD><?php echo $row['user_date']; ?></TD>
              <TD><?php echo ($row['device_dep'] == "0") ? "All" : $row['device_dep']; ?></TD>
              <TD><?php echo ($row['add_fingerid'] == "0") ? "Added" : "Free" ?></TD>
            </TR>
      <?php
          }
        }
      }
      ?>
    </tbody>
  </table>
</div>