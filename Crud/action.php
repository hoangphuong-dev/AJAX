<?php
include '../connect.php';
// select dữ liệu 
if(isset($_POST['id_quoc_gia'])) {
	$id_quoc_gia = $_POST['id_quoc_gia'];
	$sql_thudo = "select * from thu_do where id_quoc_gia = '$id_quoc_gia'";
	$result_thudo = mysqli_query($connect, $sql_thudo);
	$output_thudo = '';
	$output_thudo .= '<option>-----------Chọn thủ đô---------</option>';
	foreach ($result_thudo as $each) {
		$output_thudo.= '<option value="'.$each['id'].'">'.$each['name'].'</option>';
	}
	echo $output_thudo;

}
// chèn dữ liệu 
if(isset($_POST['name'])) {
	$name = $_POST['name'];
	$phone = $_POST['phone'];
	$address = $_POST['address'];
	$email = $_POST['email'];
	$note = $_POST['note'];

	$sql = "INSERT INTO khach_hang(name, phone, address, email, note) VALUES ('$name', '$phone', '$address', '$email', '$note')";
	$result = mysqli_query($connect, $sql);
}
// edit dữ liệu
if(isset($_POST['id']) && isset($_POST['text'])) {
	$id = $_POST['id'];
	$text = $_POST['text'];
	$column_name = $_POST['column_name'];

	$sql_update = "update khach_hang set $column_name = '$text' where id = '$id'";
	$result = mysqli_query($connect, $sql_update);
}
// Xoá dữ liệu 
if(isset($_POST['ma'])) {
	$id = $_POST['ma'];
	$sql_delete = "delete from khach_hang where id = '$id'";
	$result = mysqli_query($connect, $sql_delete);
}
//lấy dữ liệu
$output = '';
$sql_select  = "select * from khach_hang order by id DESC";
$result = mysqli_query($connect, $sql_select);
$count = mysqli_num_rows($result);
$output .= '  
<div class="table table reponsive">
<table class="table table-bordered">
<tr>
<th>Họ tên</th>
<th>Số điện thoại</th>
<th>Email</th>
<th>Địa chỉ</th>
<th>Ghi chú</th>
<th>Quản lý</th>
</tr>
';

if($count > 0) {
	while($each = mysqli_fetch_array($result)) {
	// td:first : lấy id của khách hàng và tên khách hàng
		$output .= '
		<tr>
		<td data-id1='.$each['id'].' contenteditable class="hovaten">'.$each['name'].'</td> 
		<td data-id2='.$each['id'].' contenteditable class="sdt">'.$each['phone'].'</td>
		<td data-id3='.$each['id'].' contenteditable class="email">'.$each['email'].'</td>
		<td data-id4='.$each['id'].' contenteditable class="dia_chi">'.$each['address'].'</td>
		<td data-id5='.$each['id'].' contenteditable class="ghi_chu">'.$each['note'].'</td>
		<td><button data-id6='.$each['id'].' type="button" name="delete_data" class="btn btn-danger del_data">Xoá</button></td>
		</tr>
		';
	}
} else {
	$output .= '
	<tr>
	<td colspan="5">Chưa có dữ liệu</td>
	</tr>
	';
}
$output .='
</table>
</div>
';

echo $output;
?>
