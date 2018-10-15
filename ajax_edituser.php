<?php
	require_once 'config/controller.php';
	$c = new Controller();
	if (!$c->cekAjaxLoad()) {
		exit("403 Forbidden");
	}
	$output = array('status' => '' , 'gambar' => '');
	$level = strtolower($_SESSION['level']);
	if (isset($_FILES['gantigambar'])) {
		$gambar = $c->uploadGambar($_FILES['gantigambar']);
		if ($gambar == "toolarge" || $gambar == "invalid") {
			$output['status'] = $gambar;
			exit;
		}
		else {
			$location = "img-db/$gambar";
			$res = $c->cropImage($location, $_POST['x'], $_POST['y'], $_POST['w'], $_POST['h']);
			$oldfile = $c->tampilData("tb_" . $level ." WHERE id_" . $level . " = '" . $_SESSION['id_anggota'] . "'","gambar")[0]['gambar'];
			if ($oldfile != "noprofile.png") {
				unlink("img-db/" . $oldfile);	
			}
			$gantigambar = $c->updateData("tb_" . $level, "gambar='$gambar'","id_" . $level . "='" . $_SESSION['id_anggota'] . "'");
			$gambar_new = $c->tampilData("tb_" . $level ." WHERE id_" . $level . " = '" . $_SESSION['id_anggota'] . "'","gambar")[0]['gambar'];
			if ($gantigambar) {
				$output['status'] = "ok";
				$output['gambar'] = $gambar_new;
			}
			else {
				$output['status'] = "fail";
			}
			echo json_encode($output);
		}
	}
	else {
		$cek = $c->editUser($_POST);
		if ($cek['isUsernameEdit'] || $cek['isDataEdit']) {
			echo "ok";
		}
		elseif ($cek == "already") {
			echo $cek;
		}
		else {
			$error = mysqli_error($conn); // Akan diisi kosong jika user tidak mengubah apapun
			echo $error == "" ? "unedit" : $error;
		}
	}
?>