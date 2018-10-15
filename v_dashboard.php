<?php
    require_once 'config/controller.php';
    $c = new Controller();
    if (!$c->cekAjaxLoad()) {
        exit("403 Forbidden");
    }
    $id_anggota = $_SESSION['id_anggota'];
    $anggota = null;
    $nomor_induk = null;
    if ($c->cekLevel("Guru")) {
        $anggota = $c->tampilData("tb_guru WHERE id_guru = '$id_anggota'", "nip, nama, jk, tempat_lahir, tanggal_lahir, gambar")[0];
        $anggota['nomor_induk'] = $anggota['nip'];
        $nomor_induk = "NIP";

    }
    elseif ($c->cekLevel("Admin")) {
        $anggota = $c->tampilData("tb_admin WHERE id_admin = '$id_anggota'", "nama, jk, tempat_lahir, tanggal_lahir, gambar")[0];
    }
    else {
        $anggota = $c->tampilData("tb_siswa WHERE id_siswa = '$id_anggota'", "nis, nama, jk, tempat_lahir, tanggal_lahir, gambar")[0];
        $anggota['nomor_induk'] = $anggota['nis'];
        $nomor_induk = "NIS";
    }
?>
<div class="container">
    <div class="ui-typography">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-user"></i><strong class="card-title pl-2">User</strong>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-3 text-center">
                                <img class="rounded-circle mx-auto d-block" src="img-db/<?= $anggota['gambar']; ?>" width="100" height="100">
                                <img src="img/jk/<?= strtoupper($anggota['jk']); ?>.png" width="50" height="50">
                            </div>
                            <div class="col-md-9">
                                    <div class="row">
                                <?php if (isset($anggota['nomor_induk'])): ?>
                                        <div class="col-md-6">
                                            <h3><?= $nomor_induk; ?></h3>
                                            <h4 class="font-weight-normal"><?= $anggota['nomor_induk']; ?></h4>
                                        </div>
                                        <div class="col-md-6">
                                            <h3>Nama</h3>
                                            <h4 class="font-weight-normal"><?= $anggota['nama']; ?></h4>
                                        </div>
                                <?php else: ?>
                                        <div class="col-md-4">
                                            <h3>Nama</h3>
                                            <h4 class="font-weight-normal"><?= $anggota['nama']; ?></h4>
                                        </div>
                                        <div class="col-md-4">
                                            <h3>Tempat Lahir</h3>
                                            <h4 class="font-weight-normal"><?= $anggota['tempat_lahir']; ?></h4>
                                        </div>
                                        <div class="col-md-4">
                                            <h3>Tanggal Lahir</h3>
                                            <h4 class="font-weight-normal"><?= date("d-m-Y", strtotime($anggota['tanggal_lahir'])); ?></h4>
                                    </div>
                                <?php endif ?>
                                    </div>
                                <br />
                                <?php if (!$c->cekLevel("Admin")): ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h3>Tempat Lahir</h3>
                                            <h4 class="font-weight-normal"><?= $anggota['tempat_lahir']; ?></h4>
                                        </div>
                                        <div class="col-md-6">
                                            <h3>Tanggal Lahir</h3>
                                            <h4 class="font-weight-normal"><?= date("d-m-Y", strtotime($anggota['tanggal_lahir'])); ?></h4>
                                        </div>
                                    </div>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($c->cekLevel("Siswa")): ?>
            
        <section class="dashboard-counts bg-white no-padding-bottom no-padding-top has-shadow">
            <div class="row no-padding-bottom">
                <div class="col-md-12">
                    <h1 class="text-center text-uppercase">Progress</h1>
                </div>
            </div>
            <div class="row" style="padding: 30px 0px;">
                <div class="col-md-3">
                    <?php
                        $easy = $c->getProgress("Easy");
                    ?>
                    <div class="item d-flex align-items-center">
                        <div class="icon align-middle"><img src="img/diff/Easy.png" width="40" height="40"></div>
                        <div class="title w-25"><span>Easy</span>
                            <div class="progress">
                                <div role="progressbar" style="width: <?= $easy['progress']."%"; ?>; height: 4px;" aria-valuenow="<?= $easy['progress']; ?>" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-cyan"></div>
                            </div>
                        </div>
                        <div class="number">
                            <strong><?= $easy['progress']."%"; ?></strong>
                            <small style="font-size: 12px;"><?= $easy['selesai']."/".$easy['total']; ?></small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <?php
                        $medium = $c->getProgress("Medium");
                    ?>
                    <div class="item d-flex align-items-center">
                        <div class="icon align-middle"><img src="img/diff/Medium.png" width="40" height="40"></div>
                        <div class="title w-25"><span>Medium</span>
                            <div class="progress">
                                <div role="progressbar" style="width: <?= $medium['progress']."%"; ?>; height: 4px;" aria-valuenow="<?= $medium['progress']; ?>" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-cyan"></div>
                            </div>
                        </div>
                        <div class="number">
                            <strong><?= $medium['progress']."%"; ?></strong>
                            <small style="font-size: 12px;"><?= $medium['selesai']."/".$medium['total']; ?></small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <?php
                        $hard = $c->getProgress("Hard");
                    ?>
                    <div class="item d-flex align-items-center">
                        <div class="icon align-middle"><img src="img/diff/Hard.png" width="40" height="40"></div>
                        <div class="title w-25"><span>Hard</span>
                            <div class="progress">
                                <div role="progressbar" style="width: <?= $hard['progress']."%"; ?>; height: 4px;" aria-valuenow="<?= $hard['progress']; ?>" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-orange"></div>
                            </div>
                        </div>
                        <div class="number">
                            <strong><?= $hard['progress']."%"; ?></strong>
                            <small style="font-size: 12px;"><?= $hard['selesai']."/".$hard['total']; ?></small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <?php
                        $expert = $c->getProgress("Expert");
                    ?>
                    <div class="item d-flex align-items-center">
                        <div class="icon align-middle"><img src="img/diff/expert.png" width="40" height="40"></div>
                        <div class="title w-25"><span>Expert</span>
                            <div class="progress">
                                <div role="progressbar" style="width: <?= $expert['progress']."%"; ?>; height: 4px;" aria-valuenow="<?= $expert['progress']; ?>" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-red"></div>
                            </div>
                        </div>
                        <div class="number">
                            <strong><?= $expert['progress']."%"; ?></strong>
                            <small style="font-size: 12px;"><?= $expert['selesai']."/".$expert['total']; ?></small>
                        </div>
                    </div>
                </div>
            </div>
        </section> 
        <?php endif ?>
    </div>
</div>
<?php if ($c->cekLevel("Siswa") && rand(1,5) == 1): ?>
    <?php if (rand(1, 10) == 7): ?>
        <script>console.log("http://qctfw.esy.es/e/e.txt");</script>
    <?php endif ?>
    <script>
    	if (isNotImported("js/e1_t.js")) {
			var script = document.createElement('script');
			script.src = "js/e1_t.js";
			console.log("success");
			$("body").append(script);
		}
    </script>
<?php endif ?>
