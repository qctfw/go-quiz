<?php require_once 'config/controller.php'; $c = new Controller(); ?>
<?php
    if (!$c->cekAjaxLoad()) {
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
	if (isNotImported("vendor/ckeditor/ckeditor.js")) {
		var script = document.createElement('script');
		script.src = "vendor/ckeditor/ckeditor.js";
		$("body").append(script);
	}
</script>
<?php if ($c->getLevel() != "Guru") { echo "<h3>403 Forbidden</h3>"; exit; }; ?>
<style>
	.filter-option-inner-inner {
		color: #111;
	}
	.dropdown-item.active, .dropdown-item:active {
		color: #FFF;
		text-decoration: none;
	}
</style>
<div class="container">
	<div class="card">
		<div class="card-header">
			<h2>List Soal</h2>
		</div>
		<div class="card-body">
			<div class="row" style="background: white;">
				<div class="col-md-12">
					<button type="button" class="btn btn-info btn-fill pull-left" data-toggle="collapse" data-target="#form-soal">
						Input Soal
					</button>
				</div>
			</div>
			<div class="row" style="background: white;">
				<div class="col-md-12">
					<form class="collapse" method="post" id="form-soal" style="margin-top: 10px;">
						<div class="row">
			                <div class="col-md-12">
			                    <div class="form-group">
			                        <label>Deskripsi Soal</label>
			                        <textarea contenteditable="true" class="form-control" id="soal" rows="3">Tulis disini...</textarea>
			                    </div>
			                </div>
			            </div>
			            <div class="row">
			            	<div class="col-md-12">
		            			<img src="" id="prevgambar">
			            	</div>
			            </div>
			            <div class="row align-items-center mt-1">
                        	<div class="col-md-3">
                        		<label class="btn btn-primary btn-block btn-file">
								Foto Soal<input type="file" class="d-none" name="gambar" id="gambarsoal">
								</label>
                        	</div>
                        	<div class="col-md-9">
								<label class="form-inline d-inline-block" id="path-gambar">Tidak ada file yang dipilih</label>
                        	</div>
                        </div>
			            <div class="row">
			            	<div class="col-md-12">
			            		<div class="form-group">
			            			<label>Jenis Kuis</label>
			            			<select name="level" class="form-control show-tick" data-live-search="true" data-style="border border-primary btn-light" title="Pilih Kuis">
			            				<optgroup label="Easy"></optgroup>
			            				<optgroup label="Medium"></optgroup>
			            				<optgroup label="Hard"></optgroup>
			            				<optgroup label="Expert"></optgroup>
			            				<?php
			            					$jenis = $c->tampilData('tb_level ORDER BY kesulitan, nama_level ASC');
		            						foreach ($jenis as $kuis) {
		            					?>
		            						<option class="levelnya" value="<?= $kuis['id_level']; ?>" data-kesulitan="<?= $kuis['kesulitan']; ?>"><?= $kuis['nama_level']; ?></option>
		            					<?php		
		            						}
			            				?>
			            			</select>
			            			<script>
			            				// Penyortiran kuis berdasarkan level
										$(".levelnya").each(function() {
											$(this).appendTo('[name=level] optgroup[label=' + $(this).data('kesulitan') + ']');
										});
			            			</script>
			            		</div>
			            	</div>
			            </div>
			            <div class="row">
			                <div class="col-md-6">
			                    <div class="form-group">
				                    <label>Jawaban A</label>
				                    <input type="radio" value="a" name="jaw_benar" class="radio-template form-check-input pull-right">
				                    <textarea class="form-control" name="jaw_a" rows="3">A</textarea>
				                </div>
				            </div>
				            <div class="col-md-6">
				            	<div class="form-group">
				                    <label>Jawaban B</label>
				                    <input type="radio" value="b" name="jaw_benar" class="radio-template form-check-input pull-right">
				                    <textarea class="form-control" name="jaw_b" rows="3">B</textarea>
				                </div>
				            </div>
				        </div>
				        <div class="row">
			                <div class="col-md-6">
			                    <div class="form-group">
				                    <label>Jawaban C</label>
				                    <input type="radio" value="c" name="jaw_benar" class="radio-template form-check-input pull-right">
				                    <textarea class="form-control" name="jaw_c" rows="3">C</textarea>
				                </div>
				            </div>
				            <div class="col-md-6">
				            	<div class="form-group">
				                    <label>Jawaban D</label>
				                    <input type="radio" value="d" name="jaw_benar" class="radio-template form-check-input pull-right">
				                    <textarea class="form-control" name="jaw_d" rows="3">D</textarea>
				                </div>
				            </div>
				        </div>
				        <button type="submit" class="btn btn-primary btn-fill">Submit</button>
						<br><br>
					</form>
					<hr class="my-4">
					<div class="row">
						<div class="col-md-12" id="isi-soal">
							<div class="gambarload"></div>
							<!-- TABLE LIST SOAL -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$("[name=level]").selectpicker();
	CKEDITOR.env.isCompatible = true;
	var data, gambar = null;
	function tampilTabelSoal() {
		$('#isi-soal').load('ajax_input_soal_isi.php');
	}
	function previewGambar(input) {
	  if (input.files && input.files[0]) {
	    var reader = new FileReader();

	    reader.onload = function(e) {
			var img = new Image;
			img.onload = function() {
				$('#prevgambar').attr('width', (img.width / 3) + 'px');
				$('#prevgambar').attr('height', (img.height / 3) + 'px');
			};
			img.src = reader.result;
			$('#prevgambar').attr('src', e.target.result);
			
	    }

	    reader.readAsDataURL(input.files[0]);
	  }
	}
	$("#gambarsoal").change(function() {
		gambar = this.files[0];
		if (gambar.size > 1048576) {
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
				$("#path-gambar").html(gambar.name);
				previewGambar(this);
			}
		}
	});
	function cekKelengkapanInput(){
        return (
            (CKEDITOR.instances['soal'].getData() != "") && 
            ($("[name=jaw_a]").val() != "") && 
            ($("[name=jaw_b]").val() != "") &&
            ($("[name=jaw_c]").val() != "") &&
            ($("[name=jaw_d]").val() != "") &&
            ($("[name=jaw_benar]").is(':checked')) &&
            ($("[name=level]").val() != "")
        );
    }
    // FIRST RUN
    tampilTabelSoal();
    // END FIRST RUN
	$('#form-soal').submit(function(e) {
		e.preventDefault();
		if (cekKelengkapanInput()) {
			data = new FormData(this);
			data.append("soal",CKEDITOR.instances['soal'].getData());
			data.append('gambar', gambar);
			$.ajax({
				url: 'ajax_input_soal.php',
				type: 'POST',
				dataType: 'json',
				data: data,
				contentType: false,
			    cache: false,
				processData:false,
				success: function(data) {
					if (data['response']) {
                		$("textarea").val('');
                		CKEDITOR.instances['soal'].setData("Tulis disini...");
                		$('[name=level]').val('');
                		$('[name=level]').selectpicker('refresh');
						$('[name=jaw_benar]').prop('checked',false);
						$("#prevgambar").attr('src', 'img/no-image.png');
						$("#gambarsoal").val('');
						$("#path-gambar").html('Tidak ada file yang dipilih');
						$('#form-soal').collapse('hide');
	                	swal("Berhasil!","Soal berhasil diinput!","success").then(function(){
							$("#isi-soal").html("<div class='gambarload'></div>");
		                	tampilTabelSoal();
	                	});
	                	
	                }
	                else {
	                	swal("Gagal!","Gagal! Coba Lagi.","error");
	                	console.log(data.reason);
	                }
				}
			});
            }
            else {
            	swal("Belum Lengkap!", "Harap lengkapi data lalu coba lagi.", "warning");
            }
	});
	var soal = CKEDITOR.replace('soal');
</script>