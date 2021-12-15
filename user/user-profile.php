<?php 
    session_start();
    if(!isset($_SESSION['unique_id'])){
        header("location: ../index.php");
    }
?>


<?php
// $conn = mysqli_connect('mysql.hostinger.vn','u635041451_tien','qthdhctg','u635041451_test');

// if(!$conn){
//     echo "Kết nối không thành công";
// }
// else
// {
//     mysqli_set_charset($conn,'utf-8');
//     echo "Kết nối thành công";
// }
require '../libs/students.php';
// Lấy thông tin hiển thị lên để người dùng sửa
// $id = isset($_GET['id']) ? (int)$_GET['id'] : '';
$id = $_SESSION['unique_id'];
if ($id){
    
    $data = get_student($id);
    $ten = $data['lname'];
}
 
// Nếu không có dữ liệu tức không tìm thấy sinh viên cần sửa
if (!$data){
   header('Location:supervisor-show.php?id='.$id.'');
}

if (!empty($_POST['edit_student']))
{

  
    // $id = isset($_GET['id']) ? (int)$_GET['id'] : '';

    // Lay data
    $data['matkhau']  = isset($_POST['matkhau']) ? $_POST['matkhau'] : '';
    $data['newPassword']  = isset($_POST['newPassword']) ? $_POST['newPassword'] : '';
    $data['newPasswordSecond']  = isset($_POST['newPasswordSecond']) ? $_POST['newPasswordSecond'] : '';




    $errors = array();

    if($data['newPassword'] != $data['newPasswordSecond'] ) {
        $errors['wrongPassword'] = "<strong><span style='display: inline-block;color: red;'><p class='required'> Passwords didn't match </p></span></strong>"; 
        
    }
    

    if (!$errors){

        

        edit_password($id,$data['newPassword']);
        // Trở về trang danh sách
        header('Location: user-show.php');
        $_SESSION['message'] = "Updated Successfully";
        
    } 
    

        
}

disconnect_db();
?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>User Profile</title>
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
                        <a class="nav-link" href="user-show.php">Trang chủ</a>
                        </li>
                        
                        <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="user-profile.php">Hồ sơ cá nhân</a>
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
            <div id="content">  
                <div class="dinhdang">
                    <h1>Hồ Sơ Cá Nhân</h1>
                    </br>
                    <strong><i><font size='4'>Xin Chào: </font><span style="color: red"><?php echo $ten;?> - User</i></span></strong>
                    <div id="noidung">
                        <form method="post">
                            <table class="table table-striped table2excel">
                                <tr>                                   
                                    <div class="hoverimage">
                                    <td><img width = '250' heigh= '250' src="../images/<?php echo $data['img']; ?>"/></td>
                                    </div>                                   
                                    
                                <tr>
                                    <th>Tên</th>
                                    <td>
                                        <p><?php echo $data['fname']. " " . $data['lname']; ?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Giới Tính</th>
                                    <td>
                                        <p><?php echo $data['gioitinh']; ?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Năm Sinh</th>
                                    <td>
                                        <p><?php echo $data['namsinh']; ?></p>                                    
                                    </td>
                                </tr>
                                <tr>
                                    <th>Địa Chỉ</th>
                                    <td>
                                        <p><?php echo $data['address']; ?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Chức Vụ</th>
                                    <td>
                                        <p><?php echo $data['department']; ?></p>
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <th>Email</th>
                                    <td>
                                        <p>
                                            
                                        </p>
                                    </td>
                                </tr> -->
                                <tr>
                                    <th>Tài Khoản</th>
                                    <td>
                                        <p><?php echo $data['taikhoan']; ?></p>
                                    </td>
                                </tr>
                                
                                <!-- <tr>
                                    <th>Mật Khẩu</th>                                    
                                    <td>
                                        <form method="post" >
                                        <input type="text" name="matkhau" value="
                                        
                                        // echo $data['matkhau']; 
                                       
                                        "/>
                                        <input type="submit" class="btn btn-success" name="edit_password" value="Lưu"/>
                                        </form>
                                    </td>
                                </tr> -->

                                
                                    <tr>
                                        <th>Mật Khẩu Hiện Tại (Đã mã hóa md5)</th>
                                        <td>
                                            <p><?php echo $data['matkhau']; ?></p>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Mật Khẩu Mới</th>
                                        <td>
                                            <input type="password" placeholder="Nhập mật khẩu mới" name="newPassword" value="" required/>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Nhập Lại Mật Khẩu Mới</th>
                                        <td>
                                            <input type="password" placeholder="Nhập mật khẩu mới lần 2" name="newPasswordSecond" value="" required/>
                                             <?php if (!empty($errors['wrongPassword'])) echo $errors['wrongPassword']; ?>

                                            <input type="submit" class="btn btn-success" name="edit_student" value="Lưu"/>
                                        </td>
                                        
                                    </tr>
                                    
                                
                            
                            </table>

                        </form>
                        </br>                        
                        <!-- <button id = "button1" class="btn btn-success btn-sm">Export</button> -->
                        <!-- <script>
                            $("#button1").click(function(){             //có dấu # để phân biệt với button khác
                                $(".table2excel").table2excel({
                                    exclude: ".noExl",
                                    name: "Excel Document Name",
                                    filename: "myFileName",
                                    fileext: ".xls",
                                    exclude_img: true,
                                    exclude_links: true,
                                    exclude_inputs: true
                                });
                            });
                        </script> -->
                        
                    </div>
                </div>  
            </div>               
        </div>  
    </body>    
</html>