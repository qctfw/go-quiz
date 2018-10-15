<?php
	require_once 'config/controller.php';
	$c = new Controller();
	if (!$c->cekAjaxLoad()) {
		exit("403 Forbidden");
	}
	$cek = $c->gantiPass($_POST);
	if ($cek == "true") {
		echo "ok";
	}
	elseif ($cek == "wrong") {
		echo $cek;
	}
	else {
		echo "failed";
	}
?>