<?php
	require_once 'config/controller.php';
	$c = new Controller();
	if (!$c->cekAjaxLoad()) {
        exit("403 Forbidden");
    }
?>
<div class="container">
	<div class="ui-typography">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
                    <div class="card-body">
                    	<ul class="nav nav-pills" id="pills-tab" role="tablist">
                    		<li class="nav-item">
                    			<a href="#pills-siswa" class="nav-link active" id="pills-siswa-tab" data-toggle="pill" role="tab" aria-controls="pills-siswa" aria-selected="true">Siswa</a>
                    		</li>
                    		<li class="nav-item ml-2">
                    			<a href="#pills-guru" class="nav-link" id="pills-guru-tab" data-toggle="pill" role="tab" aria-controls="pills-guru" aria-selected="false">Guru</a>
                    		</li>
                    		<li class="nav-item ml-2">
                    			<a href="#pills-admin" class="nav-link" id="pills-admin-tab" data-toggle="pill" role="tab" aria-controls="pills-admin" aria-selected="false">Admin</a>
                    		</li>
                    	</ul>
                    	<hr>
                    	<div class="tab-content" id="pills-tabContent">
							<!-- SISWA -->
                    		<div class="tab-pane show active" id="pills-siswa" role="tabpanel" aria-labelledby="pills-siswa-tab">
                    			<div class="row">
                    				<div class="col-md-12 p-2">
                    					<h1>Daftar Siswa</h1>
                    					<form id="daftarsiswa" method="post">
					                    <div class="row">
					                      <div class="col-md-6">
					                        <div class="form-group">
					                        	<label class="form-control-label">Username</label>
					                          	<input type="text" name="username" required class="form-control" placeholder="Username">
					                        </div>
					                      </div>
					                      <div class="col-md-6">
					                        <div class="form-group">
					                          <label class="form-control-label">Password</label>
					                          <input type="password" name="password" required class="form-control" placeholder="Password">
					                        </div>
					                      </div>
					                    </div>
					                    <div class="row">
					                      <div class="col-md-6">
					                        <div class="form-group">
					                          <label class="form-control-label">NIS</label>
					                          <input type="number" maxlength="8" name="nis" required class="form-control" placeholder="NIS">
					                        </div>
					                      </div>
					                      <div class="col-md-6">
					                        <div class="form-group">
					                          <label class="form-control-label">Nama</label>
					                          <input type="text" name="nama" placeholder="Nama Siswa" required class="form-control">
					                        </div>
					                      </div>
					                    </div>
					                    <div class="row align-items-center">
					                      <div class="col-md-4">
					                        <div class="form-group">
					                          <label class="form-control-label">Tempat Lahir</label>
					                          <input type="text" name="tempat_lahir" required class="form-control" placeholder="Tempat Lahir Siswa">
					                        </div>
					                      </div>
					                      <div class="col-md-4">
					                        <div class="form-group">
					                          <label class="form-control-label">Tanggal Lahir</label>
					                          <input type="date" name="tanggal_lahir" class="form-control">
					                        </div>
					                      </div>
					                      <div class="col-md-4">
					                      	<div class="form-group">
				                                <label class="form-control-label">Jenis Kelamin</label>
				                                <br />
				                                <div class="form-check form-check-inline">
				                                    <input type="radio" value="L" name="jk" class="radio-template form-check-input" id="l-sis">
				                                    <label class="form-check-label" for="l-sis" style="cursor: pointer;">
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
					                    <div class="row">
					                      <div class="col-md-6">
					                            <div class="form-group">
					                              <label class="form-control-label">Nomor Telepon</label>
					                              <div class="input-group">
				                                      <div class="input-group-append">
				                                        <span class="input-group-text">+62</span>
				                                      </div>
				                                      <input type="tel" maxlength="12" name="no_telp" class="form-control" required data-msg="Masukkan nomor telepon Anda">
					                              </div>
					                            </div>
					                          </div>
					                            <div class="col-md-6">
					                              <div class="form-group">
					                                <label class="form-control-label">Email</label>
					                                <input type="email" name="email" placeholder="me@example.com" class="form-control" required>
					                              </div>
					                            </div>
					                    </div>
					                    <div class="row align-items-center">
				                            <div class="col-md-3">
				                              <label class="btn btn-primary btn-block btn-file">
							                  	Foto Profil<input type="file" class="d-none gambar" label-target="siswa" name="gambar">
							                  </label>
				                            </div>
				                            <div class="col-md-9">
				                  				<label label-pic="siswa" class="form-inline d-inline-block">Tidak ada file yang dipilih</label>
				                            </div>
					                    </div>
					                    <div class="row">
					                      <div class="col-md-12">
					                        <div class="form-group">
					                          <label class="form-control-label">Alamat</label>
					                          <textarea type="text" name="alamat" rows="4" required class="form-control"></textarea>
					                        </div>
					                      </div>
					                    </div>
					                    <div class="form-group">
					                      <button type="submit" class="btn btn-primary">Daftar</button>
					                    </div>
					                  </form>
                    				</div>
                    			</div>
                    		</div>
							<!-- GURU -->
                    		<div class="tab-pane" id="pills-guru" role="tabpanel" aria-labelledby="pills-guru-tab">
                    			<div class="row">
                    				<div class="col-md-12 p-2">
                    					<h1>Daftar Guru</h1>
				                    	<form method="post" id="daftarguru">
				                    		<div class="row align-items-center">
				                    			<div class="col-md-6">
				                    				<div class="form-group">
				                    					<label class="form-control-label">Username</label>
							                        	<input type="text" name="username" placeholder="Username" class="form-control">
				                    				</div>
				                    			</div>
					                        	<div class="col-md-6">
					                        		<div class="form-group">
					                        			<label class="form-control-label">Password</label>
					                        			<input type="password" name="password" placeholder="Password" class="form-control">
					                        		</div>
					                        	</div>
					                        </div>
					                        <div class="row align-items-center">
					                        	<div class="col-md-6">
					                        		<div class="form-group">
							                        	<label class="form-control-label">NIP</label>
							                        	<input type="number" name="nip" placeholder="NIP" class="form-control">
						                        	</div>
					                        	</div>
					                        	<div class="col-md-6">
					                        		<div class="form-group">
							                        	<label class="form-control-label">Nama</label>
							                        	<input type="text" name="nama" placeholder="Nama Guru" class="form-control">
						                        	</div>
					                        	</div>
					                        </div>
					                        <div class="row align-items-center">
					                        	<div class="col-md-4">
					                        		<div class="form-group">
							                        	<label class="form-control-label">Tempat Lahir</label>
							                        	<input type="text" name="tempat_lahir" placeholder="Tempat Lahir Guru" class="form-control">
						                        	</div>
					                        	</div>
					                        	<div class="col-md-4">
					                        		<div class="form-group">
							                        	<label class="form-control-label">Tanggal Lahir</label>
							                        	<input type="date" name="tanggal_lahir" class="form-control">
						                        	</div>
					                        	</div>
					                        	<div class="col-md-4">
					                        		<div class="form-group">
					                        			<label for="" class="form-control-label">Jenis Kelamin</label>
					                        			<br />
					                        			<div class="form-check form-check-inline">
							                            	<input type="radio" value="L" name="jk" class="radio-template form-check-input" id="l-gu">
							                            	<label class="form-check-label" for="l-gu" style="cursor: pointer;">
							                            		<img src="img/jk/L.png" width="25" height="25">
							                            	</label>
							                            </div>
							                            <div class="form-check form-check-inline">
							                            	<input type="radio" value="P" name="jk" class="radio-template form-check-input" id="p-gu">
							                            	<label class="form-check-label" for="p-gu" style="cursor: pointer;">
							                            		<img src="img/jk/P.png" width="25" height="25">
							                            	</label>
							                            </div>
					                        		</div>
					                        	</div>
					                        </div>
					                        <div class="row align-items-center">
				                    			<div class="col-md-6">
				                    				<div class="form-group">
				                    					<label class="form-control-label">Nomor Telepon</label>
				                    					<div class="input-group">
							                                <div class="input-group-append">
							                                	<span class="input-group-text">+62</span>
							                                </div>
							                                <input type="tel" maxlength="12" name="no_telp" class="form-control">
							                            	
							                            </div>
				                    				</div>
				                    			</div>
					                        	<div class="col-md-6">
					                        		<div class="form-group">
							                        	<label class="form-control-label">Email</label>
							                        	<input type="email" name="email" placeholder="me@example.com" class="form-control">
						                        	</div>
					                        	</div>
					                        </div>
					                        <div class="row align-items-center">
					                        	<div class="col-md-3">
					                        		<label class="btn btn-primary btn-block btn-file">
													Foto Profil<input type="file" class="d-none gambar" label-target="guru" name="gambar">
													</label>
					                        	</div>
					                        	<div class="col-md-9">
													<label label-pic="guru" class="form-inline d-inline-block">Tidak ada file yang dipilih</label>
					                        	</div>
					                        </div>
					                        <div class="row align-items-center">
					                        	<div class="col-md-12">
					                        		<div class="form-group">
							                        	<label class="form-control-label">Alamat</label>
							                        	<textarea name="alamat" class="form-control" rows="4"></textarea>
						                        	</div>
					                        	</div>
					                        </div>
					                        <button type="submit" class="btn btn-primary">Daftar</button>
				                    	</form>
                    				</div>
                    			</div>
                    		</div>
							<!-- Admin -->
                    		<div class="tab-pane" id="pills-admin" role="tabpanel" aria-labelledby="pills-admin-tab">
                    			<div class="row">
                    				<div class="col-md-12 p-2">
                    					<h1>Daftar Admin</h1>
                    					<form id="daftaradmin" method="post">
                    						<div class="row align-items-center">
                    							<div class="col-md-4">
							                        <div class="form-group">
							                        	<label class="form-control-label">Username</label>
							                          	<input type="text" name="username" required class="form-control" placeholder="Username">
							                        </div>
							                    </div>
							                    <div class="col-md-4">
							                        <div class="form-group">
							                          <label class="form-control-label">Password</label>
							                          <input type="password" name="password" required class="form-control" placeholder="Password">
							                        </div>
							                    </div>
                    							<div class="col-md-4">
                    								<div class="form-group">
                    									<label class="form-control-label">Nama</label>
                    									<input type="text" name="nama" required="" placeholder="Nama Admin" class="form-control">
                    								</div>
                    							</div>
                    						</div>
                    						<div class="row align-items-center">
					                        	<div class="col-md-4">
					                        		<div class="form-group">
							                        	<label class="form-control-label">Tempat Lahir</label>
							                        	<input type="text" name="tempat_lahir" placeholder="Tempat Lahir Admin" class="form-control">
						                        	</div>
					                        	</div>
					                        	<div class="col-md-4">
					                        		<div class="form-group">
							                        	<label class="form-control-label">Tanggal Lahir</label>
							                        	<input type="date" name="tanggal_lahir" class="form-control">
						                        	</div>
					                        	</div>
					                        	<div class="col-md-4">
					                        		<div class="form-group">
					                        			<label for="" class="form-control-label">Jenis Kelamin</label>
					                        			<br />
					                        			<div class="form-check form-check-inline">
							                            	<input type="radio" value="L" name="jk" class="radio-template form-check-input" id="l-ad">
							                            	<label class="form-check-label" for="l-ad" style="cursor: pointer;">
							                            		<img src="img/jk/L.png" width="25" height="25">
							                            	</label>
							                            </div>
							                            <div class="form-check form-check-inline">
							                            	<input type="radio" value="P" name="jk" class="radio-template form-check-input" id="p-ad">
							                            	<label class="form-check-label" for="p-ad" style="cursor: pointer;">
							                            		<img src="img/jk/P.png" width="25" height="25">
							                            	</label>
							                            </div>
					                        		</div>
					                        	</div>
					                        </div>
					                        <div class="row align-items-center">
				                    			<div class="col-md-6">
				                    				<div class="form-group">
				                    					<label class="form-control-label">Nomor Telepon</label>
				                    					<div class="input-group">
							                                <div class="input-group-append">
							                                	<span class="input-group-text">+62</span>
							                                </div>
							                                <input type="tel" maxlength="12" name="no_telp" class="form-control">
							                            	
							                            </div>
				                    				</div>
				                    			</div>
					                        	<div class="col-md-6">
					                        		<div class="form-group">
							                        	<label class="form-control-label">Email</label>
							                        	<input type="email" name="email" placeholder="me@example.com" class="form-control">
						                        	</div>
					                        	</div>
					                        </div>
					                        <div class="row align-items-center">
					                        	<div class="col-md-3">
					                        		<label class="btn btn-primary btn-block btn-file">
													Foto Profil<input type="file" class="d-none gambar" label-target="guru" name="gambar">
													</label>
					                        	</div>
					                        	<div class="col-md-9">
													<label label-pic="guru" class="form-inline d-inline-block">Tidak ada file yang dipilih</label>
					                        	</div>
					                        </div>
					                        <div class="row align-items-center">
					                        	<div class="col-md-12">
					                        		<div class="form-group">
							                        	<label class="form-control-label">Alamat</label>
							                        	<textarea name="alamat" class="form-control" rows="4"></textarea>
						                        	</div>
					                        	</div>
					                        </div>
					                        <button type="submit" class="btn btn-primary">Daftar</button>
                    					</form>
                    				</div>
                    			</div>
                    		</div>
                    	</div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>
