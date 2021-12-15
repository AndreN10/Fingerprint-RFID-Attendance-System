<?php

date_default_timezone_set('Asia/Ho_Chi_Minh');

// Biến kết nối toàn cục
global $conn;
 
// Hàm kết nối database
function connect_db()
{
    // Gọi tới biến toàn cục $conn
    global $conn;
     
    // Nếu chưa kết nối thì thực hiện kết nối
    $conn = mysqli_connect("localhost","id17234550_db_username","9%luz8k]DN9|b6gS","id17234550_db_name");

    // Check connection
    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      exit();
    }

    // if (!$conn){
    //     $conn = mysqli_connect('localhost','root','','id16711259_doantotnghiepk17_dbname');
    //     // Thiết lập font chữ kết nối
    //     mysqli_set_charset($conn, 'utf-8');
    // }
}
 
// Hàm ngắt kết nối
function disconnect_db()
{
    // Gọi tới biến toàn cục $conn
    global $conn;
     
    // Nếu đã kêt nối thì thực hiện ngắt kết nối
    if ($conn){
        mysqli_close($conn);
    }
}
 
// Hàm lấy tất cả sinh viên
function get_all_students()
{
    // Gọi tới biến toàn cục $conn
    global $conn;
     
    // Hàm kết nối
    connect_db();
     
    // Câu truy vấn lấy tất cả sinh viên
    $sql = "select * from profile where id != 1000";
     
    // Thực hiện câu truy vấn
    $query = mysqli_query($conn, $sql);
     
    // Mảng chứa kết quả
    $result = array();
     
    // Lặp qua từng record và đưa vào biến kết quả
    if ($query){
        while ($row = mysqli_fetch_assoc($query)){
            $result[] = $row;
        }
    }
     
    // Trả kết quả về
    return $result;
}


 
// Hàm lấy sinh viên theo ID
function get_student($student_id)
{
    // Gọi tới biến toàn cục $conn
    global $conn;
     
    // Hàm kết nối
    connect_db();
     
    // Câu truy vấn lấy tất cả sinh viên
    $sql = "select * from profile where unique_id = $student_id";
     
    // Thực hiện câu truy vấn
    $query = mysqli_query($conn, $sql);
     
    // Mảng chứa kết quả
    $result = array();
     
    // Nếu có kết quả thì đưa vào biến $result
    if (mysqli_num_rows($query) > 0){
        $row = mysqli_fetch_assoc($query);
        $result = $row;
    }
     
    // Trả kết quả về
    return $result;
}
 
// Hàm thêm sinh viên
function add_student($student_id, $student_unique_id, $student_mssv, $student_fname, $student_lname, $student_gioitinh, $student_namsinh,$student_address,$student_department,$student_sdt,$student_taikhoan,$student_matkhau, $student_image, $student_role)
{
    // Gọi tới biến toàn cục $conn
    global $conn;
     
    // Hàm kết nối
    connect_db();
     
    // Chống SQL Injection
    $student_id = addslashes($student_id);
    $student_unique_id = addslashes($student_unique_id);
    $student_mssv = addslashes($student_mssv);
    $student_fname = addslashes($student_fname);
    $student_lname = addslashes($student_lname);
    $student_gioitinh = addslashes($student_gioitinh);
    $student_namsinh = addslashes($student_namsinh);
    $student_address = addslashes($student_address);
    $student_department = addslashes($student_department);
    $student_sdt = addslashes($student_sdt);
    $student_taikhoan = addslashes($student_taikhoan);
    $student_matkhau = addslashes(($student_matkhau));
    $student_image = addslashes(($student_image));
    $student_role = addslashes($student_role);

    // Câu truy vấn thêm
    $sql = "
            INSERT INTO profile(id, unique_id, mssv, fname, lname, gioitinh, namsinh, address, department, sdt, taikhoan, matkhau, img, role) VALUES
            ('$student_id', '$student_unique_id', '$student_mssv', '$student_fname', '$student_lname','$student_gioitinh','$student_namsinh','$student_address','$student_department','$student_sdt','$student_taikhoan','$student_matkhau', '$student_image', '$student_role') ";
     
    // Thực hiện câu truy vấn
    $query = mysqli_query($conn, $sql);
     
    return $query;
}
 
 
// Hàm sửa sinh viên
function edit_student($student_id, $student_fname, $student_lname, $student_gioitinh, $student_namsinh,$student_address,$student_department,$student_taikhoan,$student_sdt,$student_role)
{
    // Gọi tới biến toàn cục $conn
    global $conn;
     
    // Hàm kết nối
    connect_db();
     
    // Chống SQL Injection
    $student_id = addslashes($student_id);
    $student_fname = addslashes($student_fname);
    $student_lname = addslashes($student_lname);
    $student_gioitinh = addslashes($student_gioitinh);
    $student_namsinh = addslashes($student_namsinh);
    $student_address = addslashes($student_address);
    $student_department = addslashes($student_department);
    // $student_email = addslashes($student_email);
    $student_taikhoan = addslashes($student_taikhoan);
    $student_sdt = addslashes($student_sdt);
    $student_role = addslashes($student_role);

     
    // Câu truy sửa
    $sql = "
            UPDATE profile SET
            fname = '$student_fname',
            lname = '$student_lname',
            gioitinh = '$student_gioitinh',
            namsinh = '$student_namsinh',
            address = '$student_address',
            department = '$student_department',
            
            taikhoan='$student_taikhoan',
            sdt='$student_sdt',
            role='$student_role'
            
            WHERE unique_id = $student_id ";
     
    // Thực hiện câu truy vấn
    $query = mysqli_query($conn, $sql);
     
    return $query;
}

