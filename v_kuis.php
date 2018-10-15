<?php
	require_once 'config/controller.php';
	$c = new Controller();
    if (!$c->cekAjaxLoad() || !$c->cekLevel("Siswa")) {
        exit("403 Forbidden");
    }
?>
<div class="container">
	<h1 class="my-3 text-center">Pilih Kuis</h1>
	<br>
	<div class="row">
		<div class="col-md-3">
			<div class="card">
				<div class="card-header pointer-hover header-hover" id="easy" onclick="kuiscollapse('easy')">
					<div class="row align-items-center">
						<div class="col-8">
							<h1 class="align-middle text-uppercase">Easy</h1>
						</div>
						<div class="col-4 text-right">
							<img src="img/diff/Easy.png" class="grayscale" width="40" height="40">
						</div>
					</div>
				</div>
				<div id="kuiseasy" class="collapse">
					<div class="card-body">
						<?php
							$easy = $c->tampilData("tb_level WHERE kesulitan = 'Easy'");
							$progress['easy'] = $c->getProgress("Easy");
							if (!is_null($easy)) {
								foreach ($easy as $kuis) :
									$selesai = $c->countTable("v_nilai WHERE nilai='100' AND id_siswa='" . $_SESSION['id_anggota'] . "' AND id_level='$kuis[id_level]'");
									if ($selesai > 0) {
										$logo_prefix = "<i class='fa fa-check text-success mr-2'></i> ";
									}
									else {
										$logo_prefix = "<i class='fa fa-dot-circle-o mr-2'></i> ";
									}
						?>
							<div class="pointer-hover h-50 kuis-hover field-kuis" onclick="pilihKuis('<?= $kuis['id_level']; ?>')">
								<h4 class="align-middle field-kuis-text" style=""><?= $logo_prefix . $kuis['nama_level']; ?></h4>
							</div>
							<hr>
						<?php
								endforeach;
						?>
							<div class="field-kuis">
								<h4 class="text-center align-middle">
									<?= "Progress: ".$progress['easy']['progress']."%"; ?>
								</h4>
							</div>
						<?php
							}
							else {
						?>
							<h3 class="align-middle text-center">Belum tersedia</h3>
						<?php
							}
						?>
					</div>		
				</div>

			</div>
		</div>
		<div class="col-md-3">
			<div class="card">
				<div class="card-header pointer-hover header-hover" id="medium" onclick="kuiscollapse('medium')">
					<div class="row align-items-center">
						<div class="col-8">
							<h1 class="align-middle text-uppercase">Medium</h1>
						</div>
						<div class="col-4 text-right">
							<img src="img/diff/Medium.png" class="grayscale" width="40" height="40">
						</div>
					</div>
				</div>
				<div id="kuismedium" class="collapse">
					<div class="card-body">
						<?php
							$medium = $c->tampilData("tb_level WHERE kesulitan = 'Medium'");
							$progress['medium'] = $c->getProgress("Medium");
							if (!is_null($medium)) {
								foreach ($medium as $kuis) :
									$selesai = $c->countTable("v_nilai WHERE nilai='100' AND id_siswa='" . $_SESSION['id_anggota'] . "' AND id_level='$kuis[id_level]'");
									if ($selesai > 0) {
										$logo_prefix = "<i class='fa fa-check text-success mr-2'></i> ";
									}
									else {
										$logo_prefix = "<i class='fa fa-dot-circle-o mr-2'></i> ";
									}
						?>
							<div class="pointer-hover h-50 kuis-hover field-kuis" onclick="pilihKuis('<?= $kuis['id_level']; ?>')">
								<h4 class="align-middle field-kuis-text">
									<?= $logo_prefix . $kuis['nama_level']; ?>
								</h4>
							</div>
							<hr>
						<?php
								endforeach;
						?>
							<div class="field-kuis">
								<h4 class="text-center align-middle">
									<?= "Progress: ".$progress['medium']['progress']."%"; ?>
								</h4>
							</div>
						<?php
							}
							else {
						?>
							<h3 class="align-middle text-center">Belum tersedia</h3>
						<?php
							}
						?>
					</div>			
				</div>

			</div>
		</div>
		<div class="col-md-3">
			<div class="card">
				<div class="card-header pointer-hover header-hover" id="hard" onclick="kuiscollapse('hard')">
					<div class="row align-items-center">
						<div class="col-8">
							<h1 class="align-middle text-uppercase">Hard</h1>
						</div>
						<div class="col-4 text-right">
							<img src="img/diff/Hard.png" class="grayscale" width="40" height="40">
						</div>
					</div>
				</div>
				<div id="kuishard" class="collapse">
					<div class="card-body">
						<?php
							$hard = $c->tampilData("tb_level WHERE kesulitan = 'Hard'");
							$progress['hard'] = $c->getProgress("Hard");
							if (!is_null($hard)) {
								foreach ($hard as $kuis) :
									$selesai = $c->countTable("v_nilai WHERE nilai='100' AND id_siswa='" . $_SESSION['id_anggota'] . "' AND id_level='$kuis[id_level]'");
									if ($selesai > 0) {
										$logo_prefix = "<i class='fa fa-check text-success mr-2'></i> ";
									}
									else {
										$logo_prefix = "<i class='fa fa-dot-circle-o mr-2'></i> ";
									}
						?>
							<div class="pointer-hover h-50 kuis-hover field-kuis" onclick="pilihKuis('<?= $kuis['id_level']; ?>')">
								<h4 class="align-middle field-kuis-text">
									<?= $logo_prefix . $kuis['nama_level']; ?>
								</h4>
							</div>
							<hr>
						<?php
								endforeach;
						?>
							<div class="field-kuis">
								<h4 class="text-center align-middle">
									<?= "Progress: ".$progress['hard']['progress']."%"; ?>
								</h4>
							</div>
						<?php
							}
							else {
						?>
							<h3 class="align-middle text-center">Belum tersedia</h3>
						<?php
							}
						?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="card">
				<div class="card-header pointer-hover header-hover" id="expert" onclick="kuiscollapse('expert')">
					<div class="row align-items-center">
						<div class="col-8">
							<h1 class="align-middle text-uppercase">Expert</h1>
						</div>
						<div class="col-4 text-right">
							<img src="img/diff/Expert.png" class="grayscale" width="40" height="40">
						</div>
					</div>
				</div>
				<div id="kuisexpert" class="collapse">
					<div class="card-body">
						<?php
							$expert = $c->tampilData("tb_level WHERE kesulitan = 'Expert'");
							$progress['expert'] = $c->getProgress("Expert");
							if (!is_null($expert)) {
								foreach ($expert as $kuis) :
									$selesai = $c->countTable("v_nilai WHERE nilai='100' AND id_siswa='" . $_SESSION['id_anggota'] . "' AND id_level='$kuis[id_level]'");
									if ($selesai > 0) {
										$logo_prefix = "<i class='fa fa-check text-success mr-2'></i> ";
									}
									else {
										$logo_prefix = "<i class='fa fa-dot-circle-o mr-2'></i>";
									}
						?>
							<div class="pointer-hover h-50 kuis-hover field-kuis" onclick="pilihKuis('<?= $kuis['id_level']; ?>')">
								<h4 class="align-middle field-kuis-text">
									<?= $logo_prefix . $kuis['nama_level']; ?>
								</h4>
							</div>
							<hr>
						<?php
								endforeach;
						?>
							<div class="field-kuis">
								<h4 class="text-center align-middle">
									<?= "Progress: ".$progress['expert']['progress']."%"; ?>
								</h4>
							</div>
						<?php
							}
							else {
						?>
							<h3 class="align-middle text-center">Belum tersedia</h3>
						<?php
							}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	function pilihKuis(id) {
		jQuery.post('ajax_kuis.php', {pilih: id}, function() {
		  document.location.href = 'kuis.php';
		});
	}
	function kuiscollapse(kuis) {
		$("#kuis" + kuis).collapse('toggle');
		if ($("#" + kuis + " .row .col-md-4 img").hasClass('kuis-active')) {
			$("#" + kuis + " .row .col-md-4 img").removeClass('kuis-active');
		}
		else {
			$("#" + kuis + " .row .col-md-4 img").addClass('kuis-active');
		}
	}
	$("#easy").on('mouseover', function() {
		$("#easy .row .col-md-4 img").removeClass('grayscale');
	}).on('mouseleave', function() {
		$("#easy .row .col-md-4 img").addClass('grayscale');
	});
	$("#medium").on('mouseover', function() {
		$("#medium .row .col-md-4 img").removeClass('grayscale');
	}).on('mouseleave', function() {
		$("#medium .row .col-md-4 img").addClass('grayscale');
	});
	$("#hard").on('mouseover', function() {
		$("#hard .row .col-md-4 img").removeClass('grayscale');
	}).on('mouseleave', function() {
		$("#hard .row .col-md-4 img").addClass('grayscale');
	});
	$("#expert").on('mouseover', function() {
		$("#expert .row .col-md-4 img").removeClass('grayscale');
	}).on('mouseleave', function() {
		$("#expert .row .col-md-4 img").addClass('grayscale');
	});
</script>