<?php
	require_once 'config/controller.php';
	$c = new Controller();
	$config = $c->tampilData("tb_konfigurasi")[0];
?>
<style>
	.jcrop-keymgr {
		display: none;
		opacity: 0;
	}
	.jcrop-centered {
		display: inline-block;
	}
	#preview-pane .preview-container {
		width: 200px;
		height: 200px;
		overflow: hidden;
	}
	.jcrop-holder #preview-pane {
		display: block;
		z-index: 2000;
		top: 10px;
		right: -280px;
		padding: 6px;
		border: 1px rgba(0,0,0,.4) solid;
		background-color: white;

		-webkit-border-radius: 6px;
		-moz-border-radius: 6px;
		border-radius: 6px;

		-webkit-box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
		-moz-box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
		box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
	}
</style>
<script>
	if (isNotImported('vendor/jcrop/css/jquery.Jcrop.min.css')) {
		$("head").append('<!-- Jcrop -->\n<link rel="stylesheet" href="vendor/jcrop/css/jquery.Jcrop.min.css">');
	}
	if (isNotImported('vendor/jcrop/js/jquery.Jcrop.min.js')) {
		var script = document.createElement("script");
		script.src = "vendor/jcrop/js/jquery.Jcrop.min.js";
		$("body").append(script);
	}