// Hàm sửa sinh viên
function setImageFile($student_id, $filename)
{
    // Gọi tới biến toàn cục $conn
    global $conn;
     
    // Hàm kết nối
    connect_db();
     
    // Chống SQL Injection
    $student_id = addslashes($student_id);
    $filename = addslashes($filename);

     
    // Câu truy sửa
    $sql = "
            UPDATE profile SET          
            img = '$filename'
            WHERE unique_id = $student_id ";
     
    // Thực hiện câu truy vấn
    $query = mysqli_query($conn, $sql);
     
    return $query;
}
 

function edit_password($student_id,$student_matkhaumoi)
{
    // Gọi tới biến toàn cục $conn
    global $conn;
     
    // Hàm kết nối
    connect_db();
     
    // Chống SQL Injection
    $student_id = addslashes($student_id);
    $student_matkhaumoi = addslashes($student_matkhaumoi);
     
    $newEncryptedPass = md5($student_matkhaumoi);
    // Câu truy sửa
    $sql = "
            UPDATE profile SET
            matkhau='$newEncryptedPass'
            WHERE unique_id = $student_id ";
     
    // Thực hiện câu truy vấn
    $query = mysqli_query($conn, $sql);
     
    return $query;
} 
// Hàm xóa sinh viên
function delete_student($student_id)
{
    // Gọi tới biến toàn cục $conn
    global $conn;
     
    // Hàm kết nối
    connect_db();
     
    // Câu truy sửa
    $sql = "
            DELETE FROM profile
            WHERE unique_id = $student_id ";
     
    // Thực hiện câu truy vấn
    $query = mysqli_query($conn, $sql);
     
    return $query;
}


function fetch_user_last_activity($user_id, $connect)
{   
     // Gọi tới biến toàn cục $conn
     global $conn;
     
     // Hàm kết nối
     connect_db();

	$sql = "
	SELECT * FROM login_details 
	WHERE user_id = '$user_id' 
	ORDER BY last_activity DESC 
	LIMIT 1
	";
	// $statement = $conn->prepare($query);
	// $statement->execute();
	// $result = $statement->fetchAll();
	// foreach($result as $row)
	// {
	// 	return $row['last_activity'];
	// }


     
    // Thực hiện câu truy vấn
    $query = mysqli_query($conn, $sql);
     
    // Mảng chứa kết quả
    $result = array();
     
    // Lặp qua từng record và đưa vào biến kết quả
    if ($query){
        while ($row = mysqli_fetch_assoc($query)){
            return $row['last_activity'];
        }
    }
    
}

?>