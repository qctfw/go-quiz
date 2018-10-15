<?php
	require_once '../../config/controller.php';
	$c = new Controller();
	if ($c->cekAjaxLoad() && $c->cekLevel('Siswa')) {
?>
<style>
	.egg-div {
		background: rgba(255,255,255,0.6);
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		z-index: 1000;
	}
	.logo {
		position: absolute;
		margin-top: 240px;
		vertical-align: middle;
		width: 100%;
	}
	.au {
		position: fixed;
		width: 100%;
		bottom: 0;
		left: 0;
		z-index: 1000;
	}
	#egg-play, #egg-close, #egg-control, #egg-mute {
		position: fixed;
		top: 0;
		z-index: 1001;
	}
	.egg-end {
		-webkit-animation: pelangi 1s infinite alternate;
		-o-animation: pelangi 1s infinite alternate;
		animation: pelangi 1s infinite alternate;
		text-shadow: 0 0 1px black, 1px 0 1px black, 0 1px 1px black, 1px 1px 1px black, -1px 0 1px black, 0 -1px 1px black, -1px -1px 1px black;
	}
	@keyframes pelangi {
		  0% {
		    color: blue;
		  }
		  10% {
		    color: #8e44ad;
		  }
		  20% {
		    color: #1abc9c;
		  }
		  30% {
		    color: #d35400;
		  }
		  40% {
		    color: #52E5C1;
		  }
		  50% {
		    color: #34495e;
		  }
		  60% {
		    color: blue;
		  }
		  70% {
		    color: #2980b9;
		  }
		  80% {
		    color: #f1c40f;
		  }
		  90% {
		    color: #E647EC;
		  }
		  100% {
		    color: pink;
		  }
	}
</style>
<audio id="egg" preload="none" style="z-index: 1001;">
	<source src="vendor/egg/1.ini" type="audio/mpeg">
</audio>
<div class="egg-div text-center">
	<button class="btn btn-primary" type="button" id="egg-play">Play</button>
	<button class="btn btn-primary" type="button" id="egg-mute" style="display: none; right: 200px;">Mute</button>
	<button class="btn btn-primary" type="button" id="egg-control" style="display: none; right: 95px;">Pause</button>
	<button class="btn btn-primary" type="button" id="egg-close" style="right: 0;">Close</button>
	<div class="logo text-center">
		<img src="vendor/egg/l.png" style="display: none; max-width: 50%; max-height: 50%;">
		<h2 style="display: none; vertical-align: middle; line-height: 150px;">Made by QCTFW</h2>
		<div class="egg-end text-uppercase" style="font-size: 80px; display: none; vertical-align: middle; line-height: 100px;">
			<p class="font-weight-bold">Abang Abang Arul!</p>
			<p style="font-size: 40px;">QCTFW</p>
			<div class="au text-center">
				<p style="font-size: 10px;"><?= hex2bin("417a686172204174205a61756861722044726970616e61"); ?></p>
			</div>
		</div>
	</div>
</div>
<script>
	if (isNotImported('js/e1.js')) {
		var script = document.createElement("script");
		script.src = "js/e1.js";
		$("#blank").append(script);
	}
</script>
<?php } ?>
