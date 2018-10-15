<?php 
	require_once "config/controller.php";
	$fungsi = new Controller();
	if (!$fungsi->cekAjaxLoad()) {
		exit("403 Forbidden");
	}
	if(isset($_POST['nama_level'])){ // INSERT
		$id_level = $fungsi->autokode("tb_level","id_level","LV",4);
		$menit = $_POST['waktu-menit'];
		$detik = $_POST['waktu-detik'];
		$waktu = 60 * $menit + $detik;
		$input = $fungsi->insertData("tb_level","'$id_level','" . htmlspecialchars($_POST['nama_level']) . "','" . htmlspecialchars($_POST['kesulitan']) . "','$waktu'");
		if ($input) {
			echo "ok";
		}
		else {
			echo mysqli_error($conn);
			echo "fail";
		}
	}

	if(isset($_POST['hapus'])){ // HAPUS
		$hapus = $fungsi -> deleteData("tb_level","id_level = '" . $_POST['hapus'] . "'");
		if($hapus){
			echo "ok";
		}else{
			echo mysqli_error($conn);
			echo "fail";
		}
	}

	if (isset($_POST['get_edit'])) { // GET DATA FOR UPDATE
		$id = $_POST['id'];
		$edit = $fungsi->tampilData("tb_level WHERE id_level = '$id'")[0];
		$edit['menit'] = floor($edit['waktu'] / 60);
		$edit['detik'] = $edit['waktu'] - ($edit['menit'] * 60);
		echo json_encode($edit);
	}

	if (isset($_POST['update'])) { // UPDATE
		$id = $_POST['id'];
		$nama = htmlspecialchars($_POST['edit-nama_level']);
		$kesulitan = htmlspecialchars($_POST['edit-kesulitan']);
		$menit = $_POST['edit-waktu-menit'];
		$detik = $_POST['edit-waktu-detik'];
		$waktu = 60 * $menit + $detik;
		$update = $fungsi->updateData("tb_level","nama_level='$nama', kesulitan='$kesulitan', waktu='$waktu'","id_level='$id'");
		if($update){
			echo "ok";
		}else{
			echo mysqli_error($conn);
			echo "fail";
		}
	}
?>