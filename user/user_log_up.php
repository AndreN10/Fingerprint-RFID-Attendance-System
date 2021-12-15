<?php  
session_start();
$id = $_SESSION['id'];
?>
<table class="table table-striped table-borderless table-hover table-responsive caption-top table2excel">
<caption>Thời gian giám sát</caption>
                    <thead class="table-dark">
                        <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Full Name</th>
                        <th scope="col">Student's ID</th>
                        <th scope="col">Class</th>
                        <th scope="col">Date</th>
                        <th scope="col">Time In</th>
                        <th scope="col">Time Out</th>
                        <!-- <th scope="col">Warning</th> -->
                                         
                        </tr>
                    </thead>

  <tbody>
    <?php
      //Connect to database
      require '../libs/students.php';
      connect_db();

      if (isset($_POST['log_date'])) {
        if ($_POST['date_sel'] != 0) {
            $_SESSION['seldate'] = $_POST['date_sel'];
        }
        else{
            $_SESSION['seldate'] = date("Y-m-d");
        }
      }
      
      if ($_POST['select_date'] == 1) {
          $_SESSION['seldate'] = date("Y-m-d");
      }
      else if ($_POST['select_date'] == 0) {
          $seldate = $_SESSION['seldate'];
      }
      
      
      $sql2 = "select * from profile where id={$id}";   
      $query2 = mysqli_query($conn, $sql2);    
      $result2 = array();         
      if ($query2){
          while ($row2 = mysqli_fetch_assoc($query2)){
              $result2[] = $row2;
          }
      }    
         


      $sql = "SELECT * FROM giamsat WHERE id={$id} and checkindate='$seldate' ORDER BY id DESC";
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
                  <TD><?php echo $row['id'];?></TD>
                  <td><strong >
                    <?php 
                      foreach ($result2 as $key2 => $author2){ 
                          if ($author2['id'] == $row['id']){
                              // echo $author2['ten'];
                              echo $author2['fname']. " " . $author2['lname'];
                          }
                      }
                    ?></strong>
                  </td>
                  <TD><?php echo $row['mssv'];?></TD>
                  <td>
                    <?php 
                      foreach ($result2 as $key2 => $author2){ 
                          if ($author2['id'] == $row['id']){
                              echo $author2['department'];
                          }
                      }
                    ?>
                  </td>
                  <TD><?php echo $row['checkindate'];?></TD>
                  <TD><?php echo $row['timein'];?></TD>
                  <TD><?php echo $row['timeout'];?></TD>
                  
                  </TR>
    <?php
            }   
        }
      }
    ?>
  </tbody>
</table>
