<?php
	require_once 'config/controller.php';
    $c = new Controller();
    if (!$c->cekAjaxLoad()) {
        exit("403 Forbidden");
    }
	$config = $c->getKonfigurasi();
	$allowed = $config['izinprofil'] == 1 || $c->cekLevel("Admin");
	$level = strtolower($_SESSION['level']);
	if ($allowed) {
		$user = $c->tampilData("tb_" . $level . " WHERE id_" . $level . " = '" . $_SESSION['id_anggota'] . "'")[0];
		$username = $c->tampilData("tb_user WHERE id_anggota = '" . $_SESSION['id_anggota'] . "'","username")[0]['username'];
		$user['username'] = $username;
		if ($c->cekLevel("Siswa")) {
			$nomor_induk = $user['nis'];
			$name_nomorinduk = "NIS";
		}
		elseif ($c->cekLevel("Guru")) {
			$nomor_induk = $user['nip'];
			$name_nomorinduk = "NIP";
		}
	}
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
    if (isNotImported('vendor/animate.css/animate.min.css')) {
		$("head").append('<!-- animate.css -->\n<link rel="stylesheet" href="vendor/animate.css/animate.min.css">');
	}
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
	<div class="ui-typography">
		<div class="row">
            <?php if ($allowed): ?>
			<div class="col-md-9">
				<div class="card">
                    <div class="card-body">
                    	<h1>Ganti Profil</h1>
                    	<form method="post" id="gantiprofil">
                    		<div class="row align-items-center align-content-around">
                    			<div class="col-md-<?= $c->cekLevel("Admin") ? '6' : '4'; ?>">
                    				<div class="form-group">
                    					<label class="form-control-label">Username</label>
			                        	<input type="text" name="username" placeholder="Username" class="form-control" value="<?= $user['username']; ?>">
                    				</div>
                    			</div>
                    			<?php if (!$c->cekLevel("Admin")): ?>
	                        	<div class="col-md-4">
	                        		<div class="form-group">
			                        	<label class="form-control-label"><?= $name_nomorinduk; ?></label>
			                        	<input type="number" placeholder="<?= $name_nomorinduk; ?>" class="form-control" value="<?= $nomor_induk; ?>" disabled>
		                        	</div>
	                        	</div>
                    			<?php endif ?>
	                        	<div class="col-md-<?= $c->cekLevel("Admin") ? '6' : '4'; ?>">
	                        		<div class="form-group">
			                        	<label class="form-control-label">Nama</label>
			                        	<input type="text" name="nama" placeholder="Nama Anda" class="form-control" value="<?= $user['nama']; ?>">
		                        	</div>
	                        	</div>
	                        </div>
	                        <div class="row align-items-center">
	                        	<div class="col-md-4">
	                        		<div class="form-group">
			                        	<label class="form-control-label">Tempat Lahir</label>
			                        	<input type="text" name="tempat_lahir" placeholder="Tempat Lahir Anda" class="form-control" value="<?= $user['tempat_lahir']; ?>">
		                        	</div>
	                        	</div>
	                        	<div class="col-md-4">
	                        		<div class="form-group">
			                        	<label class="form-control-label">Tanggal Lahir</label>
			                        	<input type="date" name="tanggal_lahir" class="form-control" value="<?= date($user['tanggal_lahir']); ?>">
		                        	</div>
	                        	</div>
	                        	<div class="col-md-4">
	                        		<div class="form-group">
	                        			<label for="" class="form-control-label">Jenis Kelamin</label>
	                        			<br />
	                        			<div class="form-check form-check-inline">
			                            	<input type="radio" value="L" name="jk" class="radio-template form-check-input" id="l">
			                            	<label class="form-check-label" for="l" style="cursor: pointer;">
			                            		<img src="img/jk/L.png" width="25" height="25">
			                            	</label>
			                            </div>
			                            <div class="form-check form-check-inline">
			                            	<input type="radio" value="P" name="jk" class="radio-template form-check-input" id="p">
			                            	<label class="form-check-label" for="p" style="cursor: pointer;">
			                            		<img src="img/jk/P.png" width="25" height="25">
			                            	</label>
			                            </div>
	                        		</div>
	                        		
	                        	</div>
	                        </div>
	                        <div class="row align-items-center">
	                        	<div class="col-md-12">
	                        		<div class="form-group">
			                        	<label class="form-control-label">Alamat</label>
			                        	<textarea name="alamat" class="form-control" rows="4"><?= $user['alamat']; ?></textarea>
		                        	</div>
	                        	</div>
	                        </div>
	                        <button type="submit" class="btn btn-primary" id="btnubah">Ubah Profil</button>
	                        <div class="gambarload align-middle d-none" style="margin-left: 15px; display: inline-block; width: 30px; height: 30px;"></div>
                    	</form>
                    </div>
                </div>
			</div>
			<div class="col-md-3" id="idgambar">
				<div class="card">
					<div class="card-body">
						<h1>Foto Profil</h1>
						<br />
						<img src="img-db/<?= $user['gambar']; ?>" id="fotoprofil" class="rounded-circle mx-auto d-block" alt="Foto Profil" width="200" height="200">
						<br />
						<form method="post" id="form-gantigambar">
							<label class="btn btn-primary btn-block btn-file">
							Ganti Foto Profil<input type="file" class="d-none" name="gantigambar" id="gantigambar">
							</label>
						</form>
						
						<small class="form-text text-center">File yang diperbolehkan:<br>JPG, JPEG, PNG, BMP</small>
						<small class="form-text text-center">Maksimum File: 1 MB</small>
					</div>
				</div>
			</div>
            <?php else: ?>
            <div class="col-md-12">
            <p>Anda tidak diizinkan untuk mengubah profil. Harap hubungi <strong>administrator</strong> untuk mengubah profil Anda.</p>	
            </div>
            <?php endif; ?>
		</div>
	</div>
