<?php 
include('../connect.php');

if($_POST['id']) {
	$id = $_POST['id'];
	$query = mysqli_query($connect, "select * from tbl_image where id = '$id'");
	foreach ($query as $key) {
		$file_array = explode('.', $key["name"]); // mảng ảnh
		$output['name_image']  = $file_array[0];
		$output['description_image']  = $key["description"];
		$output['image_id']  = $key["id"];
	}
	echo json_encode($output);
}
