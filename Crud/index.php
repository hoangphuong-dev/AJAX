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
	<title>Ajax</title>
	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
	<link rel="shotcut icon" href="../iconapp.ico">
</head>
<body>
	<div class="container">
		<div class="col-md-12">
			<form id="insert_data" method="POST">
				<h3>Chèn dữ kiệu vào trong form</h3>
				<label>Họ và tên</label>
				<input type="text" placeholder="Điền họ và tên.." class="form-control" id="name">
				<label>Số điện thoại</label>
				<input type="text" placeholder="Số điện thoại" class="form-control" id="phone">
				<label>Địa chỉ</label>
				<input type="text" placeholder="Địa chỉ.." class="form-control" id="address">
				<label>Email</label>
				<input type="text" placeholder="Email" class="form-control" id="email">
				<label>Ghi chú</label>
				<input type="text" placeholder="Ghi chú" class="form-control" id="note">
				<br>
				<input id="button_insert" type="button" class="btn btn-success" name="insert_data" value="Insert" >
			</form>
		</div>
		<h3>Load dữ liệu bằng Ajax</h3>
		<div id="load_data">
		</div>
		<div class="col-md-4">
			<h3>Select dữ liệu bằng Ajax</h3>
			<label>Quốc gia</label>
			<select class="form-control" id="quoc_gia" name="quoc_gia">
				<option>-------Chọn quốc gia------</option>
				<?php foreach ($result as $each) { ?>
					<option value="<?php echo $each['id'] ?>"><?php echo $each['name'] ?></option>
				<?php } ?>
			</select>
			<label>Thủ đô</label>
			<select class="form-control" id="thu_do" name="thu_do">
			</select>
		</div>
	</div>
</body>
<script src="../bootstrap/js/bootstrap.js" type="text/javascript"></script>
<script src="../bootstrap/jquery.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#quoc_gia').change(function() {
			let id_quoc_gia = $(this).val();
			$.ajax({
				url : 'action.php',
				type : 'POST',
				data : {id_quoc_gia : id_quoc_gia},
				success:function(data) {
					$('#thu_do').html(data);
					
				}
			});
		})
	})
</script>
<script type="text/javascript">
	$(document).ready(function() {
		function fetch_data() {
			$.ajax({
				url : 'action.php',
				type : 'POST',
				success:function(data) {
					$('#load_data').html(data);
					
				}
			});
		}
		fetch_data();
		// start edit dữ liệu 
		function edit_data(id, text, column_name) {
			$.ajax({
				url : 'action.php',
				type : 'POST',
				data : {
					id: id,
					text: text,
					column_name
				},
				success:function(data) {
					alert('Sửa dữ liệu thành công !');
					fetch_data();
				}
			});
		}
		// sửa tên
		$(document).on('blur','.hovaten', function() {
			let id = $(this).data('id1')
			let text = $(this).text();
			edit_data(id, text, "name");
		})
		// sửa số điện thoại
		$(document).on('blur','.sdt', function() {
			let id = $(this).data('id2')
			let text = $(this).text();
			edit_data(id, text, "phone");
		})
		// sửa email
		$(document).on('blur','.email', function() {
			let id = $(this).data('id3')
			let text = $(this).text();
			edit_data(id, text, "email");
		})
		// sửa địa chỉ
		$(document).on('blur','.dia_chi', function() {
			let id = $(this).data('id4')
			let text = $(this).text();
			edit_data(id, text, "address");
		})
		// sửa ghi chú
		$(document).on('blur','.ghi_chu', function() {
			let id = $(this).data('id5')
			let text = $(this).text();
			edit_data(id, text, "note");
		})
		// end edit dữ liệu 
		// xoá dữ liệu 
		$(document).on('click','.del_data', function() {
			let ma = $(this).data('id6');
			$.ajax({
				url : 'action.php',
				type : 'POST',
				data : {ma: ma},
				success:function(data) {
					alert('Xoá dữ liệu thành công !');
					fetch_data();
				}
			});
		})
		// chèn dữ liệu 
		$('#button_insert').on('click', function(){
			let name = $('#name').val();
			let phone = $('#phone').val();
			let address = $('#address').val();
			let email = $('#email').val();
			let note = $('#note').val();
			if(name != '' && phone != '' && address != '' && email != '' && note != '') {
				$.ajax({
					url : 'action.php',
					type : 'POST',
					data : {
						name: name,
						phone: phone,
						address: address,
						email: email,
						note: note
					},
					success:function(data) {
						alert('Thêm dữ liệu thành công !');
						$('#insert_data')[0].reset();
						fetch_data();
					}
				});
			} else {
				alert('Điền đầy đủ các trường !');
			}
		})
	})
</script>
</html>