<?php
    session_start();
    if(!isset($_SESSION['unique_id'])){
        header("location: index.php");
    }
?>
<?php
require './libs/students.php';
// Lấy thông tin hiển thị lên để người dùng sửa
$id = isset($_GET['id']) ? (int)$_GET['id'] : '';
// $id = $_SESSION['unique_id'];
if ($id){
    $data = get_student($id);
}
 
// Nếu không có dữ liệu tức không tìm thấy sinh viên cần sửa
if (!$data){
    header("location: student-list.php");

}

if (!empty($_POST['fileupload'])) {
    // var_dump($_FILES);
    // echo("works");

    try {
        if(empty($_FILES)) {
            throw new Exception('Invalid upload');
        }

        switch ($_FILES['file']['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                throw new Exception('No file uploaded');
                break;
            case UPLOAD_ERR_INI_SIZE:
                throw new Exception('File is too large (from the server settings)');
                break;
            default:
                throw new Exception('An error occurred');

        }

        // Restrict the file size
        if ($_FILES['file']['size'] > 4000000) {
            throw new Exception('File is too large');
        }

        // Restrict the file type
        $mime_types = ['image/gif', 'image/png', 'image/jpeg'];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $_FILES['file']['tmp_name']);

        if ( ! in_array($mime_type, $mime_types)) {

            throw new Exception('Invalid file type');

        }
        
        // Move the uploaded file
        $pathinfo = pathinfo($_FILES["file"]["name"]);

        $base = $pathinfo['filename'];

        // Replace any characters that aren't letters, numbers, underscores or hyphens with an underscore
        $base = preg_replace('/[^a-zA-Z0-9_-]/', '_', $base);

        // Restrict the filename to 200 characters
        $base = mb_substr($base, 0, 200);

        $filename = $base . "." . $pathinfo['extension'];

        $destination = "images/$filename";


        // Add a numeric suffix to the filename to avoid overwriting existing files
        $i = 1;

        while (file_exists($destination)) {

            $filename = $base . "-$i." . $pathinfo['extension'];
            $destination = "images/$filename";

            $i++;
        }


        // move file to folder
        if (move_uploaded_file($_FILES['file']['tmp_name'], $destination)) {

            $previous_image = $data['img'];


            // if succesfully set new image name to the account
            if(setImageFile($data['unique_id'], $filename )) {
                if ($previous_image) {
                    unlink("images/$previous_image"); // delete old image if there is one
                }
                
                header("location: student-list.php");
                $_SESSION['message'] = "Updated Successfully";
            }
            // if there is the old image


            // if ($article->setImageFile($conn, $filename)) {

            //     if ($previous_image) {
            //         unlink("../uploads/$previous_image");
            //     }

            //     Url::redirect("/admin/edit-article-image.php?id={$article->id}");
            // }

        } else {

            throw new Exception('Unable to move uploaded file');

        }



    } catch (Exception $e) {
        echo $e->getMessage();

    }

}

 
// Nếu người dùng submit form
if (!empty($_POST['edit_student']))
{
    // Lay data

    $data['fname']        = isset($_POST['fname']) ? $_POST['fname'] : '';
    $data['lname']        = isset($_POST['lname']) ? $_POST['lname'] : '';
    $data['gioitinh']     = isset($_POST['sex']) ? $_POST['sex'] : '';
    $data['namsinh']      = isset($_POST['birthday']) ? $_POST['birthday'] : '';
    $data['id']           = isset($id) ? $id : '';
    $data['address']      = isset($_POST['address']) ? $_POST['address'] : '';
    $data['department']   = isset($_POST['department']) ? $_POST['department'] : '';
    $data['sdt']   = isset($_POST['sdt']) ? $_POST['sdt'] : '';
    $data['role']   = isset($_POST['role']) ? $_POST['role'] : '';
    // $data['email']          = isset($_POST['email']) ? $_POST['email'] : '';
    $data['taikhoan']     = isset($_POST['taikhoan']) ? $_POST['taikhoan'] : '';
    $data['mssv']     = isset($_POST['mssv']) ? $_POST['mssv'] : '';
   

    // Validate thong tin
    $errors = array();
    

    if (empty($data['fname'])){
        $errors['sv_fname'] = "<strong><span style='display: inline-block;color: red;'><p class='required'> Enter first name </p></span></strong>";
    }

    if (empty($data['lname'])){
        $errors['sv_lname'] = "<strong><span style='display: inline-block;color: red;'><p class='required'> Enter last name </p></span></strong>";;
    }

    if (empty($data['taikhoan'])){
        $errors['sv_username'] = "<strong><span style='display: inline-block;color: red;'><p class='required'> Enter username </p></span></strong>";;
    }
     
    // if (empty($data['gioitinh'])){
    //     $errors['sv_sex'] = 'Chưa nhập giới tính sinh vien';
    // }
     
    // Neu ko co loi thi insert
    if (!$errors){
        edit_student($data['id'], $data['fname'], $data['lname'], $data['gioitinh'], $data['namsinh'],$data['address'],$data['department'],$data['taikhoan'], $data['mssv'], $data['sdt'], $data['role'] );
        // Trở về trang danh sách
        header("location: student-list.php");
        $_SESSION['message'] = "Updated Successfully";
        
    } 
    // else {
    //     // header("location: student-list.php");
    //     $_SESSION['message'] = "Updated Failed";
    // }
}


