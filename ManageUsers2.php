<?php
session_start();

?>
<!DOCTYPE html>
<html>
    <head>
    	<title>Add Users</title>
      	<meta charset="utf-8">
      	<meta name="viewport" content="width=device-width, initial-scale=1">
      	<!-- <link rel="icon" type="image/png" href="images/favicon.png"> -->
      	<link rel="stylesheet" href="chat/style.css">
    	<link rel="stylesheet" type="text/css" href="manageusers.css">
    	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        
    	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <!-- <script type="text/javascript" src="js/jquery-2.2.3.min.js"></script> -->
    	<script src="https://code.jquery.com/jquery-3.3.1.js"
    	        integrity="sha1256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
    	        crossorigin="anonymous">
    	</script>
        <script type="text/javascript" src="js/bootbox.min.js"></script>
    	<script type="text/javascript" src="js/bootstrap.js"></script>
    	<script src="js/manage_users2.js"></script>
    	<script>
    	  	$(window).on("load resize ", function() {
    		    var scrollWidth = $('.tbl-content').width() - $('.tbl-content table').width();
    		    $('.tbl-header').css({'padding-right':scrollWidth});
    		}).resize();
    	</script>
    	<script>
    	  $(document).ready(function(){
    	  	  $.ajax({
    	        url: "manage_users_up2.php"
    	        }).done(function(data) {
    	        $('#manage_users').html(data);
    	      });
    	   // setInterval(function(){
    	   //   $.ajax({
    	   //     url: "manage_users_up2.php"
    	   //     }).done(function(data) {
    	   //     $('#manage_users').html(data);
    	   //   });
    	   // },5000);
    	  });
    	</script>
    
    	<style>
    		.form-style-5 .alert {
    			width: 100%;
    			height: unset;
    			margin-top: -10px;
    		}
    
    		.section span {
    			float: left;
    			display: block;
    			position: unset;
    			margin: unset;
    		}
    		
    		.section {
			top: 157px;
    		}
    		
    		body {
    			display: unset;
    		}
    	</style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark align-items-start"  style="padding-left: var(--bs-gutter-x,.75rem);>
            <div class="container-fluid" style="padding-left: 0;">
                <a class="navbar-brand" style="padding-left: 0;" href="#">HỆ THỐNG ĐIỂM DANH</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link "  href="show.php">Trang chủ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="summary.php">Tổng kết</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="student-list.php">Danh sách quản lý</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="student-add.php">Thêm người dùng</a>
                        </li>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="chat\lienlac.php">Liên lạc</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="devices.php">Thiết bị</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="dangxuat.php">Đăng xuất</a>
                        </li>
                    </ul>
    
                </div>
    
            </div>
        </nav>
        
    
        <main>
        	<h1 class="slideInDown animated">Add a new User or update his information <br> or remove him</h1>
        	<div class="form-style-5 slideInDown animated">
        		<form enctype="multipart/form-data">
        			<div class="alert_user"></div>
        			<fieldset>
        				<legend><span class="number">1</span> User Info</legend>
        				<input type="hidden" name="user_id" id="user_id">
        				
        				<label for="name">First Name</label>
        				<input type="text" name="name" id="name" placeholder="User Name...">
        
        				<label for="number">MSSV</label>
        				<input type="text" name="number" id="number" placeholder="Serial Number...">
        
        				<!-- <label for="email">First Name</label> -->
        				<input type="hidden" name="email" id="email" placeholder="User Email...">
        				
        				<label for="f_id">Fingerprint ID</label>
        				<input type="text" name="f_id" id="f_id" placeholder="Fingerprint ID">
        			</fieldset>
        			<fieldset>
        			<legend><span class="number">2</span> Additional Info</legend>
        			<label>
        				<label for="Device"><b>User Department:</b></label>
                            <select class="dev_sel" name="dev_sel" id="dev_sel" style="color: #000;">
                              <option value="0">All Departments</option>
                              <?php
                                // require'connectDB.php';
        						require './libs/students.php';
        						connect_db();
                                $sql = "SELECT * FROM devices ORDER BY device_name ASC";
                                $result = mysqli_stmt_init($conn);
                                if (!mysqli_stmt_prepare($result, $sql)) {
                                    echo '<p class="error">SQL Error</p>';
                                } 
                                else{
                                    mysqli_stmt_execute($result);
                                    $resultl = mysqli_stmt_get_result($result);
                                    while ($row = mysqli_fetch_assoc($resultl)){
                              ?>
                                      <option value="<?php echo $row['device_uid'];?>"><?php echo $row['device_dep']; ?></option>
                              <?php
                                    }
                                }
                              ?>
                            </select>
        				<input type="radio" name="gender" class="gender" value="Female">Female
        	          	<input type="radio" name="gender" class="gender" value="Male" checked="checked">Male
        	      	</label >
        			</fieldset>
        			<button type="button" name="user_add" class="user_add">Add User</button>
        			<button type="button" name="user_upd" class="user_upd">Update User</button>
        			<button type="button" name="user_rmo" class="user_rmo">Remove User</button>
        		</form>
        	</div>
        
        	<!--User table-->
        	<div class="section">
        		
        		<div class="slideInRight animated">
        			<div id="manage_users"></div>
        		</div>
        	</div>
        </main>
    </body>
</html>