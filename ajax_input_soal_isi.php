<?php
    require_once 'config/controller.php';
    $c = new Controller();
    $soal = $c->tampilData("v_soal WHERE id_guru = '" . $_SESSION['id_anggota'] . "' ORDER BY kesulitan, tgl_buat ASC");
	if (!$c->cekAjaxLoad()){
		exit("403 Forbidden");
	}
?>
<table id="table_soal" class="table display responsive" width="100%" style="table-layout: fixed; word-wrap: break-word;">
        <thead>
            <tr>
                <td style="width: 10px;"></td>
                <td class="min-tablet">Nama Level</td>
                <td class="desktop">Kesulitan</td>
                <td class="text-wrap min-mobile-p" style="width: 190px;">Soal</td>
                <td class="desktop" style="width: 120px;">Tanggal</td>
                <td class="desktop no-sort" style="width: 150px;">Aksi</td>
            </tr>
        </thead>
        <tbody>
            <?php
                $asc_diff = array('Easy' => 1,'Medium' => 2, 'Hard' => 3, 'Expert' => 4 );
                if (!is_null($soal)) {
                    foreach($soal as $lv): 
            ?>
                <tr>
                    <td></td>
                    <td><?= $lv['nama_level'] ?></td>
                    <td class="text-center">
                        <img src="img/diff/<?= $lv['kesulitan']; ?>.png" width="40" height="40">
                        <span class="d-none"><?= $asc_diff[$lv['kesulitan']]; ?></span><p><?= $lv['kesulitan'] ?></p>
                    </td>
                    <td class="text-justify"><?= $lv['deskripsi_soal']; ?></td>
                    <td><span class="d-none"><?= date("Y-m-d H:i:s", strtotime($lv['tgl_buat'])); ?></span><?= date("d-m-Y H:i:s", strtotime($lv['tgl_buat'])); ?></td>
                    <td class="text-center">
                        <button type="button" class="detail btn btn-success btn-md" data-soal="<?= $lv['id_soal']; ?>"><i class="fa fa-search"></i></button>
                        <button type="button" class="edit btn btn-primary btn-md" data-soal="<?= $lv['id_soal']; ?>"><i class="fa fa-edit"></i></button>
                        <button type="button" class="hapus btn btn-danger btn-md" data-soal="<?= $lv['id_soal']; ?>"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            <?php
                    endforeach;
                }
            ?>
        </tbody>
</table>
<small class="form-text">Soal yang ditampilkan hanya soal yang dibuat oleh Anda.</small>
<!-- DETAIL SOAL MODAL -->
<div class="modal fade" id="detail-soal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Soal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="gambarload"></div>
                <div class="error text-danger font-weight-bold">
                    <p class='text-center'></p>
                </div>
                <div class="row">
                    <div class="col-6 text-left">
                        <h2>Nama Level</h2>
                        <div class="align-middle" style="line-height: 50px;">
                            <p id="modal-nama_level"></p>
                        </div>
                    </div>
                    <div class="col-6 text-right">
                        <h2>Kesulitan</h2>
                        <div class="align-middle" style="line-height: 50px;">
                            <img id="modal-kesulitan-img" src="img/diff/Easy.png" width="50" height="50"><span style="width: 15px;"></span>
                            <p id="modal-kesulitan" class="float-right align-middle"></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-justify">
                        <h2>Soal</h2>
                        <p id="modal-soal"></p>
                        <p class="text-center">
                            <img src="" id="modal-gambar" style="max-width: 100%; max-height: 100%;">
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h2>Jawaban A</h2>
                        <p class="text-justify jawaban" id="modal-jaw_a"></p>
                    </div>
                    <div class="col-md-6">
                        <h2>Jawaban B</h2>
                        <p class="text-justify jawaban" id="modal-jaw_b"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h2>Jawaban C</h2>
                        <p class="text-justify jawaban" id="modal-jaw_c"></p>
                    </div>
                    <div class="col-md-6">
                        <h2>Jawaban D</h2>
                        <p class="text-justify jawaban" id="modal-jaw_d"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <small class="form-text text-center">Dibuat <span id="modal-tgl_buat"></span></small>
                    </div>
                    <div class="col-6">
                        <small class="form-text text-center">Diubah <span id="modal-tgl_modif"></span></small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <h6 class="text-right">ID Soal:<br /><span id="modal-id_soal"></span></h6>
                <button type="button" class="btn btn-secondary pull-right" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- END DETAIL SOAL MODAL -->

