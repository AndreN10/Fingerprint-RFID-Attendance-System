<?php
session_start();
if (!isset($_COOKIE['id']) && !isset($_SESSION['unique_id'])) {
    header("location: index.php");
}


?>


<?php
require './libs/students.php';
connect_db();

$sql = "select * from giamsat";
$query = mysqli_query($conn, $sql);

// Mảng chứa kết quả
$result = array();

// Lặp qua từng record và đưa vào biến kết quả
if ($query) {
    while ($row = mysqli_fetch_assoc($query)) {
        $result[] = $row;
    }
}
$sql2 = "select * from profile";
$query2 = mysqli_query($conn, $sql2);
$result2 = array();

// Lặp qua từng record và đưa vào biến kết quả
if ($query) {
    while ($row2 = mysqli_fetch_assoc($query2)) {
        $result2[] = $row2;
    }
}
//    foreach ($result as $key => $author)
//{
//    echo '<li>';
//    echo 'id: ' . $author['id2'] . '<br/>';
//    echo 'thời gian: ' . $author['time'] . '<br/>';
//    echo '</li>';
//}
// $sql3 = "select * from comment";   
// $query3 = mysqli_query($conn, $sql3);    
// $result3 = array();

//     // Lặp qua từng record và đưa vào biến kết quả
//     if ($query3){
//         while ($row3 = mysqli_fetch_assoc($query3)){
//             $result3[] = $row3;
//         }
//     } 

//     if (count($result3) > 0 )
//     {
//         $mess = "<strong><font size='4' color='red'>Thông Báo: </font><span style = 'color :red'>Có ".count($result3)." <a href ='comment-show.php'>Phản Hồi</a> Cần Xử Lý!</span></strong>";
//     }
//     else
//     {
//         $mess = "<strong>Thông Báo:<p style = 'color :red'>Không Có Phản Hồi</p></strong>";
//     }

