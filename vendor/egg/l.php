<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$l = $_POST['l'];
	switch ($l) {
		case 'k1e':
			include 'a.php';
			break;
		case 'k1m':
			include 'mdp.php';
			break;
		default:
			break;
	}
}
?>