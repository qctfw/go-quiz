<?php
    require_once 'config/controller.php';
    $c = new Controller();
    if (!$_SESSION['selesai'] || !isset($_SESSION['selesai'])) {
        echo "Forbidden";
        exit;
    }
    $cek = $c->tampilData("tb_progresskuis WHERE id_siswa = '" . $_SESSION['id_anggota'] . "'")[0];
    $jumlahsoal = $_SESSION['total'];
    $terjawab = $cek['soal_ke'] - 1;
    $nyawa = $cek['nyawa'];
    $level = $c->tampilData("tb_level WHERE id_level = '" . $_SESSION['id_level'] . "'")[0];
    $nilai = ceil(($terjawab / $jumlahsoal) * 100);
    $id_nilai = $c->autokode('tb_nilai','id_nilai','NI',8);
    $sqlinput = "'$id_nilai','" . $_SESSION['id_anggota'] . "','" . $_SESSION['id_level'] . "','$terjawab','$jumlahsoal','$nyawa','$nilai',CURRENT_TIMESTAMP";
    if (!$_SESSION['cheated']) {
        $inputnilai = $c->insertData("tb_nilai",$sqlinput);
    }
    $deleteprogress = $c->deleteData("tb_progresskuis","id_siswa = '" . $_SESSION['id_anggota'] . "'");
    if ((!$_SESSION['cheated'] && !@$inputnilai) || !$deleteprogress) {
        echo mysqli_error($conn);
    }
?>
<?php $c->resetSoal(); ?>
<div class="col-md-4 offset-md-4">
    <div class="card">
        <div class="card-body">
            <div class="mx-auto d-block">
                <h2 class="text-center">Nilai Kamu</h2>
                <br />
                <h1 class="text-center" style="font-size: 50px;"><?= $nilai; ?></h1>
                <br />
                <div class="text-center">
                    <?php
                        // MENAMPILKAN GAMBAR NYAWA
                        for ($i=1; $i <= 3; $i++) {
                            echo "<img class='my-2' id='nyawa-$i' src='img/heart.svg' width='30' height='30'";
                            if ($nyawa < $i) {
                                echo " style='filter:brightness(0%);'";
                            }
                            echo ">";
                        }
                    ?>
                </div>
                <br />
                <table class="table">
                    <tr>
                        <td>Jenis Kuis</td>
                        <td class="text-right"><?= $level['nama_level']; ?></td>
                    </tr>
                    <tr>
                        <td>Kesulitan</td>
                        <td class="text-right"><?= $level['kesulitan']; ?></td>
                    </tr>
                    <tr>
                        <td>Jumlah Soal</td>
                        <td class="text-right"><?= $jumlahsoal; ?></td>
                    </tr>
                    <tr>
                        <td>Terjawab</td>
                        <td class="text-right"><?= $terjawab; ?></td>
                    </tr>
                </table>
                <a href="index.php" class="btn btn-primary btn-block text-white">Kembali Ke Dashboard</a>
            </div>
        </div>
    </div>
</div>
<script>
    $("#waktu").timer('remove');
    $("#waktu").html("");
</script>