</script>
<div class="container">
	<div class="row">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">
					<h1><i class="fa fa-gear"></i><span style="width: 20px;"></span>Konfigurasi</h1>
				</div>
				<div class="card-body">
					<form method="post" class="form-validate" id="form-config">
						<h3>Tentang Aplikasi</h3>
						<hr>
						<div class="form-group">
							<label class="form-control-label">Nama Aplikasi</label>
							<input type="text" maxlength="15" name="nama_aplikasi" placeholder="Nama Aplikasi" class="form-control" required  value="<?= $config['nama_aplikasi']; ?>" autocomplete="off">
							<small class="form-text text-muted">
								Panjang karakter harus diantara 4-15 karakter.
							</small>
						</div>
						<div class="form-group">
							<label class="form-control-label">Nama Perusahaan/Sekolah</label>
							<input type="text" maxlength="100" name="nama_perusahaan" placeholder="Nama Perusahaan/Sekolah" class="form-control" required value="<?= $config['nama_perusahaan']; ?>" autocomplete="off">
							<small class="form-text text-muted">
								Maksimal 100 karakter.
							</small>
						</div>
						<div class="form-group">
							<label class="form-control-label">Deskripsi Aplikasi</label>
							<textarea class="form-control" name="deskripsi" rows="4" minlength="20" required><?= $config['deskripsi']; ?></textarea>
						</div>
						<div class="form-group">
							<label>Warna Tema</label>
							<select name="tema" class="form-control show-tick" data-style="border border-primary btn-light" title="Pilih Tema" required>
								<option value="blue">Blue</option>
								<option value="green">Green</option>
								<option value="pink">Pink</option>
								<option value="default">Purple</option>
								<option value="red">Red</option>
								<option value="sea">Sea</option>
								<option value="violet">Violet</option>
							</select>
						</div>
						<h3>Perizinan</h3>
						<hr>
						<div class="form-group">
							<label class="switch align-middle">
								<input type="checkbox" id="izinprofil" <?= $config['izinprofil'] ? "checked" : ""; ?>>
								<span class="slider round"></span>
							</label>
							<label class="align-middle pl-2" for="izinprofil">Izinkan Guru dan Siswa mengubah profil</label>
						</div>
						<div class="form-group">
							<label class="switch align-middle">
								<input type="checkbox" id="izinpassword" <?= $config['izinpassword'] ? "checked" : ""; ?>>
								<span class="slider round"></span>
							</label>
							<label class="align-middle pl-2" for="izinpassword">Izinkan Guru dan Siswa mengganti password</label>
						</div>
						<div class="form-group">
							<label class="switch align-middle">
								<input type="checkbox" id="izinlogoakhir" <?= $config['izinlogoakhir'] ? "checked" : ""; ?>>
								<span class="slider round"></span>
							</label>
							<label class="align-middle pl-2" for="izinlogoakhir">Tampilkan logo di akhir menu</label>
						</div>
						<button type="submit" class="btn btn-primary" id="update">Update</button><span style="width: 15px;"></span>
						<div class="gambarload align-middle d-none" style="display: inline-block; width: 30px; height: 30px;"></div>
					</form>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card">
				<div class="card-header">
					<h1><i class="fa fa-file-image-o"></i><span style="width: 20px;"></span>Logo Aplikasi</h1>
				</div>
				<div class="card-body">
					<img src="img/logo/logo.png?t=<?= strtotime($config['last_updated']); ?>" id="logoapp" class="rounded-circle mx-auto d-block" alt="Foto Profil" width="200" height="200">
					<br />
					<form method="post" id="form-gantilogo">
						<label class="btn btn-primary btn-block btn-file">
						Ganti Logo Aplikasi<input type="file" class="d-none" name="gantilogo" id="gantilogo">
						</label>
					</form>
					<small class="form-text text-center">File yang diperbolehkan:<br>JPG, JPEG, PNG, BMP</small>
					<small class="form-text text-center">Maksimum File: 1 MB</small>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal-prev" data-backdrop="static">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Crop</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-8 text-center">
						<img src="" id="prevgambar" style="max-height: 100%; max-width: 100%;">
					</div>
					<div class="col-md-4">
						<div id="preview-pane">
							<div class="preview-container rounded-circle" style="width: 200px; height: 200px;">
								<img src="" class="jcrop-preview text-center" id="previewcrop">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<form method="post" id="coords">
					<input type="hidden" id="x" name="x" />
					<input type="hidden" id="y" name="y" />
					<input type="hidden" id="w" name="w" />
					<input type="hidden" id="h" name="h" />
					<button type="submit" class="btn btn-primary">Simpan</button>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
    var prev = $("#prevgambar");
    var ext;
    var gambar;
    var boundx, boundy, jcrop_api,
        $preview = $('#preview-pane'),
        $pcnt = $('#preview-pane .preview-container'),
        $pimg = $('#preview-pane .preview-container img'),
        xsize = 200, ysize = 200;

	function cekKelengkapan() {
		var isFilled;
		$("#form-config input, textarea").each(function() {
			console.log($(this).attr('name') + " : " + $(this).val());
			if ($(this).val().trim() == "") {
				isFilled = false;
				return false;
			}
			else {
				isFilled = true;
			}
		});
		return isFilled;
	}
	function previewCrop(c) {
		if (parseInt(c.w) > 0)
		{
			var rx = xsize / c.w;
			var ry = ysize / c.h;

			$pimg.css({
			  width: Math.round(rx * boundx) + 'px',
			  height: Math.round(ry * boundy) + 'px',
			  marginLeft: '-' + Math.round(rx * c.x) + 'px',
			  marginTop: '-' + Math.round(ry * c.y) + 'px'
			});
			$('#x').val(c.x);
		    $('#y').val(c.y);
		    $('#w').val(c.w);
		    $('#h').val(c.h);
		}
	}
	function previewGambar(input) {
	  if (input.files && input.files[0]) {
	    var reader = new FileReader();

	    reader.onload = function(e) {
			var img = new Image;
			img.onload = function() {
			};
			img.src = reader.result;
			$pimg.attr('src', e.target.result);
			prev.attr('src', e.target.result);
	    	prev.Jcrop({
	    		addClass: 'jcrop-centered border',
	    		onChange: previewCrop,
	    		onSelect: previewCrop,
	    		bgColor: 'white',
	    		bgOpacity: .4,
	    		boxWidth: 310,
	    		aspectRatio: 1 / 1,
	    		setSelect: [150,150,250,250]
	    	},function(){
		      var bounds = this.getBounds();
		      boundx = bounds[0];
		      boundy = bounds[1];
		      jcrop_api = this;
		    });
	    }
	    reader.readAsDataURL(input.files[0]);
	  }
	}

	$(document).ready(function() {
		$("[name=tema]").selectpicker();
		$("[name=tema]").selectpicker('val','<?= $config['tema']; ?>');
		$("#form-config").submit(function(e) {
			e.preventDefault();
			if (cekKelengkapan()) {
				$("input, textarea, select").prop("readonly",true);
				$("#update").prop('disabled', true);
				$(".gambarload").removeClass('d-none');
				$.ajax({
					url: 'ajax_konfigurasi.php',
					type: 'POST',
					dataType: 'json',
					data: $(this).serialize() + "&" + $.param({'izinpass': $("#izinpassword").is(':checked'), 'izinprofil': $("#izinprofil").is(':checked'), 'izinlogoakhir': $("#izinlogoakhir").is(':checked'), 'config' : true}),
					success: function (data) {
						$("input, textarea, select").prop("readonly",false);
						$("#update").prop('disabled', false);
						$(".gambarload").addClass('d-none');
						if (data.response) {
							swal({
								type: 'success',
								title: 'Berhasil!',
								text: 'Berhasil diupdate!',
								allowOutsideClick: false,
								showLoaderOnConfirm: true,
								preConfirm: () => {
								  return new Promise((resolve) => {
								    window.location.href = "index.php";
								    setTimeout(function () {
								    	resolve();  
								    }, 50000);
								  });
								}
			                });
						}
						else {
							if (data.reason == "unedit") {
								swal({
									type: 'info',
									text: 'Anda belum mengedit apapun.',
									position: 'bottom-end',
									toast: true,
									timer: 3000
								});
							}
							else {
								swal("Gagal!","Harap coba lagi", "error");
								console.log(data.reason);
							}
						}
					}
				})
				.fail(function(jqXHR) {
					console.log(jqXHR.responseText);
				});
			}
			else {
				swal({
					text: "Harap lengkapi field.",
					type: "info",
					position: "bottom-end",
					timer: 3000,
					toast: true
				});
			}
		});
		$("#gantilogo").change(function() {
			gambar = this.files[0];
			if (gambar.size > 1048576) {
				swal("Terlalu Besar!", "Ukuran gambar maksimal adalah 1 MB", "warning");
				$(this).val('');
			}
			else {
				var filename = $(this).val();
				var allow_ext = ['.jpg', '.jpeg', '.png', '.bmp'];
				ext = filename.substring(filename.lastIndexOf('.')).toLowerCase();
				if ($.inArray(ext, allow_ext) == -1) {
					swal("File tidak valid!", "File yang diperbolehkan adalah JPG, JPEG, PNG, BMP", "warning");
					$(this).val('');
				}
				else {
					previewGambar(this);
					$("#modal-prev").modal();
				}
			}
		});
		$("#modal-prev").on('hidden.bs.modal', function(e) {
			$("#gantilogo").val(null);
			jcrop_api.destroy();
		});
		$("#coords").submit(function(e) {
			e.preventDefault();
			if ($("#gantilogo").val() != "") {
				var data = new FormData(this);
				data.append('gambar', gambar);
				data.append('ext', ext);
				data.append('logo', true);
				$.ajax({
					url: 'ajax_konfigurasi.php',
					type: 'POST',
					dataType: 'json',
					data: data,
					contentType: false,
				    cache: false,
					processData:false,
					success: function (data) {
						if (data.result) {
							swal({
								title: 'Berhasil!',
								text: 'Logo Aplikasi berhasil diubah!',
								type: 'success',
								allowOutsideClick: false
							});
							$("#modal-prev").modal('hide');
							$(".logo-footer").each(function() {
								$(this).attr('src', 'img/logo/logo.png?t=' + data.now);
							});
							$("#favicon").attr('href', 'img/favicon.ico?t=' + data.now);
							$("#logoapp").attr('src', 'img/logo/logo.png?t=' + data.now);
						}
						else {
							swal({
								title: 'Gagal!',
								text: 'Gagal mengupdate gambar',
								type: 'error',
								allowOutsideClick: false
							});
						}
					}
				});
			}
			else {
				swal({
					type: 'info',
					text: 'Harap tentukan area crop.',
					position: 'bottom-end',
					toast: true,
					timer: 3000
				});
			}
		});
	});
</script>