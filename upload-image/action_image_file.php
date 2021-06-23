<?php
include '../connect.php';
// upload image 
if($_FILES['file']['name'] != '') {
	$mang_anh = explode(".", $_FILES['file']['name']);
	$duoi_anh = $mang_anh[1]; // mang_anh[0] = tên ảnh
	$duoi_anh_cho_phep = array("jpg", "png", "jpeg", "gif");
	if(in_array($duoi_anh, $duoi_anh_cho_phep)) {
		$ten_moi = rand().".".$duoi_anh;
		$duong_dan_anh = "image/".$ten_moi;
		if(move_uploaded_file($_FILES['file']['tmp_name'], $duong_dan_anh)) {
			echo '
			<div class="col-md-8">
				<img width="200px" height="100px" src="'.$duong_dan_anh.'"  class="img-responsive">
				<div class="col-md-2">
					<button type="button" data-path="'.$duong_dan_anh.'" id="remove_button" class="btn btn-danger">X</button>
				</div>
			</div>';
		}
	} else {
		echo '<script>alert("file ảnh không đúng định dạng")</script>';
	}
} else {
	echo '<script>alert("Bạn chưa chọn file ảnh")</script>'; 
}

if(!empty($_POST['duong_dan_anh'])) {
	unlink($_POST['duong_dan_anh']);
}