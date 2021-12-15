<?php
  date_default_timezone_set('Asia/Ho_Chi_Minh');
  session_start();
  if(isset($_SESSION['unique_id']) || isset($_COOKIE['id'])){
    header("location: show.php");
  }  
?>
<?php
//  echo(md5("admin"));
  // $dbc=mysqli_connect('localhost','root','','id16711259_doantotnghiepk17_dbname');
  // if(!$dbc)
  // {
  //     echo"Kết nối thành công";
  // }
  // else
  // {
  //     mysqli_set_charset($dbc,'utf-8');
  // }
?>
<html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>Login</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
      <link rel="stylesheet" href="chat/style.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
      <style>
        body {
          justify-content: space-around;
        }

        img {
          width:25px;
          height:25px;

        }
      </style>

    </head>
    <body>
      <div class="wrapper">

        <section class="form login">

          <header>Biometric Attendance System</header>

          <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">

            <div class="error-text"></div>

            <div class="field input">
              <label>Username</label>
              <input type="text" name="username" placeholder="Enter your username" required>
            </div>

            <div class="field input">
              <label>Password</label>
              <input type="password" name="password" placeholder="Enter your password" required>
              <i class="fa fa-eye"></i>
            </div>

            <div class="">
              <div class="form-check form-check-inline" >
                <input class="form-check-input" type="radio" name="role" value="1" checked> Admin
                <img src="images/gamer.svg" alt="">
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="role" value="2" > Supervisor
                <img src="images/teacher.svg" alt="">
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="role" value="3" >  User
                <img src="images/students.svg" alt="">
              </div>
            </div>

            <div class="field button">
              <input type="submit" name="submit" value="Login">
            </div>
            <lable style="display: none;" ><input type="checkbox" name="rem" checked value="false" class="mb-3"></lable>
            <lable><input type="checkbox" name="rem" value="true" class="mb-3"> Remember Me </lable>
            
            <p>Tài khoản và mật khẩu là: admin</p>
          </form>

          <!-- <div class="link">Not yet signed up? <a href="index.php">Signup now</a></div> -->

        </section>
      </div>
      
      <script src="chat/pass-show-hide.js"></script>
      <script src="chat/login.js"></script>

    </body>
</html>

