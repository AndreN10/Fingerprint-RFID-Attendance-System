<?php
    session_start();
    if(!isset($_SESSION['unique_id'])){
        header("location: ../index.php");
    }
?>

<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
require '../libs/students.php';
connect_db();
// $id = isset($_GET['id']) ? (int)$_GET['id'] : '';
$id = $_SESSION['unique_id'];
if ($id){
    $data = get_student($id);
    $ten = $data['lname'];
}

// $sql_3 = "delete from tongket";
// $query_3 = mysqli_query($conn,$sql_3);

// $sql = "select id from giamsat";
// $query = mysqli_query($conn,$sql);

// $result = array();
     
//     // Lặp qua từng record và đưa vào biến kết quả
//     if ($query){
//         while ($row = mysqli_fetch_assoc($query)){
//             $result[] = $row;
//         }
//     }

// $result2 = array();

//     foreach ($result as $key => $author){
//  		$result2[] = $author['id'];
 		
//     }
// $result2 = array_unique($result2);
// foreach ($result2 as $key => $author2){
		
// 		$sql_1 = " select * from giamsat where id = {$author2} " ;
// 		$query_1 = mysqli_query($conn,$sql_1);
// 		$result_3 = array();
		
// 		if ($query_1){
// 	        while ($row = mysqli_fetch_assoc($query_1)){
// 	            $result_3[] = $row;
	            
// 	        }
//   	 	}
//   	 	else {
// 		    echo "Error";
// 		}
// 		$dem = 0; // dem số lần đi trễ
//         $thoigiantre = 0;

// 		$mangngaylam = array();
//   	 	foreach ($result_3 as $key => $author_3){

//  			if ($author_3['gioint'] > mktime(8,0,0,0,0,0) ){
//  				$dem = $dem + 1;
//                 $thoigiantre = $thoigiantre + ($author_3['gioint'] - mktime(8,0,0,0,0,0));
//  			}
//  			$mangngaylam[] = $author_3['ngaylam'];				//Bỏ ngày làm vào trong mảng
//   	 	}
//   	 	$songaylam = count(array_unique($mangngaylam));		// Số ngày làm là số phần tử bỏ qua các giá trị trùng.
//   	 	$songayvang = date('d') - $songaylam;      // Tính số ngày vắng từ số ngày trễ
//         $thoigiantre = $thoigiantre/60;
 
//  		$sql_2 = "INSERT INTO tongket(id,slditre,songayvang,thoigiantre) VALUES ('$author2','$dem','$songayvang','$thoigiantre')";
//  		$query_2 = mysqli_query($conn,$sql_2);

//     }

    $sql_4 = "select * from tongket";
	$query_4 = mysqli_query($conn,$sql_4);
	$result_4 = array();
     
    // Lặp qua từng record và đưa vào biến kết quả
    if ($query_4){
        while ($row = mysqli_fetch_assoc($query_4)){
            $result_4[] = $row;
        }
    }


    $sql_5 = "select * from profile";
	$query_5 = mysqli_query($conn,$sql_5);
	$result_5 = array();
     
    // Lấy tên, năm sinh từ profile
    if ($query_5){
        while ($row = mysqli_fetch_assoc($query_5)){
            $result_5[] = $row;
        }
    }

    $sql_6 = "select * from giamsat group by presentcount having count(*) > 1";
	$query_6 = mysqli_query($conn,$sql_6);
	$result_6 = array();
     
    // Lấy tên, năm sinh từ profile
    if ($query_6){
        while ($row = mysqli_fetch_assoc($query_6)){
            $result_6[] = $row;
        }
    }


//mysqli_free_result($query);
//mysqli_free_result($query_3);
//mysqli_free_result($query_1);
//mysqli_free_result($query_2);
?>

<?php
	$sql_4 = "select * from tongket";
	$query_4 = mysqli_query($conn,$sql_4);
	$result_4 = array();
     
    // Lặp qua từng record và đưa vào biến kết quả
    if ($query_4){
        while ($row = mysqli_fetch_assoc($query_4)){
            $result_4[] = $row;
        }
    }


    $sql_5 = "select * from profile";
	$query_5 = mysqli_query($conn,$sql_5);
	$result_5 = array();
     
    // Lấy tên, năm sinh từ profile
    if ($query_5){
        while ($row = mysqli_fetch_assoc($query_5)){
            $result_5[] = $row;
        }
    }


?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Summary</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="../chat/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
        <!-- <style>
            .form #deleteButton {
                margin: 0px;
            }
        </style> -->
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
                        <a class="nav-link" href="supervisor-show.php">Trang chủ</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="supervisor-summary.php">Tổng kết</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="supervisor-profile.php">Hồ sơ cá nhân</a>
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
    
        
        
        

        <div class="homepage table-responsive">
            
            <section class="#"> 
                <strong><i><font size='4'>Xin Chào: </font><span style="color: red"><?php echo $ten;?> - Supervisor</i></span></strong>
                            
                <table class="table table-striped table-borderless table-hover caption-top table2excel">
                    <caption>Tổng kết</caption>
                    <thead class="#">
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Class</th>
                            <th>Student's ID</th>
                            <th>Phone Number</th>
                            <th style="color:Green">Present Count</th> 
                                                  
                        </tr>
                    </thead>

                    <tbody>
                    <?php foreach ($result_4 as $key => $author4){ ?>
                    <tr>
                        <td><?php echo $author4['id']; ?></td>
                        <td><?php 
                        foreach ($result_5 as $key5 => $author5){ 
                                if ($author5['id'] == $author4['id']){
                                    // echo $author5['ten'];
                                    echo $author5['fname']. " " . $author5['lname'];
                                }
                            }
                        ?>
                        </td>

                        <td><?php 
                        foreach ($result_5 as $key5 => $author5){ 
                                if ($author5['id'] == $author4['id']){
                                    echo $author5['department'];
                                }
                            }
                        ?>
                        </td>

                        <td><?php 
                        foreach ($result_5 as $key5 => $author5){ 
                                if ($author5['id'] == $author4['id']){
                                    echo $author5['mssv'];
                                }
                            }
                        ?>
                        </td>

                        <td><?php 
                        foreach ($result_5 as $key5 => $author5){ 
                                if ($author5['id'] == $author4['id']){
                                    echo $author5['sdt'];
                                }
                            }
                        ?>
                        </td>
                        
                         <td><?php
                                        foreach ($result_6 as $key6 => $author6){ 
                                            if ($author6['id'] == $author4['id']){
                                                echo $author6['presentcount'];
                                            }
                                        }
                                    
                                    
                                    ?></td>
                        
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <!--<button id = "button" class="btn btn-success btn-sm">Export</button>-->
                        
            </section>         
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>                                                                                                                
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <!--<script src="js/jquery.table2excel.js"></script>-->
        <!--<script>-->
        <!--    $("#button").click(function(){          -->
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
                   
    </body>    
</html>