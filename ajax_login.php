<?php
	require_once "config/controller.php";
	$c = new Controller();
	if (!$c->cekAjaxLoad()) {
		exit("403 Forbidden");
	}
	$output['response'] = $c->login($_POST['loginUsername'],$_POST['loginPassword']);
    if($output['response']) {
    	$output['name'] = $c->getNama();
    }
    echo json_encode($output);
?>