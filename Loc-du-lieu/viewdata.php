<?php 
require_once '../connect.php';

if(isset($_POST['minimun_price'])) {
	$query = "select * from products where status = 1 ";

	if(!empty($_POST['minimun_price']) && !empty($_POST['maximun_price'])) {
		$min = $_POST['minimun_price'];
		$max = $_POST['maximun_price'];
		$query .= "and price BETWEEN ".$min. " and ". $max;
	}


	if(isset($_POST['brand'])) {
		$brand = $_POST['brand'];
		$brand_filter = implode("','", $brand);
		$query .= "AND brand IN('".$brand_filter."')";
	}
	if(isset($_POST['ram'])) {
		$ram = $_POST['ram'];
		$ram_filter = implode("','", $ram);
		$query .= "AND ram IN('".$ram_filter."')";
	}
	if(isset($_POST['storage'])) {
		$storage = $_POST['storage'];
		$storage_filter = implode("','", $storage);
		$query .= "AND storage IN('".$storage_filter."')";
	}
	$result = mysqli_query($connect , $query);
	$count = mysqli_num_rows($result);
	$output = '';

	if($count > 0) {
		foreach ($result as $key) {
			$path = "image/".$key['image'];
			$output .= '<div class="col-sm-4 col-lg-4 col-md-4">
			<div style="border: 1px solid black; border-radius: 5px; padding: 16px; margin-bottom: 16px; height:385px">
			<img style="height : 200px;" src='.$path.' class="img-fluid">
			<p align="ceter">'.$key['name'].'</p>
			<h4 style="text-align: center" class="text-danger">Giá :'.$key['price'].'</h4>
			Thương hiệu : '.$key['brand'].'<br>
			Ram : '.$key['ram'].'<br>
			Bộ nhớ trong : '.$key['storage'].'
			</div>
			</div>';
		}

	}  else {
		$output .= '<h3>Không tìm thấy sản phẩm nào</h3>';
	}
	echo $output;
}