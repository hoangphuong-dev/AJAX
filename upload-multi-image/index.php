<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Upload nhiều ảnh bằng AJAX</title>
	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
	<link rel="shotcut icon" href="../iconapp.ico">
</head>
<body>
	<div class="container">
		<h3>Upload nhiều hình ảnh</h3>
		<input type="file" name="multiple_files" id="multiple_files" multiple> <br>
		<span class="text_multiple">Chỉ cho upload : jpg, png, gif, jpeg</span> <br>
		<span id="error_files" style="color: red"></span> <br><br>	
		<div class="table-responsive" id="img_table">
			
		</div>
	</div>

	<!-- Modal -->
	<div id="edit_modal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<form method="POST" id="edit_image_form">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Cập nhật hình ảnh</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label>Tên ảnh</label> 
							<input type="hidden" name="image_id" id="image_id" class="form-control">
							<input type="text" id="image_name" name="image_name" class="form-control" autocomplete="off">
						</div>
						<div class="form-group">
							<label>Mô tả</label>
							<input type="text" id="image_description" name="image_description" class="form-control" autocomplete="off">
						</div>
					</div>
					<div class="modal-footer">
						<input type="submit" class="btn-info" value="Cập nhật">
					</div>
				</div>
			</form>
		</div>
	</div>
</body>
<script src="../bootstrap/js/bootstrap.js" type="text/javascript"></script>
<script src="../bootstrap/jquery.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function() {

		load_image();
		function load_image() {
			$.ajax({
				url : "action.php",
				type : "POST",
				success : function(data) {
					$('#img_table').html(data);
				}
			});
		}

		// up nhiều ảnh
		$('#multiple_files').change(function() {
			let error_image = '';
			let form_data = new FormData();
			let files = $('#multiple_files')[0].files;
			// console.log(files);
			if(files.length > 10) error_image += 'Bạn không được upload quá 10 ảnh';
			else { // kiểm tra ảnh hợp lệ và kích thước ảnh
				for(let i = 0; i < files.length; i++) {
					let name = document.getElementById('multiple_files').files[i].name;
					ext = name.split('.').pop().toLowerCase();
					if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1){
						error_image += '<p>Tập tin thứ '+ Number(i + 1)+' không đúng định dạng</p>'
					}
					let ofReader = new FileReader();
					ofReader.readAsDataURL(document.getElementById('multiple_files').files[i]);
					let f = document.getElementById('multiple_files').files[i];
					let fsize = f.size||f.fileSize;
					if(fsize > 2000000) {
						error_image += '<span>File số '+Number(i + 1)+' quá lớn</span>'
					} else {
						form_data.append("file[]", document.getElementById('multiple_files').files[i])
					}
				}
			}
				// nếu không có lỗi thì cho up ảnh
				if(error_image == '') {
					$.ajax({
						url : "upload.php",
						type : "POST",
						data : form_data,
						contentType: false,
						processData:false,
						cache:false,
						beforeSend: function() {
							$('#error_files').html('Đang tải .....');
						},
						success : function(data) {
							$('#error_files').html('Đã tải thành công');
							load_image();
						}
					})
				} else document.getElementById('error_files').innerHTML = error_image;
			})

		// xoá ảnh 
		$(document).on('click','.delete', function() {
			let id = $(this).attr("id");
			let name = $(this).attr("name");
			if(confirm("Bạn có muốn xoá ảnh này không ? ")) {
				$.ajax({
					url : "delete.php",
					type : "POST",
					data : {
						id: id,
						name: name
					},
					success : function(data) {
						load_image();
					}
				});
			}
		});


		// sửa ảnh
		$(document).on('click','.edit', function() {
			let id = $(this).attr("id");
			$.ajax({
				url : "edit.php",
				type : "POST",
				dataType: "json",
				data:{id:id},	
				success : function(data) {
					$('#edit_modal').modal('show');
					$('#image_id').val(data.image_id);
					$('#image_name').val(data.name_image);
					$('#image_description').val(data.description_image);

				}
			});
		});


		$('#edit_image_form').on('submit', function(event) {
			event.preventDefault();
			if($('#image_name').val() == '') {
				alert('Bạn chưa điền tên !');
			} else {
				$.ajax({
					url : "update.php",
					type : "POST",
					data: $('#edit_image_form').serialize(),
					success : function(data) {
						$('#edit_modal').modal('hide');
						load_image();
						alert('Cập nhật thành công !');
					}
				});
			}
		});

	});
</script>
</html>