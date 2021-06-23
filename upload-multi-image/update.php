<?php 
include('../connect.php');



if(isset($_POST['image_id'])) {
	$id = $_POST['image_id'];
	$name = $_POST['image_name'];
	$description = $_POST['image_description'];

	$query_select = mysqli_query($connect, "select * from tbl_image where id = '$id'");
	$row = mysqli_fetch_array($query_select);
	$ten_cu = $row['name'];

	$mang_anh = explode('.', $ten_cu);
	$duoi_anh = end($mang_anh);
	$ten_moi = $name.'.'.$duoi_anh;

	if($ten_cu != $ten_moi) {
		$duong_dan_cu = 'uploads/'.$ten_cu;
		$duong_dan_moi = 'uploads/'.$ten_moi;
		if(rename($duong_dan_cu, $duong_dan_moi)) { // ghi đè file mới lên file cũ
			$query = mysqli_query($connect, "update tbl_image set name = '$ten_moi', description  = '$description' where id = '$id'");
		} 
	}
	else {
		$query = mysqli_query($connect, "update tbl_image set description  = '$description' where id = '$id'");
	}
}