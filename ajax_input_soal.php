<?php 
	require_once "config/controller.php";
	$c = new Controller();
	if (!$c->cekAjaxLoad()) {
		exit("403 Forbidden");
	}
    if (!$c->cekLevel("Guru")) {
        exit("Invalid Role");
    }
    if(isset($_POST['soal'])){ // INSERT
        $output = array();
        $id_soal = $c->autokode("tb_soal","id_soal","SA",8);
        $soal = mysqli_real_escape_string($conn, $_POST['soal']);
        $level = htmlspecialchars($_POST['level']);
        $id_anggota = $_SESSION['id_anggota'];
        $jaw_a = htmlspecialchars($_POST['jaw_a']);
        $jaw_b = htmlspecialchars($_POST['jaw_b']);
        $jaw_c = htmlspecialchars($_POST['jaw_c']);
        $jaw_d = htmlspecialchars($_POST['jaw_d']);
        $gambar = $c->uploadGambar($_FILES['gambar'], 'img-soal');
        $gambar = $gambar != "noimage" ? "'$gambar'" : 'null';
        if ($gambar == "toolarge" || $gambar == "invalid") {
            $output['status'] = $gambar;
            exit;
        }
        $insert = "'$id_soal','$level','$id_anggota','$soal','$jaw_a','$jaw_b','$jaw_c','$jaw_d','" . $_POST['jaw_benar'] . "',$gambar,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP";
        $input = $c->insertData("tb_soal",$insert);
        if ($input) {
            $output['response'] = true;
        }
        else {
            $output['response'] = false;
            $output['reason'] = mysqli_error($conn) . "SQL: $insert";
        }
        echo json_encode($output);
    }

    if(isset($_POST['hapus'])){ // HAPUS
        $ambilfoto = $c->tampilData("tb_soal WHERE id_soal = '" . $_POST['hapus'] . "'","gambar")[0]['gambar'];
        $hapus = $c -> deleteData("tb_soal","id_soal = '" . $_POST['hapus'] . "'");
        if (!is_null($ambilfoto)) {
            unlink('img-soal/' . $ambilfoto);
        }
        if($hapus){
            echo "ok";
        }else{
            echo mysqli_error($conn);
            echo "fail";
        }
    }

    if (isset($_POST['detail'])) { // DETAIL
        $detail = $c->tampilData("v_soal WHERE id_soal='" . $_POST['id'] . "'","id_soal, nama_level, kesulitan, deskripsi_soal, jawaban_a, jawaban_b, jawaban_c, jawaban_d, jawaban_benar, gambar, tgl_buat, tgl_modif")[0];
        $detail['tgl_buat'] = $c->diffForHumans($detail['tgl_buat']);
        $detail['tgl_modif'] = $c->diffForHumans($detail['tgl_modif']);
        $detail['error'] = mysqli_error($conn);
        echo json_encode($detail);
    }

    if (isset($_POST['get_edit'])) { // GIVE FOR EDITING
        $detail = $c->tampilData("v_soal WHERE id_soal='" . $_POST['id'] . "'")[0];
        echo json_encode($detail);
    }

    if (isset($_POST['edit'])) { // EDIT
        $output = array();
        $id = $_POST['id'];
        $soal = mysqli_real_escape_string($conn, $_POST['edit-soal']);
        $level = htmlspecialchars($_POST['edit-level']);
        $id_anggota = $_SESSION['id_anggota'];
        $jaw_a = htmlspecialchars($_POST['edit-jaw_a']);
        $jaw_b = htmlspecialchars($_POST['edit-jaw_b']);
        $jaw_c = htmlspecialchars($_POST['edit-jaw_c']);
        $jaw_d = htmlspecialchars($_POST['edit-jaw_d']);
        $jaw_benar = $_POST['edit-jaw_benar'];

        $sql = "id_level='$level',id_guru='$id_anggota', deskripsi_soal='$soal', jawaban_a='$jaw_a', jawaban_b='$jaw_b', jawaban_c='$jaw_c', jawaban_d='$jaw_d', jawaban_benar='$jaw_benar', tgl_modif=CURRENT_TIMESTAMP";
        if (isset($_FILES['gambar'])) {
            $gambar = $c->uploadGambar($_FILES['gambar'], 'img-soal');
            $oldfile = $c->tampilData("tb_soal WHERE id_soal = '$id'","gambar")[0]['gambar'];
            if (!is_null($oldfile)) {
                unlink("img-soal/" . $oldfile);   
            }
            $sql .= ",gambar ='$gambar'";
        }

        $edit = $c->updateData('tb_soal',$sql, "id_soal='$id'");
        if ($edit) {
            $output['response'] = true;
        }
        else {
            $output['response'] = false;
            $output['reason'] = $_POST['soal'];
        }
        echo json_encode($output);
    }

?>