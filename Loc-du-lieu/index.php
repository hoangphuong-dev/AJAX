<?php
require_once '../connect.php';
$query_brand = mysqli_query($connect, "select DISTINCT(brand) from products where status = 1 order by id");
$query_ram = mysqli_query($connect, "select DISTINCT(ram) from products where status = 1 order by ram");
$query_storage = mysqli_query($connect, "select DISTINCT(storage) from products where status = 1 order by storage");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Lọc dữ liệu</title>
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
	<link rel="shotcut icon" href="../iconapp.ico">
</head>
<body>
	<div class="container">
		<div class="row">
			<h2 align="center">Sử dụng kĩ thuật lập trình bằng AJAX để lọc dữ liệu</h2>
			<div class="row">
				<div class="col-md-3">
					<h4>Khoảng giá</h4>
					<div class="list-group">
						<input type="hidden" id="hidden_minimun" value="0">
						<input type="hidden" id="hidden_maximun" value="1000000">
						<p id="price_show">Từ 500 nghìn - 100 triệu</p>
						<div id="price_range"></div>
					</div>

					<h3>Thương hiệu</h3>
					<?php foreach ($query_brand as $key => $value) { ?>
						<div class="list-group">
							<div class="list-group-item">
								<input type="checkbox" class="common_selector brand" value="<?php echo $value['brand'] ?>"> <?php echo $value['brand'] ?>
							</div>
						</div>
					<?php } ?>

					<h3>RAM</h3>
					<?php foreach ($query_ram as $key => $value) { ?>
						<div class="list-group">
							<div class="list-group-item">
								<input type="checkbox" class="common_selector ram" value="<?php echo $value['ram'] ?>"> <?php echo $value['ram'] ?> GB
							</div>
						</div>
					<?php } ?>


					<h3>Bộ nhớ trong</h3>
					<?php foreach ($query_storage as $key => $value) { ?>
						<div class="list-group">
							<div class="list-group-item">
								<input type="checkbox" class="common_selector storage" value="<?php echo $value['storage'] ?>"> <?php echo $value['storage'] ?> GB
							</div>
						</div>
					<?php } ?>
				</div>
				<div class="col-md-9">
					<h3 align="center">Tất cả sản phẩm</h3>
					<div class="row filter_data"></div>
				</div>
			</div>
		</div>
	</div>
	

</body>
<script src="../bootstrap/js/bootstrap.js" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		filter_data();
		function filter_data() {
			let minimun_price = $('#hidden_minimun').val();
			let maximun_price = $('#hidden_maximun').val();

			let brand = get_filter('brand');
			let ram = get_filter('ram');
			let storage = get_filter('storage');

			$.ajax({
				url : 'viewdata.php',
				method: 'POST',
				data : {
					minimun_price : minimun_price,
					maximun_price : maximun_price,
					brand : brand,
					ram : ram,
					storage : storage
				}, 
				success:function(data) {
					$('.filter_data').html(data);
				}
			});
		}
		function get_filter(class_name) {
			let filter = [];
			$('.' + class_name + ':checked').each(function() {
				filter.push($(this).val());
			})
			return filter;
		}
		$('.common_selector').click(function() {
			filter_data();
		});

		$('#price_range').slider({
			range : true,
			min : 500000,
			max : 100000000,
			values: [500000, 100000000], 
			step: 500000,
			stop : function(event, ui) {
				$('#price_show').html('Từ :' + ui.values[0] + ' - ' + ui.values[1]);
				$('#hidden_minimun').val(ui.values[0]);
				$('#hidden_maximun').val(ui.values[1]);
				filter_data();
			}
		})

	});
</script>
</html>