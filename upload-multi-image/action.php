<?php 
include('../connect.php');
// Lấy dữ liệu
$result = mysqli_query($connect, "select * from tbl_image");
$count_result = mysqli_num_rows($result);
$output = '';
$output.= '
	<table width="100%" class="table-bordered table-striped">
		<tr>
			<th>Thứ tự</th>
			<th>Hình ảnh</th>
			<th>Tên</th>
			<th>Mô tả</th>
			<th>Sửa</th>
			<th>Xoá</th>
		</tr>';
if($count_result > 0) {
	$count = 0;
	foreach ($result as $each) {
		$count ++;
		$output.= '
		<tr>
			<td>'.$count.'</td>
			<td><img width="100" height="100" class="img-thumbnail" src="uploads/'.$each['name'].'"></td>
			<td>'.$each['name'].'</td>
			<td>'.$each['description'].'</td>
			<td><button type="button" name="'.$each['name'].'" class="btn-danger btn-xs edit" id="'.$each['id'].'">Sửa</button></td>
			<td><button type="button" name="'.$each['name'].'" class="btn-danger btn-xs delete" id="'.$each['id'].'">Xoá</button></td>
		</tr>';
	}
} else {
	$output.= '
		<tr>
			<td colspan="6">Không có dữ liệu</td>
		</tr>';
}

$output.= '</table>';
echo $output;