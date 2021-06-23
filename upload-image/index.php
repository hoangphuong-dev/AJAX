<?php 
include('../connect.php');
$sql_quoc_gia = "select * from quoc_gia order by id DESC";
$result = mysqli_query($connect, $sql_quoc_gia);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Upload image</title>
	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
	<link rel="shotcut icon" href="../iconapp.ico">
</head>
<body>
	<div class="container">
		<form id="submit_form" method="POST" action="action_image_file.php" class="form-control">
			<div class="form-control">
				<label>Chọn ảnh :</label>
				<input type="file" name="file" id="image_file">
			</div>
			<input type="submit" class="btn btn-success" value="Uploads">
			<br>
			<h3>Xem trước ảnh</h3>
			<div id="image_preview">
				
			</div>
		</form>
	</div>
</body>
<script src="../bootstrap/js/bootstrap.js" type="text/javascript"></script>
<script src="../bootstrap/jquery.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#submit_form').on('submit', function(event) {
			event.preventDefault();
			$.ajax({
				url : "action_image_file.php",
				type: "POST",
				data: new FormData(this),
				contentType : false,
				processData : false,
				success:function(data) {
					$('#image_preview').html(data);
					$('#image_file').val('');
				}
			});
		})
		$
		$(document).on('click', '#remove_button',function() {
			if(confirm("Bạn có muốn xoá ảnh này không !")) {
				let duong_dan_anh = $(this).data("path");
				$.ajax({
					url : "action_image_file.php",
					type: "POST",
					data: {duong_dan_anh: duong_dan_anh},
					success:function(data) {
						$('#image_preview').html('');
						alert("Đã xoá ảnh ");
					}
				});
			} else {
				return false;
			}
		})
	})
</script>
</html>