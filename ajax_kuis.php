<?php
	require_once 'config/controller.php';
	$c = new Controller();
	if (!$c->cekAjaxLoad()) {
		exit("403 Forbidden");
	}
	if (isset($_GET['soal'])) {
		$cek = $c->tampilData("tb_progresskuis WHERE id_siswa = '" . $_SESSION['id_anggota'] . "'")[0];
	    if (!is_null($cek)) {
	        $_SESSION['id_level'] = $cek['id_level'];
	        $_SESSION['nomorsoal'] = $cek['soal_ke'];
	        $_SESSION['nyawa'] = $cek['nyawa'];
	        $idsoal = json_decode($cek['id_soal']);
	        $waktu = $cek['waktu'];
	        unset($_SESSION['id_soal']);
	        foreach ($idsoal as $id_soal) {
	            $_SESSION['id_soal'][] = $id_soal;
	        }
	        $_SESSION['total'] = count($_SESSION['id_soal']);
	    }
	    if (!isset($_SESSION['id_soal'])) { // JIKA BELUM DIKASIH SOAL
	        $_SESSION['nomorsoal'] = 1;
	        $_SESSION['nyawa'] = 3;
	        $idsoal = $c->tampilData("v_soal WHERE id_level = '" . $_SESSION['id_level'] . "' ORDER BY RAND() LIMIT 10","id_soal");
	        foreach ($idsoal as $id_soal) {
	            $_SESSION['id_soal'][] = $id_soal['id_soal'];
	        }
	        $waktu = $c->tampilData("tb_level WHERE id_level = '" . $_SESSION['id_level'] . "'")[0]['waktu'];
	        $_SESSION['total'] = count($_SESSION['id_soal']);

	        $saveprogress = $c->insertData("tb_progresskuis","'" . $_SESSION['id_anggota'] . "','" . $_SESSION['id_level'] . "','" . json_encode($_SESSION['id_soal']) . "','" . $_SESSION['nomorsoal'] . "','" . $_SESSION['nyawa'] . "','$waktu'");
	    }
	    if ($_SESSION['nyawa'] < 1 || $_SESSION['nomorsoal'] > $_SESSION['total']) {
	        $_SESSION['selesai'] = true;
	      	echo json_encode(['selesai' => true]);
	        exit;
	    }
	    $level = $c->tampilData("tb_level WHERE id_level = '" . $_SESSION['id_level'] . "'", "nama_level, waktu")[0];
	    $namalevel = $level['nama_level'];
	    $_SESSION['sisawaktu'] = $level['waktu'];
	    $soal = $c->tampilData("v_soal WHERE id_soal = '" . $_SESSION['id_soal'][$_SESSION['nomorsoal']-1] . "'","id_soal, nama_level, nama, deskripsi_soal, jawaban_a, jawaban_b, jawaban_c, jawaban_d, gambar, tgl_buat, tgl_modif")[0];
	    $soal['tgl_buat'] = $c->diffForHumans($soal['tgl_buat']);
	    $output = array(
	    	'nyawa' => $_SESSION['nyawa'],
	    	'namalevel' => $namalevel,
	    	'nomorsoal' => $_SESSION['nomorsoal'],
	    	'totalsoal' => $_SESSION['total'],
	    	'soal' => $soal,
	    	'waktu' => $waktu
	    );
	    echo json_encode($output);
	}
	if (isset($_POST['waktuhabis'])) {
		$_SESSION['selesai'] = true;
		exit;
	}
	if (isset($_POST['cheated'])) {
		$_SESSION['cheated'] = true;
		echo json_encode(["cheated" => true]);
	}
	if (isset($_POST['waktu'])) {
		if (!@$_SESSION['cheated']) {
			$output = array();
			$_SESSION['cheated'] = false;
			$time = $_POST['waktu'];
			$cektime = $c->tampilData("tb_progresskuis WHERE id_siswa = '" . $_SESSION['id_anggota'] . "'", "waktu")[0]['waktu'];
			if ($cektime < $time) {
				$_SESSION['cheated'] = true;
			}
			$updatewaktu = $c->updateData("tb_progresskuis","waktu = '$time'","id_siswa = '" . $_SESSION['id_anggota'] . "'");

			echo json_encode(["output" => $updatewaktu, "cheated" => $_SESSION['cheated']]);
		}
		else {
			echo json_encode(["cheated" => true]);
		}
	}
	if (isset($_POST['pilih'])) {
		$_SESSION['id_level'] = $_POST['pilih'];
		exit;
	}
	if (isset($_POST['jawaban'])) {
		$time = $_POST['time'];
		$jawaban = $_POST['jawaban'];
		$id_soal = $_POST['idsoal'];
		$jawaban_benar = $c->tampilData("tb_soal WHERE id_soal = '$id_soal'","jawaban_benar")[0]['jawaban_benar'];
		if ($jawaban != $jawaban_benar) {
			$_SESSION['nyawa'] -= 1;
			$output['benar'] = 'false';
		}
		else {
			$_SESSION['nomorsoal'] += 1;
			$output['benar'] = 'true';
			$time = $_SESSION['sisawaktu'];
		}
		$updatewaktu = $c->updateData("tb_progresskuis","soal_ke = '" . $_SESSION['nomorsoal'] . "', waktu = '$time',nyawa = '" . $_SESSION['nyawa'] . "'","id_siswa = '" . $_SESSION['id_anggota'] . "'");
		echo $output['benar'];
	}
?>