<script>
	var data = null;
	$("input").attr('autocomplete', 'off');
	function cekKelengkapanUser(){
        var a = $(this).find("input, textarea").filter(function() {
	        	return this.value.trim() === "";
	    	});
	    if(a.length) {
	    	if (a.length == 1 && ($("#gambar").val() == "")) {
	    		return true;
	    	}
	    	else {
	        	return false;
	    	}
	    }
	    else {
	    	return true;
	    }
    }

    $(".gambar").change(function() {
    	var gambar = this.files[0];
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
				$("[label-pic=" + $(this).attr('label-target') + "]").html(gambar.name);
			}
		}
    });
    function ajaxDaftar(data) {
    	$.ajax({
		  url: 'ajax_daftar.php',
		  type: 'POST',
		  data: data,
		  dataType: 'json',
		  contentType: false,
		  cache: false,
		  processData:false,
		  success: function(data){
		    if (data.status == "ok") {
		      swal("Berhasil!","Berhasil didaftarkan!","success").then(function(){
		      document.location.href = 'index.php'; 
		      });
		    }
		    else if (data.status == "already") {
		      swal(data.already + " telah digunakan!", data.already + " telah digunakan.", "warning");
		    }
		    else if (data.status == "invalid") {
		      swal("File tidak valid!", "File yang diperbolehkan adalah JPG, JPEG, PNG, BMP", "warning");
		    }
		    else if (data.status == "toolarge") {
		      swal("Terlalu Besar!", "Ukuran gambar maksimal adalah 1 MB", "warning");
		    }
		    else {
		      swal("Gagal!","Gagal. Coba Lagi.","error");
		      console.log(data);
		    }
		  }
		});
    }
	$("#daftarguru").submit(function(e) {
		e.preventDefault();
		if (cekKelengkapanUser()) {
			data = new FormData(this);
			data.append('anggota', 'guru');
			$(this).find("input, textarea").prop('readonly',true);
			$(this).find(".btn").addClass('disabled');
			ajaxDaftar(data);
			$(this).find("input, textarea").prop('readonly',false);
			$(this).find(".btn").removeClass('disabled');
		}
		else {
			swal("Belum Lengkap!","Harap lengkapi lalu coba lagi.","warning");
		}
	});
	$("#daftarsiswa").submit(function(e) {
		e.preventDefault();
		if (cekKelengkapanUser()) {
			data = new FormData(this);
			data.append('anggota', 'siswa');
			$(this).find("input, textarea").prop('readonly',true);
			$(this).find(".btn").addClass('disabled');
			ajaxDaftar(data);
			$(this).find("input, textarea").prop('readonly',false);
			$(this).find(".btn").removeClass('disabled');
		}
		else {
			swal("Belum Lengkap!","Harap lengkapi lalu coba lagi.","warning");
		}
	});
	$("#daftaradmin").submit(function(e) {
		e.preventDefault();
		if (cekKelengkapanUser()) {
			data = new FormData(this);
			data.append('anggota', 'admin');
			$(this).find("input, textarea").prop('readonly',true);
			$(this).find(".btn").addClass('disabled');
			ajaxDaftar(data);
			$(this).find("input, textarea").prop('readonly',false);
			$(this).find(".btn").removeClass('disabled');
		}
		else {
			swal("Belum Lengkap!", "Harap lengkapi lalu coba lagi.", "warning");
		}
	});
</script>