<?php
session_start();
if (!isset($_SESSION['unique_id'])) {
	header("location: index.php");
}

?>
<!DOCTYPE html>
<html>

<head>
	<title>Manage Devices</title>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- <link rel="stylesheet" type="text/css" href="devices.css"> -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="chat/style.css">
	<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" /> -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<script src="js/dev_config.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>
	<script>
		$(window).on("load resize ", function() {
			var scrollWidth = $('.tbl-content').width() - $('.tbl-content table').width();
			$('.tbl-header').css({
				'padding-right': scrollWidth
			});
		}).resize();

		$(document).ready(function() {
			$.ajax({
				url: "dev_up.php",
				type: 'POST',
				data: {
					'dev_up': 1,
				}
			}).done(function(data) {
				$('#devices').html(data);
			});
		});
	</script>
</head>

<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark align-items-start" style="padding-left: var(--bs-gutter-x,.75rem);">
		<div class="container-fluid" style="padding-left: 0;">
			<a class="navbar-brand" style="padding-left: 0;" href="#">HỆ THỐNG ĐIỂM DANH</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link " href="show.php">Trang chủ</a>
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
						<a class="nav-link active"  aria-current="page"  href="devices.php">Thiết bị</a>
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
			<h1>Add a new Device</h1>
			<div class="alert_dev"></div>
			<!-- devices -->
			<div class="row">
				<div class="col-lg-12 mt-4">
					<div class="panel">
						<div class="panel-heading" style="font-size: 19px;">Your Devices:
							<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#new-device" style="font-size: 18px; float: right; margin-top: -6px;">New Device</button>
						</div>
						<div class="panel-body">
							<div id="devices"></div>
						</div>
					</div>
				</div>
			</div>
			<!-- \\devices -->
			<!-- New Devices -->
			<div class="modal fade" id="new-device" tabindex="-1" role="dialog" aria-labelledby="New Device" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h3 class="modal-title" id="exampleModalLongTitle">Add new device:</h3>
							<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form action="" method="POST" enctype="multipart/form-data">
							<div class="modal-body">
								<label for="User-mail"><b>Device Name:</b></label>
								<input type="text" name="dev_name" id="dev_name" placeholder="Device Name..." required /><br>
								<label for="User-mail"><b>Device Department:</b></label>
								<input type="text" name="dev_dep" id="dev_dep" placeholder="Device Department..." required /><br>
							</div>
							<div class="modal-footer">
								<button type="button" name="dev_add" id="dev_add" class="btn btn-success">Create new Device</button>
								<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- //New Devices -->
		</section>
	</div>



</body>

</html>