<?php 
	session_start();
	include_once "../libs/students.php";
	connect_db();
	if(!isset($_SESSION['unique_id'])){
	  header("location: ../index.php");
	}

  if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == '1' ) { //admin 
      include_once "header_lienlac_admin.php"; 

    } else if ($_SESSION['role'] == '2') { //supervisor
      include_once "../include/header_supervisor.php";

    } else if ($_SESSION['role'] == '3') { // user
      include_once "../include/header_user.php";

    } 
  }
  $status = 'Active Now';
  $sql3 = mysqli_query($conn, "UPDATE profile SET status = '{$status}' WHERE unique_id = {$_SESSION['unique_id']}");
  $query3 = mysqli_query($conn, $sql3);
?>


    <div class="wrapper">
      <section class="users">
        <header>

          <div class="content">
            <?php 
              $sql = mysqli_query($conn, "SELECT * FROM profile WHERE unique_id = {$_SESSION['unique_id']}");
              if(mysqli_num_rows($sql) > 0){
                $row = mysqli_fetch_assoc($sql);
              }
            ?>
            <img src="../images/<?php echo $row['img']; ?>"  alt="">
            <div class="details">
              <span><?php echo $row['fname']. " " . $row['lname'] ?></span>
              <p><?php echo $row['status']; ?></p>
            </div>
          </div>

          <a href="../dangxuat.php" class="logout">Logout</a>
            <!-- <a href="php/logout.php?logout_id=<?php
            //  echo $row['unique_id']; 
            ?>" class="logout">Logout</a> -->
        </header>

        <div class="search">
          <span class="text">Select an user to start chat</span>
          <input type="text" placeholder="Enter name to search...">
          <button><i class="fas fa-search"></i></button>
        </div>
        
        <div class="users-list">
              
        </div>
      </section>
    </div>

    <script src="users.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>          
    <script>  
$(document).ready(function(){

	// fetch_user();

	setInterval(function(){
		update_last_activity();
		
	}, 2000);



	function update_last_activity()
	{
		$.ajax({
			url:"update_last_activity.php",
			success:function()
			{

			}
		})
	}
	
});  
</script>
  </body>
</html>
