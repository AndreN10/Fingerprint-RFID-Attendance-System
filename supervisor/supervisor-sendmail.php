<?php
session_start();
    if(!isset($_SESSION['uid']))
    {
        header('Location: ../index.php');
    }
?>

<?php

//send_mail.php

require './libs/students.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : '';
if ($id){
    $data = get_student($id);
    $ten = $data['ten'];
}

$students = get_all_students();

disconnect_db();

?>

<?php

function clean_text($string)

{

	$string = trim($string);

	$string = stripslashes($string);

	$string = htmlspecialchars($string);

	return $string;

}

if(isset($_POST["email_data"]))

{

   

    $file = 'attachment/' . basename($_FILES["attachment"]["name"]);

	move_uploaded_file($_FILES["attchment"]["tmp_name"], $file);

	require 'class/class.phpmailer.php';

	$output = '';

	foreach($_POST['email_data'] as $row)

	{

		$mail = new PHPMailer;

		$mail->IsSMTP();								//Sets Mailer to send message using SMTP

		$mail->Host = 'smtp.gmail.com';		//Sets the SMTP hosts of your Email hosting, this for Godaddy

		$mail->Port = '465';								//Sets the default SMTP server port

		$mail->SMTPAuth = true;	//Sets SMTP authentication. Utilizes the Username and Password variables

		$mail->Charset = 'utf-8';

		$mail->Username = 'phucspktk13@gmail.com';					//Sets SMTP username

		$mail->Password = 'tmnyflrgzheouksr';					//Sets SMTP password

		$mail->SMTPSecure = 'ssl';							//Sets connection prefix. Options are "", "ssl" or "tls"

		$mail->From = 'phucspktk13@gmail.com';			//Sets the From email address for the message

		$mail->FromName = 'Phuc Nguyen';					//Sets the From name of the message

		$mail->AddAddress($row["email"], $row["ten"]);	//Adds a "To" address

		$mail->WordWrap = 50;	//Sets word wrapping on the body of the message to a given number of characters

		$mail->IsHTML(true);                            //Sets message type to HTML

		$mail->AddAttachment($attachment);

		$mail->Subject ="INFORMATION"; //Sets the Subject of the message

		//An HTML or plain text message body

		$mail->Body ="<p>THÔNG TIN CẢNH BÁO</p><br /><br /><a href='https://drive.google.com/drive/u/2/my-drive'>CLICK HERE</a>";

		//$students = $mail->Send(); //Send an Email. Return true on success or false on error

        $mail->AltBody = '';	

        if($students = $mail->Send())	//Send an Email. Return true on success or false on error

	    {

		   $output == 'ok';

		   unlink($file);

     	}

       /* if($students["code"] == '400')

	    	{

		    	$output .= html_entity_decode($students['full_error']);

	    	}

	    		if($output == '')

	            {

		            echo 'ok';

	            }

	            else

	            {

	            	echo $output;

	            }*/

	   }  

}

?>



<!DOCTYPE html>

<html>

<head>

    <meta http-equiv="content-type" content="text/html"; charset="utf-8" />

    <title>ĐỒ ÁN TỐT NGHIỆP 2021</title>

    <!--<link rel="stylesheet" href="style.css"/>   -->

    <!--<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">-->

    <!--<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">   -->

    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>-->

    <!--<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>-->
     <link rel="stylesheet" href="style.css"/>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script src="js/jquery.table2excel.js"></script>  

</head>

<body>

    <div id="main">

        <div id="head">

            <!--<h1>TRƯỜNG ĐẠI HỌC SƯ PHẠM KỸ THUẬT TPHCM</h1>-->

            <!--<h2>KHOA ĐIỆN - ĐIỆN TỬ</h2>-->

            <h3>ĐỒ ÁN TỐT NGHIỆP</h3>

            <h4>Năm học 2020-2021</h4>

        </div>

        <div id="menutop">

            <ul class="nav nav-tabs">

                <li><a href="supervisor-show.php?id=<?php echo $id ?>"><span class="glyphicon glyphicon-home"></span> TRANG CHỦ</a></li>

                <li><a href="supervisor-sumary.php?id=<?php echo $id ?>"><span class="glyphicon glyphicon-heart"></span> TỔNG KẾT</a></li>

                <li><a href="supervisor-profile.php?id=<?php echo $id ?>"><span class="glyphicon glyphicon-user"></span> HỒ SƠ CÁ NHÂN</a></li>

                <li><a href="comment-send.php?id=<?php echo $id ?>&name=<?php echo $ten; ?>"target="blank"><span class="glyphicon glyphicon-envelope" ></span> PHẢN HỒI</a></li> 

                <li><a href="supervisor-sendmail.php?id=<?php echo $id ?>"><span class="glyphicon glyphicon-note"></span> THÔNG BÁO</a></li>

                <li><a href="dangxuat.php"><span class="glyphicon glyphicon-log-out"></span> ĐĂNG XUẤT</a> </li>

            </ul>

        </div>

        <div id="maincontent">      

            <div id="content">  

		<div class="dinhdang">

			<h1>THÔNG BÁO SINH VIÊN</h1>

			<br />

			<div class="table-responsive">

				<table class="table table-striped">

					<tr>

						<th>Tên Sinh Viên</th>

						<th>Email</th>

						<th>Select</th>

						<th>Action</th>

				   </tr>

				  

				<?php

				$count = 0;

				foreach($students as $row)

				{

					$count = $count + 1;

					echo '

					<tr>

						<td>'.$row["ten"].'</td>

						<td>'.$row["email"].'</td>

						<td>

							<input type="checkbox" name="single_select" class="single_select" data-email="'.$row["email"].'" data-name="'.$row["ten"].'" />

						</td>

						<td>

						<button type="button" name="email_button" class="btn btn-info btn-xs email_button" id="'.$count.'" data-email="'.$row["email"].'" data-name="'.$row["ten"].'" data-action="single">Send Single</button>

						</td>

						

					</tr>

					';

					

				}

				?>

					<tr>

						<td colspan="3"></td>

						<td><button type="button" name="bulk_email" class="btn btn-info email_button" id="bulk_email" data-action="bulk">Send Bulk</button></td></td>

					</tr>

				</table>

			</div>

		</div>

	</body>

</html>



<script>

$(document).ready(function(){

	$('.email_button').click(function(){

		$(this).attr('disabled', 'disabled');

		var id  = $(this).attr("id");

		var action = $(this).data("action");

		var email_data = [];

		if(action == 'single')

		{

			email_data.push({

				email: $(this).data("email"),

				name: $(this).data("name")

			});

		}

		else

		{

			$('.single_select').each(function(){

				if($(this).prop("checked") == true)

				{

					email_data.push({

						email: $(this).data("email"),

						name: $(this).data("name")

					});

				} 

			});

		}



		$.ajax({

			url:"sendmail.php",

			method:"POST",

			data: {email_data:email_data},

			beforeSend:function(){

				$('#'+id).html('Sending...');

				$('#'+id).addClass('btn-danger');

			},

			success:function(data){

				if(data == 'ok')

				{

					$('#'+id).text('Success');

					$('#'+id).removeClass('btn-danger');

					$('#'+id).removeClass('btn-info');

					$('#'+id).addClass('btn-success');

				}

				else

				{

					$('#'+id).text('Sent');

				}

				$('#'+id).attr('disabled', false);

			}

		})



	});

});

</script>

<?php include('include/footer.php')?>



