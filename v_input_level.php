<?php
    require_once 'config/controller.php';
    $c = new Controller();
    if (!$c->cekAjaxLoad() || !$c->cekLevel("Guru")) {
        exit("403 Forbidden");
    }
?>
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
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3>Input Level</h3>
                </div>
                <form action="ajax_input_level.php" method="post" id="input_level">
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label" for="nama_level">Nama Level</label> 
                            <input class="form-control form-control-sm" type="text" name="nama_level" id="nama_level" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="kesulitan">Kesulitan</label> 
                            <select name="kesulitan" id="kesulitan" class="form-control form-control-sm" style="height: 40px;">
                                <option value="Easy">Easy</option>
                                <option value="Medium">Medium</option>
                                <option value="Hard">Hard</option>
                                <option value="Expert">Expert</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Waktu</label>
                            <div class="row align-items-center align-content-start">
                                <div class="col-4">
                                    <select name="waktu-menit" class="form-control">
                                        <?php for ($i=0; $i <= 10; $i++) { ?>
                                        <option value="<?= $i; ?>">
                                            <?= strlen($i) < 2 ? "0" . $i : $i; ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-1">
                                    <h2 class="font-weight-bold text-center">:</h2>
                                </div>
                                <div class="col-4">
                                    <select name="waktu-detik" class="form-control">
                                        <?php for ($i=0; $i <= 60; $i+=10) { ?>
                                        <option value="<?= $i; ?>">
                                            <?= strlen($i) < 2 ? "0" . $i : $i; ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" name="buat" id="buat" class="btn btn-primary"><i class="fa fa-download mr-1"></i>Buat</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Data Level</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12" id="data-level">
                            <div class="gambarload"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        loadData();
        $('#input_level').submit(function(e){
            e.preventDefault();
            $.ajax({
                type: $(this).attr('method'),
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function(respon){
                    if(respon == 'ok'){
                        swal("Berhasil!","Level berhasil diinput!", "success");
                        $("#data-level").html("<div class='gambarload'></div>");
                        resetForm();
                        loadData();
                    }else {
                        swal('Gagal',"Gagal! Coba Lagi.", "error");
                        console.log(respon);
                    }
                }
            });
        });
        function resetForm(){
            $('[type=text]').val('');
            $('[name=nama_level]').focus();
        }

        function loadData(){
            $("#data-level").load("ajax_input_level_isi.php");
        }
    });

    
</script>