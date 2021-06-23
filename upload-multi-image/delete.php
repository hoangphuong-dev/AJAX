<?php 
include('../connect.php');
if($_POST['id']) {
	$id = $_POST['id'];
	$name = $_POST['name'];
	$duong_dan_anh = 'uploads/'.$name;
	if(unlink($duong_dan_anh)) {
		$query = mysqli_query($connect, "delete from tbl_image where id = '$id'");
	}
}