if (!empty($_POST['edit_password'])) { 
    $data['id']           = isset($id) ? $id : '';
    $data['matkhau']      = isset($_POST['matkhau']) ? $_POST['matkhau'] : '';
    $data['newPassword']  = isset($_POST['newPassword']) ? $_POST['newPassword'] : '';
    $data['newPasswordSecond']  = isset($_POST['newPasswordSecond']) ? $_POST['newPasswordSecond'] : '';

    $errors = array();

    if($data['newPassword'] != $data['newPasswordSecond'] ) {
        $errors['wrongPassword'] = "<strong><span style='display: inline-block;color: red;'><p class='required'> Passwords didn't match </p></span></strong>"; 
        
    }

    // echo($data['newPassword']);
    // echo("<br>");
    // echo($data['newPasswordSecond']);
    // echo("<br>");
    // echo($data['id']);
    // echo("<br>");
    if (!$errors){

        edit_password($data['id'], $data['newPassword']);
        // Trở về trang danh sách
        header("location: student-list.php");
        $_SESSION['message'] = "Updated Successfully";

    }

    
}
 
disconnect_db();
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Student Add</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="chat/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>


    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
        }

        /* Firefox */
        input[type=number] {
        -moz-appearance: textfield;
        }

        body .wrapper {
            display: flex;
            max-width: 700px;
        }

        
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark align-items-start">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Hệ thống điểm danh</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                <a class="nav-link" href="show.php">Trang chủ</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="summary.php">Tổng kết</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="student-list.php">Danh sách quản lý</a>
                </li>
                <li class="nav-item">
                <a class="nav-link " href="student-add.php">Thêm Người Dùng</a>
                </li>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="chat\lienlac.php">Liên lạc</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="dangxuat.php">Đăng xuất</a>
                </li>
            </ul>
            </div>
        </div>
        </nav>

        
        <div class="editPage">  

            <section class="leftBlock">
                <h1>Update avatar</h1>
                <img width = '500' src="images/<?php echo $data['img']; ?>"/>

                <form action="#" method="post" enctype="multipart/form-data">
                    <!-- <div class="field image">
                        <label for="file">Select Image</label>
                        <input type="file" name="file" id="file">
                    </div>
                    <input type="submit" name ="fileupload" class="btn btn-success" value='Upload'> -->
                    <!-- <button  name ="fileupload" class="btn btn-success"> Upload </button> -->


                    <div class="input-group">
                    <input type="file" class="form-control" name="file" id="file" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                    <!-- <button class="btn btn-outline-secondary" name ="fileupload" type="submit"  id="file">Upload</button> -->
                    <input type="submit" name ="fileupload" class="btn btn-outline-secondary" value ="Update">
                    </div>
                </form>


                <div class="underBlock d-flex">
                    <h1>Cập nhật mật khẩu</h1>
                    <form class="row g-3" method="post" action="student-edit.php?id=<?php echo $data['unique_id']; ?>">                   
                        
                        <!-- <div class="col-md-12">
                            <label for="taikhoan" class="form-label">Mật khẩu hiện tại (MD5)</label>
                            <input id="taikhoan" class="form-control" name="taikhoan" value="<?php echo $data['matkhau']; ?>"  > 
                        </div> -->

                        <div class="col-md-12">
                            <label for="newPassword" class="form-label">Nhập mật khẩu mới</label>
                            <input type="password" id="newPassword" class="form-control" name="newPassword"  > 
                            <?php if (!empty($errors['wrongPassword'])) echo $errors['wrongPassword']; ?>
                        </div>

                        <div class="col-md-12">
                            <label for="newPasswordSecond" class="form-label">Xác nhận mật khẩu mới</label>
                            <input type="password" id="newPasswordSecond" class="form-control" name="newPasswordSecond"  > 
                        </div>
                        
                        <!-- <div class="col-12">
                            <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="gridCheck">
                            <label class="form-check-label" for="gridCheck">
                                Check me out
                            </label>
                            </div>
                        </div> -->
                        <div class="col-12">
                            <!-- <button type="submit" name="edit_student" class="btn btn-primary">Save</button> -->
                            <input type="submit" class="btn btn-success" name="edit_password" value="Save"/>
                        </div>

                                
                    </form>
                </div>
                
            </section>

            <section class="rightBlock">
                <h1>Thông tin cơ bản</h1> 
                <form class="row g-3" method="post" action="student-edit.php?id=<?php echo $data['unique_id']; ?>">                   
                    <div class="col-md-6">
                        <label for="fname" class="form-label">Tên</label>
                        <input type="text" class="form-control" id="fname" name="fname" value="<?php echo $data['fname']; ?>">
                        <?php if (!empty($errors['sv_fname'])) echo $errors['sv_fname']; ?>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="lname" class="form-label">Họ</label>
                        <input type="text" class="form-control" id="lname" name="lname" value="<?php echo $data['lname']; ?>">
                        <?php if (!empty($errors['sv_lname'])) echo $errors['sv_lname']; ?>
                    </div>
                   
                    <div class="col-md-6">
                        <label for="sex" class="form-label">Giới tính</label>
                        <select id="sex" class="form-select" name="sex">
                            <option value="Male"<?php if ($data['gioitinh'] == 'Nam') echo 'selected'; ?>>Nam</option>
                            <option value="Female" <?php if ($data['gioitinh'] == 'Nữ') echo 'selected'; ?>>Nữ</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="birthday" class="form-label">Ngày sinh</label>
                        <input type="date" class="form-control" id="birthday" name="birthday" value="<?php echo $data['namsinh']; ?>">
                    </div>

                    <div class="col-12">
                        <label for="address" class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control" id="address" placeholder="1234 Vo Van Ngan" name="address" value="<?php echo $data['address']; ?>">
                    </div>

                    <div class="col-12">
                        <label for="sdt" class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" id="sdt" name="sdt" value="<?php echo $data['sdt']; ?>">
                    </div>
                 
                    <div class="col-md-6">
                        <label for="department" class="form-label">Lớp</label>
                        <input type="text" class="form-control" id="department" name="department" placeholder="Lớp 10" value="<?php echo $data['department']; ?>">
                    </div>

                    <div class="col-md-6">
                        <label for="role" class="form-label">Chức vụ</label>
                        <select id="role" class="form-select" name="role">
                            <option value="2"<?php if ($data['role'] == '2') echo 'selected'; ?>>Supervisor</option>
                            <option value="3" <?php if ($data['role'] == '3') echo 'selected'; ?>>User</option>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label for="mssv" class="form-label">Mã số học sinh</label>
                        <input type="number" id="mssv" class="form-control" name="mssv" value="<?php echo $data['mssv']; ?>"  > 
                    </div>

                    <div class="col-md-12">
                        <label for="taikhoan" class="form-label">Tài khoản</label>
                        <input type="text" id="taikhoan" class="form-control" name="taikhoan" value="<?php echo $data['taikhoan']; ?>"  > 
                    </div>
                    
                    <!-- <div class="col-12">
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="gridCheck">
                        <label class="form-check-label" for="gridCheck">
                            Check me out
                        </label>
                        </div>
                    </div> -->
                    <div class="col-12">
                        <!-- <button type="submit" name="edit_student" class="btn btn-primary">Save</button> -->
                        <input type="submit" class="btn btn-success" name="edit_student" value="Save"/>
                    </div>

                             
                </form>
                

                
            </section>                      
        </div> 



        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>                                                                                                                
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>

</html>