// mysqli_free_result($query);
// mysqli_free_result($query2);
// mysqli_close($conn);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <!-- <link rel="stylesheet" type="text/css" href="userslog.css"> -->
    <link rel="stylesheet" type="text/css" href="header.css">
    <link rel="stylesheet" href="chat/style.css">
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha1256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="js/bootbox.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script> -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->

    <style>
        .form #deleteButton {
            margin: 0px;
        }

        .form form {
            display: inline;
        }


        .modal-dialog {
            max-width: 650px;
            /* margin: 1.75rem auto; */
        }


        .time {
            display: block;
            position: absolute;
            right: 10%;
            margin-top: -25px;
        }

        .time input {
            position: absolute !important;
            clip: rect(0, 0, 0, 0);
            height: 1px;
            width: 1px;
            border: 0;
            overflow: hidden;
        }

        .time label {
            background-color: #AAA7A7;
            opacity: 0.8;
            color: #000;
            font-size: 14px;
            line-height: 1;
            text-align: center;
            padding: 6px 12px;
            margin-right: -1px;
            border: 1px solid rgba(0, 0, 0, 0.2);
            transition: all 0.1s ease-in-out;
        }

        .time label:hover {
            cursor: pointer;
        }

        .time input:checked+label {
            background-color: #F27827;
            color: #fff;
            box-shadow: none;
            opacity: 1;
        }
    </style>


    <script src="js/user_log.js"></script>
    <script>
        $(document).ready(function() {
            // $.ajax({
            //     url: "user_log_up.php",
            //     type: 'POST',
            //     data: {
            //         'select_date': 1,
            //     }
            // });


            // $.ajax({
            //     url: "user_log_up.php",
            //     type: 'POST',
            //     data: {
            //         'select_date': 0,
            //     }
            // }).done(function(data) {
            //     $('#userslog').html(data);
            // });


            // setInterval(function() {
            //     $.ajax({
            //         url: "user_log_up.php",
            //         type: 'POST',
            //         data: {
            //             'select_date': 0,
            //         }
            //     }).done(function(data) {
            //         $('#userslog').html(data);
            //     });
            // }, 5000);
        });


        $(document).ready(function() {
            $.ajax({
                url: "user_log_up.php",
                type: 'POST',
                data: {
                    'select_date': 1,
                }
            }).done(function(data) {
                $('#userslog').html(data);
            });
        });

        $(document).ready(function() {
            setInterval(function() {
                $.ajax({
                    url: "user_log_up.php",
                    type: 'POST',
                    data: {
                        'select_date': 0,
                    }
                }).done(function(data) {
                    $('#userslog').html(data);
                });
            }, 5000);
        });
    </script>


    <script type="text/javascript">
        function Reset() {
            $('#form')[0].reset();
            $(document).ready(function() {
                $.ajax({
                    url: "user_log_up.php",
                    type: 'POST',
                    data: {
                        'select_date': 1,
                    }
                }).done(function(data) {
                    $('#userslog').html(data);
                });
            });
            $('#Filter-export').modal('hide');
        }
    </script>
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
                        <a class="nav-link active" aria-current="page" href="show.php">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="summary.php">Tổng kết</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="student-list.php">Danh sách quản lý</a>
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
        <section class="form">
            <h1>Here are the Users daily logs</h1>
            <div class="form-style-5">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#Filter-export">
                    Filter Button
                </button>
                <form action="delete.php">
                    <input onclick="return confirm('Bạn có chắc muốn xóa không?');" class="btn btn-danger btn-sm" type="submit" name="delete" value="Test xóa tất cả dữ liệu" />
                </form>
            </div>


            <div class="modal fade " id="Filter-export" tabindex="-1" role="dialog" aria-labelledby="Filter/Export" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered  animate" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="exampleModalLongTitle" style="color: #F27827;">Filter Your User Log:</h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" id="form" style="margin: 0px;" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6">
                                            <div class="panel panel-primary">
                                                <div class="panel-heading">Filter By Date:</div>
                                                <div class="panel-body" 
                                                    style=" border: #f3f3f3 solid 2px;padding: 5px;margin: 5px 0px;">
                                                    <label for="Start-Date"><b>Select from this Date:</b></label>
                                                    <input type="date" name="date_sel_start" id="date_sel_start">
                                                    <label for="End -Date"><b>To End of this Date:</b></label>
                                                    <input type="date" name="date_sel_end" id="date_sel_end">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            <div class="panel panel-primary">
                                                <div class="panel-heading">
                                                    Filter By:
                                                    <div class="time">
                                                        <input type="radio" id="radio-one" name="time_sel" class="time_sel" value="Time_in" checked />
                                                        <label for="radio-one" style="border-radius: 3px;">Time-in</label>
                                                        <input type="radio" id="radio-two" name="time_sel" class="time_sel" value="Time_out" />
                                                        <label for="radio-two" style="border-radius: 3px;">Time-out</label>
                                                    </div>
                                                </div>
                                                <div class="panel-body"
                                                    style=" border: #f3f3f3 solid 2px;padding: 5px;margin: 5px 0px;">
                                                    <label for="Start-Time"><b>Select from this Time:</b></label>
                                                    <input type="time" name="time_sel_start" id="time_sel_start">
                                                    <label for="End -Time"><b>To End of this Time:</b></label>
                                                    <input type="time" name="time_sel_end" id="time_sel_end">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 col-sm-12">
                                            <label for="Fingerprint"><b>Filter By Fingerprint ID:</b></label>
                                            <select class="fing_sel" name="fing_sel" id="fing_sel">
                                                <option value="0">All Users</option>
                                                <?php
                                                // require'connectDB.php';                                          
                                                $sql = "SELECT id FROM profile where id != 0 ORDER BY id ASC";
                                                $result = mysqli_stmt_init($conn);
                                                if (!mysqli_stmt_prepare($result, $sql)) {
                                                    echo '<p class="error">SQL Error</p>';
                                                } else {
                                                    mysqli_stmt_execute($result);
                                                    $resultl = mysqli_stmt_get_result($result);

                                                    while ($row = mysqli_fetch_assoc($resultl)) {
                                                ?>
                                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['id']; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <label for="Device"><b>Filter By Device department:</b></label>
                                            <select class="dev_sel" name="dev_sel" id="dev_sel">
                                                <option value="0">All Departments</option>
                                                <?php
                                                // require 'connectDB.php';
                                                $sql = "SELECT * FROM devices ORDER BY device_dep ASC";
                                                $result = mysqli_stmt_init($conn);
                                                if (!mysqli_stmt_prepare($result, $sql)) {
                                                    echo '<p class="error">SQL Error</p>';
                                                } else {
                                                    mysqli_stmt_execute($result);
                                                    $resultl = mysqli_stmt_get_result($result);
                                                    while ($row = mysqli_fetch_assoc($resultl)) {
                                                ?>
                                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['device_dep']; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <!-- <div class="col-lg-4 col-sm-12">
                                            <label for="Fingerprint"><b>Export to Excel:</b></label>
                                            <input type="submit" name="To_Excel" value="Export">
                                        </div> -->
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" onclick="Reset()" name="reset_filter" id="reset_filter" class="btn btn-danger" data-dismiss="modal">Reset Filter</button>
                                <button type="button" name="user_log" id="user_log" class="btn" style="background-color: #72b4b5;">Filter</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- //Log filter -->

            <div id="userslog"></div>
        </section>

    </div>



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




    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</body>

</html>