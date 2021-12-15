<div class="table-responsive" style="max-height: 870px;"> 
  <table class="table table-striped table-borderless table-hover table-responsive caption-top">
    <thead class="table-light">
      <tr>
        <th>Card UID</th>
        <th>Name</th>
        <th>Gender</th>
        <th>S.No</th>
        <th>Date</th>
        <th>Department</th>
        <th>Dev.Status</th>
      </tr>
    </thead>
    <tbody class="">
    <?php
      //Connect to database
      // require'connectDB.php';
      require './libs/students.php';
      connect_db();

        $sql = "SELECT * FROM profile WHERE del_fingerid=0 AND id!=1000 ORDER BY stt DESC";
        $result = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($result, $sql)) {
            echo '<p class="error">SQL Error</p>';
        }
        else{
            mysqli_stmt_execute($result);
            $resultl = mysqli_stmt_get_result($result);
          if (mysqli_num_rows($resultl) > 0){
              while ($row = mysqli_fetch_assoc($resultl)){
      ?>
                  <TR>
                  	<TD><?php  
                    		if ($row['card_select'] == 1) {
                    			echo "<span><i class='fa fa-check' title='The selected UID'></i></span>";
                    		}
                        $card_uid = $row['card_uid'];
                    	?>
                    	<form>
                    		<button type="button" class="select_btn" id="<?php echo $card_uid;?>" title="select this UID"><?php echo $card_uid;?></button>
                    	</form>
                    </TD>
                  <TD><?php echo $row['fname'] . " " . $row['lname'];?></TD>
                  <TD><?php echo $row['gioitinh'];?></TD>
                  <TD><?php echo $row['mssv'];?></TD>
                  <TD><?php echo $row['user_date'];?></TD>
                  <TD><?php echo ($row['device_dep'] == "0") ? "All" : $row['device_dep'];?></TD>
                  <TD><?php echo ($row['add_card'] == "1") ? "Added" : "Free" ?></TD>
                  </TR>
    <?php
            }   
        }
      }
    ?>
    </tbody>
  </table>
</div>