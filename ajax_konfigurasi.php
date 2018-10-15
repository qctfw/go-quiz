<?php
	require_once 'config/controller.php';
	require_once 'config/favicon.php';
	$c = new Controller();
	if ($_SERVER['REQUEST_METHOD'] != "POST") {
		exit("403 Forbidden");
	}
	if (isset($_POST['config'])) {
		array_walk($_POST,array($c, 'arrayTrim'));
		$output = array();
		$nama_aplikasi = $_POST['nama_aplikasi'];
		$nama_perusahaan = $_POST['nama_perusahaan'];
		$deskripsi = $_POST['deskripsi'];
		$tema = $_POST['tema'];
		$izinpass = $_POST['izinpass'];
		$izinprofil = $_POST['izinprofil'];
		$izinlogoakhir = $_POST['izinlogoakhir'];
		$field = "nama_aplikasi = '$nama_aplikasi', nama_perusahaan = '$nama_perusahaan', deskripsi = '$deskripsi', tema = '$tema', izinpassword = $izinpass , izinprofil = $izinprofil, izinlogoakhir = $izinlogoakhir";
		$update = $c->updateData("tb_konfigurasi", $field, "1");
		$output['response'] = $update;
		if (!$update) {
			$error = mysqli_error($conn); // Akan diisi kosong jika user tidak mengubah apapun
			$output['reason'] = $error == "" ? "unedit" : $error;
		}
		echo json_encode($output);
	}
	elseif (isset($_POST['logo'])) {
		$gambar = $c->uploadGambar($_FILES['gambar'], "img/logo");
		$location = "img/logo/$gambar";
		$logo_location = "img/logo/logo.png";
		$res = $c->cropImage($location, $_POST['x'], $_POST['y'], $_POST['w'], $_POST['h']);
		rename($location, $logo_location);
		$favicon = new PHP_ICO($logo_location, array(array(16,16), array(32,32), array(64,64)));
		$favicon->save_ico('img/favicon.ico');
		$c->updateData("tb_konfigurasi", "last_updated = CURRENT_TIMESTAMP","1");
		$now = strtotime($c->tampilData("tb_konfigurasi","last_updated")[0]['last_updated']);
		echo json_encode(array("result" => $res, "now" => $now));
	}
?>