<?php
    require_once 'config/controller.php';
    $c = new Controller();
    if (!$c->cekAjaxLoad()) {
        exit("403 Forbidden");
    }
    $config = $c->getKonfigurasi();
    $allowed = $config['izinpassword'] == 1 || $c->cekLevel("Admin");
?>
<div class="container">
    <div class="row">
        <?php if ($allowed) { ?>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" id="form-ubahpass">
                        <h1>Ganti Password</h1>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Password Lama</label>
                                    <input type="password" minlength="7" maxlength="50" class="form-control" name="passwordlama" placeholder="Masukkan Password Lama">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Password Baru</label>
                                    <input type="password" class="form-control" name="passwordbaru" placeholder="Masukkan Password Baru">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Konfirmasi Password</label>
                                    <input type="password" class="form-control" name="passwordconfirm" placeholder="Masukkan Password Baru Lagi">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Ubah Password</button>
                    </form>
                </div>
            </div>
        </div>
        <?php
            }
            else {
        ?>
        <div class="col-md-12">
            <p>Anda tidak diizinkan untuk mengganti password. Harap hubungi <strong>administrator</strong> untuk mengganti password Anda.</p>
        </div>
        <?php
            }
        ?>
    </div>
</div>
<?php if ($allowed): ?>
<script>
    function cekKelengkapan(){
        return (
            ($("[name=passwordlama]").val().trim() != "") &&
            ($("[name=passwordbaru]").val().trim() != "") &&
            ($("[name=passwordconfirm]").val().trim() != "")
            );
        }

    $("#form-ubahpass").submit(function(e) {
        e.preventDefault();
        if (cekKelengkapan()) {
            if ($("[name=passwordbaru]").val() == $("[name=passwordconfirm]").val()) {
                $.post("ajax_gantipass.php", $(this).serializeArray(), function(data) {
                    if (data == "ok") {
                        swal("Berhasil!","Password Berhasil diubah!","success").then(function(){document.location.href='?menu=dashboard';});
                    }
                    else if (data == "wrong") {
                        swal("Gagal!","Password lama salah!","warning");
                    }
                    else {
                        swal("Error!","Gagal! Coba lagi.","error");
                    }
                });
            }
            else {
                swal("Gagal!","Password baru dan konfirmasi berbeda!","warning");
            }
            
        }
        else {
            swal("Belum Lengkap!","Harap lengkapi data lalu coba lagi!","warning");
        }
    });
</script>
<?php endif ?>