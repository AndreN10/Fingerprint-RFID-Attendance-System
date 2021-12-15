<?php
session_start();
if (!isset($_SESSION['unique_id'])) {
    header("location: index.php");
}
?>


<?php
require './libs/students.php';
connect_db();
$students = get_all_students();

// kiểm tra avatar có tồn tại không, không thì set lại về avatar mặc định
foreach ($students as $item) {

    $img = "images\\{$item['img']}";
    error_reporting(E_ERROR | E_PARSE);
    $size_info1 = getimagesize($img);
    $filename = 'user.png';
    if (!$size_info1) {
        setImageFile($item['unique_id'], $filename);
    }
}

// disconnect_db();
if (isset($_SESSION['message'])) {

    $message = $_SESSION['message'];
    echo "<script type='text/javascript'>alert('$message');</script>";
    unset($_SESSION['message']);
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="chat/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />

    <style>
        body .homepage {
            max-width: 1200px;
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
                        <a class="nav-link" href="show.php">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="summary.php">Tổng kết</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  active" aria-current="page" href="student-list.php">Danh sách quản lý</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="ManageUsers2.php">Thêm người dùng</a>
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


    <div class="homepage table-responsive">
        <div class="col-md-12">
            <div class="card mt-4">
                <div class="card-header">
                    <h4>This is a search box, search here bitch! </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-7">

                            <form action="" method="GET">
                                <div class="input-group mb-3">
                                    <input type="text" name="search" required value="<?php if (isset($_GET['search'])) {
                                                                                            echo $_GET['search'];
                                                                                        } ?>" class="form-control" placeholder="Search data">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>



        <section class="">
            <table class="table table-striped table-borderless table-hover caption-top table2excel">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Student/Teacher ID</th>
                        <th>Avatar</th>
                        <th>Full Name</th>
                        <th>Gender</th>
                        <th>Date of Birth</th>
                        <th>Department</th>
                        <th>Address</th>
                        <th>Phone Number</th>
                        <th>Role</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <?php
                // require './libs/students.php';
                // connect_db();
                if (isset($_GET['search'])) {
                    $filtervalues = $_GET['search'];
                    $query = "SELECT * FROM profile WHERE CONCAT(fname,lname,mssv) LIKE '%$filtervalues%' ";
                } else $query = "SELECT * FROM profile where id != 1000 ";
                $query_run = mysqli_query($conn, $query);
                if (mysqli_num_rows($query_run) > 0) {
                ?>

                <?php foreach ($query_run as $item) { ?>
                    <tr>
                        <td><?php echo $item['id']; ?></td>
                        <td><?php echo $item['mssv']; ?></td>

                        <!-- <td>
                            <img width = '60' heigh= '100' src="./anhdaidien/avartar_
                            <?php
                            //  echo $item['id']; 
                            ?>
                            .jpg"/>
                        </td> -->
                        <td><img width='150' src="images/<?php echo $item['img']; ?>" onerror="this.onerror=null;this.src='images/user.png';" /></td>

                        <!-- <img src="php/images/
                        <?php
                        //  echo $row['img']; 
                        ?>" alt=""> -->

                        <td><strong><?php echo $item['fname'] . " " . $item['lname']; ?></strong></td>
                        <td><?php echo $item['gioitinh']; ?></td>
                        <td><?php echo $item['namsinh']; ?></td>
                        <td><?php echo $item['department']; ?></td>
                        <td><?php echo $item['address']; ?></td>
                        <td><?php echo $item['sdt']; ?></td>
                        <td><?php
                            if ($item['role'] === '2')
                                echo ("Supervisor");
                            else if ($item['role'] === '3')
                                echo ("User");
                            ?></td>
                        <td>
                            <div class="btn-group-vertical">
                                <form method="post" action="student-delete.php" class="btn-group-vertical">
                                    <input onclick="window.location = 'student-edit.php?id=<?php echo $item['unique_id']; ?>'" type="button" class="btn btn-success btn-sm" value="Sửa" />
                                    <input type="hidden" name="uid" value="<?php echo $item['unique_id']; ?>" />
                                    <input type="hidden" name="id" value="<?php echo $item['id']; ?>" />
                                    <input onclick="return confirm('Bạn có chắc muốn xóa không?');" class="btn btn-danger btn-sm" type="submit" name="delete" value="Xóa" />
                                </form>
                            </div>

                        </td>
                    </tr>
                <?php } 
                }
                ?>
            </table>

            <!--<button id = "button1" class="btn btn-success btn-sm">Export</button>-->
        </section>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!--<script src="js/jquery.table2excel.js"></script>-->
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
</body>

</html>