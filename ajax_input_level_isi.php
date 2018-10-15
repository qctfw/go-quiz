<?php
    require_once 'config/controller.php';
    $c = new Controller();
	if (!$c->cekAjaxLoad()) {
		exit("403 Forbidden");
	}
    $level = $c->tampilData("tb_level");
?>
<table id="table_level" class="table" style="table-layout: fixed;">
        <thead>
            <tr>
                <td style="width: 1px;"></td>
                <td class="min-tablet">ID</td>
                <td class="min-mobile-p">Nama Level</td>
                <td class="min-tablet">Kesulitan</td>
                <td class="min-tablet">Waktu</td>
                <td class="min-tablet no-sort">Aksi</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach($level as $lv): ?>
            <?php
                $menit = floor($lv['waktu'] / 60);
                $detik = $lv['waktu'] - ($menit * 60);
                $menit = strlen($menit) < 2 ? "0" . $menit : $menit;
                $detik = strlen($detik) < 2 ? "0" . $detik : $detik;
            ?>
                <tr>
                    <td></td>
                    <td><?= $lv['id_level'] ?></td>
                    <td><?= $lv['nama_level'] ?></td>
                    <td><?= $lv['kesulitan'] ?></td>
                    <td><?= $menit . ":" . $detik; ?></td>
                    <td class="text-center">
                        <button type="button" data-level="<?= $lv['id_level']; ?>" class="edit btn btn-primary btn-md"><i class="fa fa-edit"></i></button>
                        <button type="button" data-level="<?= $lv['id_level']; ?>" data-nama="<?= $lv['nama_level']; ?>" class="hapus btn btn-danger btn-md"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
</table>
<div class="modal fade" id="modal-edit_level">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Level</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="edit-level">
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label">Nama Level</label> 
                            <input class="form-control form-control-sm" type="text" name="edit-nama_level" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Kesulitan</label> 
                            <select name="edit-kesulitan" class="form-control form-control-sm" style="height: 40px;">
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
                                    <select name="edit-waktu-menit" class="form-control">
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
                                    <select name="edit-waktu-detik" class="form-control">
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
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnedit">Update Level</button>
            </div>
        </div>
    </div>
</div>
<script>
    $("#table_level").on("click", ".edit", function() {
        $.ajax({
            url: 'ajax_input_level.php',
            type: 'POST',
            dataType: 'json',
            data: {get_edit: 'true', id: $(this).attr('data-level')},
            success: function(data) {
                $("#modal-edit_level").modal();
                $("#edit-level").data('id_level', data.id_level);
                $("[name=edit-nama_level]").val(data.nama_level);
                $("[name=edit-kesulitan] [value=" + data.kesulitan + "]").prop('selected', true);
                $("[name=edit-waktu-menit] [value=" + data.menit + "]").prop('selected', true);
                $("[name=edit-waktu-detik] [value=" + data.detik + "]").prop('selected', true);
            }
        });
    });
    $("#edit-level").submit(function(e) {
        e.preventDefault();
        $.post('ajax_input_level.php', $(this).serialize() + "&" + $.param({update: 'true', id: $("#edit-level").data('id_level')}), function(data) {
            if (data == "ok") {
                $("#modal-edit-level").modal('hide');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
                swal("Berhasil!","Level berhasil diubah!","success");
                $("#data-level").html("<div class='gambarload'></div>");
                $("#data-level").load(location.href + "#isi-soal>*","");
            }
            else {
                swal("Gagal!","Gagal! Coba Lagi.","error");
                console.log(data);
            }
        });
    });
    $("#btnedit").click(function(e) {
        e.preventDefault();
        $("#edit-level").trigger('submit');
    });
    $("#table_level").on("click", ".hapus", function(e) {
        e.preventDefault();
        swal({
            title: "Yakin?",
            html: "Apakah Anda yakin ingin menghapus level <b>" + $(this).attr('data-nama') + "?<br /><b>Seluruh soal untuk level ini akan <span class='text-danger'>ikut terhapus!</span></b>",
            type: "question",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return new Promise((resolve) => {
                    $.post('ajax_input_level.php', {hapus: $(this).attr('data-level')}, function(data) {
                        if (data == "ok") {
                            resolve("true");                            
                        }
                        else {
                            resolve(data);
                        }
                    });
                });
            },
            allowOutsideClick: false
        }).then((result) => {
            if (result.value == "true") {
                swal("Dihapus!","Level berhasil dihapus!","success").then(function(){
                    $("#data-level").html("<div class='gambarload'></div>");
                    $("#data-level").load("ajax_input_level_isi.php");
                });
            }
            else {
                swal("Gagal!","Gagal! coba lagi.", 'error');
                console.log(result.value);
            }
        }); 
    });
    $(function() {
        $("#table_level").DataTable({
            "autoWidth" : true,
            "lengthMenu" : [
                [5,10,25,50,-1],
                [5,10,25,50,"All"]
            ],
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.ChildRow
                }
            },
            "columnDefs" : [
            {
                "targets": 'no-sort',
                "orderable" : false
            },
            {
                className: 'control',
                orderable: false,
                targets: 0
            }
            ],
            "order" : [[1,"asc"]],
            "language": {
                "search"    : "Cari :",
                "lengthMenu": "Tampilkan _MENU_ level",
                "zeroRecords": "Level tidak ditemukan",
                "emptyTable": "Belum ada level",
                "info" : "Menampilkan _START_ / _END_ dari _TOTAL_ level",
                "infoEmpty": "Kosong",
                "paginate" : {
                    "first" : "Awal",
                    "last"  : "Akhir",
                    "next"  : ">",
                    "previous" : "<"
                }
            }
        });
        $('.dataTables_filter input[type="search"]').attr('placeholder','Cari...').css({'width':'200px','display':'inline-block'});
    });
</script>
