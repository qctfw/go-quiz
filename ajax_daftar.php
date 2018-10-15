<?php
	require_once 'config/controller.php';
	$c = new Controller();
	if (!$c->cekAjaxLoad()) {
		exit("403 Forbidden");
	}
	$anggota = $_POST['anggota'] ?? null;
	$anggota = ucfirst($anggota);
	if (is_null($anggota)) exit;
	if (is_uploaded_file($_FILES['gambar']['tmp_name'])) {
		$register = $c->register($_POST, $anggota, $_FILES['gambar']);
	}
	else {
		$register = $c->register($_POST, $anggota);
	}
	// if (isset($_POST['nip'])) {
	// 	if (is_uploaded_file($_FILES['gambar']['tmp_name'])) {
	// 		$register = $c->register($_POST, "Guru", $_FILES['gambar']);
	// 	}
	// 	else {
	// 		$register = $c->register($_POST, "Guru");
	// 	}
	// }
	// if (isset($_POST['nis'])) {
	// 	if (is_uploaded_file($_FILES['gambar']['tmp_name'])) {
	// 		$register = $c->register($_POST, "Siswa", $_FILES['gambar']);
	// 	}
	// 	else {
	// 		$register = $c->register($_POST, "Siswa");
	// 	}
	// }
	echo json_encode($register);
?>