<!-- EDIT SOAL MODAL -->
<div class="modal fade" data-backdrop="static" id="modal-edit-soal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Soal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="gambarload"></div>
                <div class="error text-danger font-weight-bold">
                    <p class="text-center"></p>
                </div>
                <form method="post" id="form-edit-soal">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Deskripsi Soal</label>
                                <textarea contenteditable="true" class="form-control" id="edit-soal" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <img src="" id="edit-prevgambar" style="max-width: 80%; max-height: 80%;"/>
                        </div>
                    </div>
                    <br>
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <label class="btn btn-primary btn-block btn-file">
                            Foto Soal<input type="file" class="d-none" id="edit-gambarsoal">
                            </label>
                        </div>
                        <div class="col-md-9">
                            <label class="form-inline d-inline-block" id="edit-path-gambar">Tidak ada file yang dipilih</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Jenis Kuis</label>
                                <select name="edit-level" class="form-control selectpicker show-tick" data-live-search="true" data-style="border border-primary btn-light" title="Pilih Kuis">
                                    <optgroup label="Easy"></optgroup>
                                    <optgroup label="Medium"></optgroup>
                                    <optgroup label="Hard"></optgroup>
                                    <optgroup label="Expert"></optgroup>
                                    <?php
                                        $jenis = $c->tampilData('tb_level ORDER BY kesulitan, nama_level ASC');
                                        foreach ($jenis as $kuis) {
                                    ?>
                                        <option class="edit-levelnya" value="<?= $kuis['id_level']; ?>" data-kesulitan="<?= $kuis['kesulitan']; ?>"><?= $kuis['nama_level']; ?></option>
                                    <?php       
                                        }
                                    ?>
                                </select>
                                <script>
                                    // Penyortiran kuis berdasarkan level
                                    $(".edit-levelnya").each(function() {
                                        $(this).appendTo('[name=edit-level] optgroup[label=' + $(this).data('kesulitan') + ']');
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jawaban A</label>
                                <input type="radio" value="a" name="edit-jaw_benar" class="radio-template form-check-input pull-right">
                                <textarea class="form-control" name="edit-jaw_a" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jawaban B</label>
                                <input type="radio" value="b" name="edit-jaw_benar" class="radio-template form-check-input pull-right">
                                <textarea class="form-control" name="edit-jaw_b" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jawaban C</label>
                                <input type="radio" value="c" name="edit-jaw_benar" class="radio-template form-check-input pull-right">
                                <textarea class="form-control" name="edit-jaw_c" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jawaban D</label>
                                <input type="radio" value="d" name="edit-jaw_benar" class="radio-template form-check-input pull-right">
                                <textarea class="form-control" name="edit-jaw_d" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div id="loadEdit" class="gambarload align-middle" style="display: inline-block; width: 30px; height: 30px;"></div>
                <button type="button" class="btn btn-primary" id="btnedit">Update Soal</button>
            </div>
        </div>
    </div>
</div>
<!-- END EDIT SOAL MODAL -->
<script>
    $("#loadEdit").css('display', 'none');
    var edit_data, edit_gambar;
    $("[name=edit-level]").selectpicker();
    var edit_soal = CKEDITOR.replace('edit-soal');
    function modalLoading(id, isFinished) {
        $(id + " .modal-dialog .modal-content .modal-body .error p").html('');
        if (isFinished) {
            $(id + " .modal-dialog .modal-content .modal-body .gambarload").hide(0);
            $(id + " .modal-dialog .modal-content .modal-body .row").removeClass('d-none');
        }
        else {
            $(id + " .modal-dialog .modal-content .modal-body .gambarload").show(0);
            $(id + " .modal-dialog .modal-content .modal-body .row").addClass('d-none');
        }
        $(id + " .modal-dialog .modal-content .modal-footer button").prop('disabled', !isFinished);
    }
    $("#table_soal").on("click", ".detail", function(e) {
        $("#detail-soal").modal();
        modalLoading("#detail-soal", false);
        $.ajax({
            url: 'ajax_input_soal.php',
            type: 'POST',
            dataType: 'json',
            data: {detail: 'true', id: $(this).attr('data-soal')},
            success: function(data){
                modalLoading("#detail-soal", true);
                $("#modal-nama_level").html(data.nama_level);
                $("#modal-kesulitan-img").attr("src","img/diff/" + data.kesulitan + ".png");
                $("#modal-kesulitan").html(data.kesulitan);
                $("#modal-soal").html(data.deskripsi_soal);
                if (data.gambar != null) {
                    $("#modal-gambar").removeClass('d-none').attr('src', 'img-soal/' + data.gambar);
                }
                else {
                    $("#modal-gambar").addClass('d-none').attr('src','img/no-image.png');
                };
                $("#modal-jaw_a").html(data.jawaban_a);
                $("#modal-jaw_b").html(data.jawaban_b);
                $("#modal-jaw_c").html(data.jawaban_c);
                $("#modal-jaw_d").html(data.jawaban_d);
                $("#modal-jaw_" + data.jawaban_benar).addClass('text-success font-weight-bold');
                $("#modal-tgl_buat").html(data.tgl_buat);
                $("#modal-tgl_modif").html(data.tgl_modif);
                $("#modal-id_soal").html(data.id_soal);
            }
        }).fail(function(jqXHR) {
            $("#detail-soal .modal-dialog .modal-content .modal-body .gambarload").hide(0);
            $("#detail-soal .modal-dialog .modal-content .modal-body .error p").html('Terjadi kesalahan!\nError Code: ' + jqXHR.status);
        });
    });
    $("#detail-soal").on('hidden.bs.modal', function() {
        $("#modal-nama_level").html("");
        $("#modal-kesulitan").html("");
        $("#modal-soal").html("");
        $("#modal-gambar").addClass('d-none').attr('src','img/no-image.png');
        $("#modal-jaw_a").html("");
        $("#modal-jaw_b").html("");
        $("#modal-jaw_c").html("");
        $("#modal-jaw_d").html("");
        $("#modal-tgl_buat").html("");
        $("#modal-tgl_modif").html("");
        $("#modal-id_soal").html("");
    });
    $("#table_soal").on("click", ".edit", function() {
        $("#modal-edit-soal").modal();
        $("#btnedit").addClass('d-none');
        modalLoading("#modal-edit-soal", false);
        $.ajax({
            url: 'ajax_input_soal.php',
            type: 'POST',
            dataType: 'json',
            data: {get_edit: 'true', id: $(this).attr('data-soal')},
            success: function(data){
                $("#btnedit").removeClass('d-none');
                modalLoading("#modal-edit-soal", true);
                $("#form-edit-soal").data('id_soal', data.id_soal);
                CKEDITOR.instances['edit-soal'].setData(data.deskripsi_soal);
                if (data.gambar != null) {
                    $("#edit-prevgambar").removeClass('d-none').attr('src', 'img-soal/' + data.gambar);
                }
                else {
                    $("#edit-prevgambar").addClass('d-none').attr('src','img/no-image.png');
                };
                $("[name=edit-jaw_a]").val(data.jawaban_a);
                $("[name=edit-jaw_b]").val(data.jawaban_b);
                $("[name=edit-jaw_c]").val(data.jawaban_c);
                $("[name=edit-jaw_d]").val(data.jawaban_d);
                $("[name=edit-jaw_benar]").filter('[value=' + data.jawaban_benar + ']').prop('checked',true);
                $("[name=edit-level]").selectpicker('val',data.id_level);
            }
        }).fail(function(jqXHR) {
            $("#modal-edit-soal .modal-dialog .modal-content .modal-body .gambarload").hide(0);
            $("#modal-edit-soal .modal-dialog .modal-content .modal-body .error p").html('Terjadi kesalahan!\nError Code: ' + jqXHR.status);
        });
        $("#modal-edit-soal").on('hidden.bs.modal', function() {
            $("#modal-edit-soal .modal-dialog .modal-content .modal-body .row").addClass('d-none');
            $("#btnedit").addClass('d-none');
            $("#form-edit-soal").data('id_soal', '');
            CKEDITOR.instances['edit-soal'].setData('');
            $("#edit-prevgambar").addClass('d-none').attr('src','img/no-image.png');
            $("[name=edit-jaw_a]").val('');
            $("[name=edit-jaw_b]").val('');
            $("[name=edit-jaw_c]").val('');
            $("[name=edit-jaw_d]").val('');
            $("[name=edit-level]").selectpicker('val','');
        });
        
    });
    function previewGambarEdit(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            var img = new Image;
            img.onload = function() {
                $('#edit-prevgambar').attr('width', (img.width / 3) + 'px');
                $('#edit-prevgambar').attr('height', (img.height / 3) + 'px');
            };
            img.src = reader.result;
            $('#edit-prevgambar').attr('src', e.target.result);
            
        }

        reader.readAsDataURL(input.files[0]);
      }
    }
    $("#edit-gambarsoal").change(function() {
        edit_gambar = this.files[0];
        if (edit_gambar.size > 1048576) {
            swal("Terlalu Besar!", "Ukuran gambar maksimal adalah 1 MB", "warning");
            $(this).val('');
        }
        else {
            var filename = $(this).val();
            var allow_ext = ['.jpg', '.jpeg', '.png', '.bmp'];
            var ext = filename.substring(filename.lastIndexOf('.')).toLowerCase();
            if ($.inArray(ext, allow_ext) == -1) {
                swal("File tidak valid!", "File yang diperbolehkan adalah JPG, JPEG, PNG, BMP", "warning");
                $(this).val('');
            }
            else {
                $("#edit-prevgambar").removeClass('d-none');
                $("#edit-path-gambar").html(edit_gambar.name);
                previewGambarEdit(this);
            }
        }
    });
    function cekKelengkapanEdit() {
        return (
            ($("#form-edit-soal").data('id_soal') != "") &&
            (CKEDITOR.instances['edit-soal'].getData() != "") && 
            ($("[name=edit-jaw_a]").val() != "") && 
            ($("[name=edit-jaw_b]").val() != "") &&
            ($("[name=edit-jaw_c]").val() != "") &&
            ($("[name=edit-jaw_d]").val() != "") &&
            ($("[name=edit-jaw_benar] :selected").val() != "") &&
            ($("[name=edit-level]").val() != "kosong")
        );
    }

    $("#form-edit-soal").submit(function(e) {
        e.preventDefault();
        if (cekKelengkapanEdit()) {
            $("#form-edit-soal").find('input, textarea').prop('readonly',true);
            $("#btnedit").prop("disabled", true);
            $("#loadEdit").css('display', 'none');
            edit_data = new FormData(this);
            edit_data.append('edit-soal',CKEDITOR.instances['edit-soal'].getData());
            edit_data.append('edit','true');
            edit_data.append('gambar', edit_gambar);
            edit_data.append('id',$("#form-edit-soal").data('id_soal'));
            $.ajax({
                url: 'ajax_input_soal.php',
                type: 'POST',
                dataType: 'json',
                data: edit_data,
                contentType: false,
                cache: false,
                processData:false,
                success: function(data) {
                    if (data['response']) {
                        swal("Berhasil!","Soal berhasil diubah!","success");
                        $("#modal-edit-soal").modal('hide');
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        $("#isi-soal").html("<div class='gambarload'></div>");
                        $("#isi-soal").load(location.href + "#isi-soal>*","");
                    }
                    else {
                        swal("Gagal!","Gagal! Coba Lagi.","error");
                        console.log(data);
                    }
                }
            });
            $("#form-edit-soal").find('input, textarea').prop('readonly',true);
            $("#btnedit").prop("disabled", true);
            $("#loadEdit").css('display', 'inline-block');
        }
        else {
            swal("Belum Lengkap!", "Harap lengkapi data lalu coba lagi.", "warning");
        }
    });

    $("#btnedit").click(function() {
        $("#form-edit-soal").trigger('submit');
    });

    $("#detail-soal").on('hidden.bs.modal', function() {
        $(".jawaban").removeClass('text-success font-weight-bold');
    });
    $("#modal-edit-soal").on('hidden.bs.modal', function() {
        $("#edit-prevgambar").attr('src', 'img/no-image.png');
        $("#edit-gambarsoal").val('');
        $("#edit-path-gambar").html('Tidak ada file yang dipilih');
    });

    $("#table_soal").on("click", ".hapus", function(e) {
        e.preventDefault();
        swal({
            title: "Yakin?",
            text: "Apakah Anda yakin ingin menghapus soal ini?",
            type: "question",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
        }).then((result) => {
              if (result.value) {
                $.post('ajax_input_soal.php', {hapus: $(this).attr('data-soal')}, function(data) {
                    if (data == "ok") {
                        swal("Dihapus!","Soal berhasil dihapus!","success").then(function(){
                            $("#isi-soal").html("<div class='gambarload'></div>");
                            $("#isi-soal").load("ajax_input_soal_isi.php");
                        });
                    }
                    else {
                        swal("Gagal!","Gagal! coba lagi.", 'error');
                        console.log(data);
                    }
                });
              }
        });
    });
    $(function() {
        $("#table_soal").DataTable({
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
            }
            ],
            "order" : [[2, "asc"]],
            "language": {
                "search"    : "Cari :",
                "lengthMenu": "Tampilkan _MENU_ soal",
                "zeroRecords": "Soal tidak ditemukan",
                "emptyTable": "Belum ada soal",
                "info" : "Menampilkan _START_ / _END_ dari _TOTAL_ soal",
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
