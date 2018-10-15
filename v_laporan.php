<?php
	require_once 'config/controller.php';
	$c = new Controller();
    if (!$c->cekAjaxLoad()) {
        exit("403 Forbidden");
    }
?>
<style>
	#kuis {
		table-layout: fixed;
	}
</style>
<script>
	if (isNotImported('vendor/datatables/datatables.min.css')) {
		$("head").append('<!-- Data Tables -->\n<link rel="stylesheet" href="vendor/datatables/datatables.min.css">');
	}
	if (isNotImported('vendor/datatables/datatables.min.js')) {
		var script = document.createElement('script');
		script.src = "vendor/datatables/datatables.min.js";
		$("body").append(script);
	}
</script>
<div class="container box-shadow bg-white">
	<div class="row">
		<div class="col-md-12">
			<h2 class="my-3">Riwayat Kuis</h2>
			<br />
			<table class="table display responsive" width="100%" id="kuis">
				<thead>
					<tr>
						<td class="min-mobile-p" style="padding: 0; width: 10px;"></td>
						<td class="min-mobile-p" style="width: 100px;">Nama Level</td>
						<?php if (!$c->cekLevel("Siswa")): ?>
						<td class="min-tablet">Nama Siswa</td>
						<?php endif ?>
						<td class="min-tablet">Kesulitan</td>
						<td class="min-tablet">Nyawa</td>
						<td class="min-tablet">Soal</td>
						<td class="min-mobile-p nilai">Nilai</td>
						<td class="min-tablet">Tanggal Kuis</td>
					</tr>
				</thead>
				<tbody>
					<?php
						$no = 1;
						if (!$c->cekLevel("Siswa")) {
							$data = $c->tampilData("v_nilai ORDER BY tgl_nilai DESC");
						}
						else {
							$data = $c->tampilData("v_nilai WHERE id_siswa = '" . $_SESSION['id_anggota'] . "' ORDER BY tgl_nilai DESC");
						}
						if (!is_null($data)) {
							foreach ($data as $row) {
					?>
					<tr>
						<td></td>
						<td><?= $row['nama_level']; ?></td>
						<?php if (!$c->cekLevel("Siswa")): ?>
						<td><?= $row['nama']; ?></td>
						<?php endif ?>
						<td><?= $row['kesulitan']; ?></td>
						<td>
							<span class="d-none"><?= $row['nyawa']; ?></span>
							<?php
		                        // MENAMPILKAN GAMBAR NYAWA
		                        for ($i=1; $i <= 3; $i++) {
		                            echo "<img src='img/heart";
		                            if ($row['nyawa'] < $i) {
		                                echo "-d";
		                            }
		                            echo ".svg' width='30' height='30'>";
		                        }
		                    ?>
						</td>
						<td class="text-center">
							<?= $row['soal_terjawab'] . "\t/\t" . $row['soal_total']; ?>
						</td>
						<td><?= $row['nilai']; ?></td>
						<td><span class="d-none"><?= strtotime($row['tgl_nilai']); ?></span><?= date("d-m-Y H:i:s", strtotime($row['tgl_nilai'])); ?></td>
					</tr>
					<?php
							}
						}
					?>
					
				</tbody>
			</table>
		</div>
	</div>
	<br />
</div>
<script>
	$(function() {
		$("#kuis").dataTable({
			"lengthMenu" : [
				[5,10,25,50,-1],
				[5,10,25,50,"All"]
			],
			responsive: {
	            details: {
	                display: $.fn.dataTable.Responsive.display.ChildRow
	            }
	        },
			"columnDefs" : [{
				"targets": 'no-sort',
				"orderable" : false
			},
			{
	            className: 'control',
	            orderable: false,
	            targets: 0
	        }],

			"order" : [['<?= !$c->cekLevel("Siswa") ? "7" : "6"; ?>', "desc"]],
			"language": {
				"search"	: "Cari :",
				"lengthMenu": "Tampilkan _MENU_ riwayat",
				"zeroRecords": "Riwayat tidak ditemukan",
	    		"emptyTable": "Belum ada riwayat",
	    		"info" : "Menampilkan _START_ / _END_ dari _TOTAL_ riwayat",
	    		"infoEmpty": "Kosong",
	    		"paginate" : {
	    			"first" : "Awal",
	    			"last"  : "Akhir",
	    			"next"  : ">",
	    			"previous" : "<"
	    		}
	    	}
		});
	});
</script>