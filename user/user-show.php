<?php 
    session_start();
    if(!isset($_SESSION['unique_id'])){
        header("location: ../index.php");
    }
?>


<?php

require '../libs/students.php';
// $id = isset($_GET['id']) ? (int)$_GET['id'] : '';
$id = $_SESSION['unique_id'];
if ($id){
    $data = get_student($id);
    $ten = $data['lname'];
}
connect_db();

if (isset($_SESSION['message'])) {
  
    $message = $_SESSION['message'];
    echo "<script type='text/javascript'>alert('$message');</script>";
    unset($_SESSION['message']);

}



$sql = "select * from giamsat";
$query = mysqli_query($conn, $sql);
    
   // Mảng chứa kết quả
   $result = array();
    
   // Lặp qua từng record và đưa vào biến kết quả
   if ($query){
       while ($row = mysqli_fetch_assoc($query)){
           $result[] = $row;
       }
   }
$sql2 = "select * from profile";   
$query2 = mysqli_query($conn, $sql2);    
$result2 = array();
    
   // Lặp qua từng record và đưa vào biến kết quả
   if ($query){
       while ($row2 = mysqli_fetch_assoc($query2)){
           $result2[] = $row2;
       }
   }    







mysqli_free_result($query);
mysqli_free_result($query2);
mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="../chat/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
        <style>
            .form #deleteButton {
                margin: 0px;
            }
            
            .form form {
                margin: 10px 0;
            }
            
            .form header {
               
                padding-bottom: 0px; 
            }
        </style>
    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark align-items-start">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">HỆ THỐNG ĐIỂM DANH</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="user-show.php">Trang chủ</a>
                        </li>                   
                        <li class="nav-item">
                        <a class="nav-link" href="user-profile.php">Hồ sơ cá nhân</a>
                        </li>                       
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="../chat/lienlac.php">Liên lạc</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="../dangxuat.php">Đăng xuất</a>
                        </li>
                    </ul>
                    
                </div>
                
            </div>
        </nav>
    

      
        <h1>Thời Gian Giám Sát</h1> 
        </br>
        <strong><i><font size='4'> Xin Chào: </font><span style="color: red"><?php echo $ten;?> - User</i></span></strong>


        
        <div class="homepage table-responsive">
            <section class="form">
                <div class="">
                    <header>Lọc theo ngày</header>
                    <form method="POST" >
                        <input type="date" name="date_sel" id="date_sel">
                        
                        <button class="btn btn-primary btn-sm" type="button" name="user_log" id="user_log">Select Date</button>

                        <!--<button id = "button1" class="btn btn-success btn-sm">Export</button>-->
                                    
                        
                        
                    </form>
                </div>
            


                <!-- <table class="table table-striped table-borderless table-hover table-responsive caption-top table2excel">
                    <caption>Thời gian giám sát</caption>
                    <thead class="table-dark">
                        <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Full Name</th>
                        <th scope="col">Student's ID</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Date</th>
                        <th scope="col">Time In</th>
                        <th scope="col">Time Out</th>
                        <th scope="col">Warning</th>
                        <th scope="col">Delete Option</th>                  
                        </tr>
                    </thead>
                   
                </table> -->
                <div id="userslog"></div>
                
                <!--<hr class="my-3">-->

                <!-- <h3>Lọc theo ID</h3>
                <form method="GET" action="filter.php" target="blank">
                    <input type="text" name="id">
                    <input type="submit" name="form_click" class="btn btn-primary btn-sm" value="LỌC"/><br/>
                </form>

                <hr class="my-3"> -->
                
                
                    

            </section>
            
        </div>


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>     
                                                                                                          
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <!--<script src="../js/jquery.table2excel.js"></script>-->
        <!--<script>-->
        <!--    $("#button1").click(function(){          -->
        <!--        $(".table2excel").table2excel({-->
        <!--            exclude: ".noExl",-->
        <!--            name: "Excel Document Name",-->
        <!--            filename: "myFileName",-->
        <!--            fileext: ".xls",-->
        <!--            exclude_img: true,-->
        <!--            exclude_links: true,-->
        <!--            exclude_inputs: true-->
        <!--        });-->
        <!--    });-->
        <!--</script>-->





        <script src="js/user_log.js"></script>
        <script>
        $(document).ready(function(){
            $.ajax({
                url: "user_log_up.php",
                type: 'POST',
                data: {
                    'select_date': 1,
                }
            });
            setInterval(function(){
            $.ajax({
                url: "user_log_up.php",
                type: 'POST',
                data: {
                    'select_date': 0,
                }
                }).done(function(data) {
                $('#userslog').html(data);
                });
            },500);
        });
        </script>
                

    </body>    
</html>
