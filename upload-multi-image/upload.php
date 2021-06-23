<?php 
include('../connect.php');
if($_FILES['file']['name']) {
	for($count = 0; $count < count($_FILES['file']['name']);$count ++) {
		$file_name = $_FILES["file"]["name"][$count];
		$tmp_name = $_FILES["file"]["tmp_name"][$count];
		$file_array = explode('.', $file_name);
		$file_extension = end($file_array);
		// kiểm tra có ảnh trong ĐB chưa
		// if(file_already_apload($file_name)) {
			$file_name = $file_array[0].'-'.rand().'.'.$file_extension;
		// }
		$location = 'uploads/'.$file_name;
		if(move_uploaded_file($tmp_name, $location)) {
			// nếu tên tạm của trình duyệt lưu đã chuyển đến thư mục upload thì thêm vào ĐB
			$query = mysqli_query($connect,"insert into tbl_image(name) values ('$file_name')");
		}
	}
}

// function file_already_apload($file_name) {
// 	$result = mysqli_query($connect, "select * from tbl_image where name = '$file_name'");
// 	$count_result = mysqli_num_rows($result);
// 	if($count_result == 1) {
// 		return true;
// 	} else {
// 		return false;
// 	}
// }