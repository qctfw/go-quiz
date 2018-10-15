<?php 
	session_start();
	try {
		$_SESSION = [];
		session_unset();
		session_destroy();
		setcookie('key1','',time() -3600);
		setcookie('key2','',time() -3600);
	} catch (Exception $e) {
		echo "fail";
		exit;
	}
	echo "ok";
?>