</div>
<?php if ($allowed): ?>
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
					<div class="gambarload align-middle d-none" style="margin-right: 15px; display: inline-block; width: 30px; height: 30px;"></div>
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
	$("input").attr('autocomplete', 'off');
	$("[value=<?= $user['jk']; ?>]").prop('checked', true);
	function cekKelengkapanUser(){
		var isFilled = true;
		$("#gantiprofil input, textarea").each(function() {
			if ($(this).val().trim() == "") {
				isFilled = false;
				$(this).addClass('animated shake').one('webkitAnimationEnd oanimationend msAnimationEnd animationend', function() {
					$(this).removeClass('animated shake');
				});
			}
			else {
				isFilled = !isFilled ? false : true;
			}
		});
		return isFilled;
        // return (
        //     ($("[name=username]").val() != "") &&
        //     ($("[name=nama]").val() != "") &&
        //     ($("[name=tempat_lahir]").val() != "") &&
        //     ($("[name=tanggal_lahir]").val() != "") &&
        //     ($("[name=alamat]").val() != "") &&
        //     ($("[name=jk]").val() != "")
        // );
    }
    var prev = $("#prevgambar");
    var ext;
    let gambar;
    var boundx, boundy, jcrop_api,
        $preview = $('#preview-pane'),
        $pcnt = $('#preview-pane .preview-container'),
        $pimg = $('#preview-pane .preview-container img'),
        xsize = 200, ysize = 200;
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
	$("#gantigambar").on('change', function() {
		gambar = this.files[0];
		if (gambar.size > 1048576) {
			swal("Terlalu Besar!", "Ukuran gambar maksimal adalah 1 MB", "warning");
		}
		else {
			var filename = $(this).val();
			var allow_ext = ['.jpg', '.jpeg', '.png', '.bmp'];
			ext = filename.substring(filename.lastIndexOf('.')).toLowerCase();
			if ($.inArray(ext, allow_ext) == -1) {
				swal("File tidak valid!", "File yang diperbolehkan adalah JPG, JPEG, PNG, BMP", "warning");
			}
			else {
				previewGambar(this);
				$("#modal-prev").modal();
				
			}
		}
	});
	$("#modal-prev").on('hidden.bs.modal', function(e) {
			$("#gantigambar").val(null);
			jcrop_api.destroy();
	});
	$("#coords").submit(function(e) {
		e.preventDefault();
		if ($("#gantigambar").val() != "") {
			$("#coords .gambarload").removeClass('d-none');
			$("#coords button").addClass('disabled');
			var data = new FormData(this);
			data.append('gantigambar', gambar);
			data.append('gambar', gambar);
			data.append('ext', ext);
			data.append('logo', true);
			$.ajax({
				url: "ajax_edituser.php",
				type: "POST",
				dataType: 'json',
				data: data,
				contentType: false,
			    cache: false,
				processData:false,
				success: function(data) {
					switch (data.status) {
						case 'ok' :
							swal("Berhasil Diubah", "Foto Profil Berhasil diubah!","success");
							$("#modal-prev").modal("hide");
							$("#fotoprofil").attr('src', 'img-db/' + data.gambar);
							$("#avatar-img").attr('src', 'img-db/' + data.gambar);
						break;
						case 'invalid' :
							swal("File tidak valid!", "File yang diperbolehkan adalah JPG, JPEG, PNG, BMP", "warning");
						break;
						case 'toolarge' :
							swal("Terlalu Besar!", "Ukuran gambar maksimal adalah 1 MB", "warning");
						break;
						default:
							swal("Gagal","Coba Lagi","error");
							console.log(data);
						break;
					}
					$("#coords .gambarload").addClass('d-none');
					$("#coords button").removeClass('disabled');
				},
				error: function() {
					swal("Gagal","Coba Lagi","error");
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
	$("#gantiprofil").submit(function(e) {
		e.preventDefault();
		
		if (cekKelengkapanUser()) {
			$("#btnubah").addClass('disabled');
			$("input, textarea, select").prop("readonly",true);
			$(".gambarload").removeClass('d-none');
			$.post('ajax_edituser.php', $(this).serialize(), function(data) {
				switch(data) {
					case "ok" :
						swal("Berhasil!","Profil berhasil diubah!","success").then(function(){
							document.location.href = 'index.php';
						});
					break;
					case "already" :
						swal("Terpakai!","Username telah digunakan!","warning");
					break;
					case "unedit" :
						swal({
							type: 'info',
							text: 'Anda tidak mengubah apapun',
							toast: true,
							position: 'bottom-end',
							timer: 3000
						});
					break;
					default :
						swal("Gagal!","Coba Lagi. Lihat detail di console.","error");
						console.log(data);
					break;
				}
				$(".gambarload").addClass('d-none');
				$("input, textarea, select").prop("readonly",false);
				$("#btnubah").removeClass('disabled');
			});
		}
		else {
			swal({
				text:"Harap lengkapi lalu coba lagi.",
				type:"warning",
				toast:true,
				position: 'bottom-end',
				timer:3000
			});
		}
		
	});
</script>
<?php endif ?>