<?php
// unused 
exit;
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Register - MasQuiz</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
    <!-- Fontastic Custom icon font-->
    <link rel="stylesheet" href="css/fontastic.css">
    <!-- Google fonts - Poppins -->
    <link rel="stylesheet" href="css/fonts.css">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="css/style.default.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="css/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/favicon.ico">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
  </head>
  <style>
    html {
      overflow-y: auto;
    }
  </style>
  <body>
    <div class="page login-page">
      <div class="container d-flex align-items-center">
        <div class="form-holder has-shadow">
          <div class="row">
            <!-- Logo & Information Panel-->
            <div class="col-lg-6">
              <div class="info d-flex align-items-center">
                <div class="content">
                  <div class="logo">
                    <h1>MasQuiz</h1>
                  </div>
                  <p>Ayo belajar Matematika dengan cara yang menyenangkan!</p>
                </div>
              </div>
            </div>
            <!-- Form Panel    -->
            <div class="col-lg-6 bg-white">
              <div class="form d-flex align-items-center">
                <div class="content">
                  <form class="form-validate" id="register" method="post">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <input id="register-username" type="text" name="username" required data-msg="Please enter your username" class="input-material">
                          <label for="register-username" class="label-material">User Name</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <input id="register-password" type="password" name="password" required data-msg="Please enter your password" class="input-material">
                          <label for="register-password" class="label-material">Password        </label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <input id="register-nama" type="text" name="nama" required data-msg="Masukkan nama Anda" class="input-material">
                          <label for="register-nama" class="label-material">Nama      </label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <input id="register-nis" type="number" maxlength="8" name="nis" required data-msg="Masukkan NIS Anda" class="input-material">
                          <label for="register-nis" class="label-material">NIS      </label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <input id="register-tempat_lahir" type="text" name="tempat_lahir" required data-msg="Masukkan tempat lahir Anda" class="input-material">
                          <label for="register-tempat_lahir" class="label-material">Tempat Lahir      </label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <input id="register-tanggal_lahir" type="date" name="tanggal_lahir"  class="form-control">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
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
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="alamat" class="label-material">Alamat      </label>
                          <textarea id="alamat" type="text" name="alamat" required data-msg="Masukkan alamat Anda" class="form-control"></textarea>
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
                                <input type="email" name="email" placeholder="mamang@example.com" class="form-control" required data-msg="Masukkan email Anda">
                              </div>
                            </div>
                    </div>
                    <div class="row align-items-center">
                            <div class="col-md-3">
                              <label class="btn btn-primary btn-block btn-file">
                  Foto Profil<input type="file" class="d-none" name="gambar" id="gambar">
                  </label>
                            </div>
                            <div class="col-md-9">
                  <label class="form-inline d-inline-block" id="path-gambar">Tidak ada file yang dipilih</label>
                            </div>
                          </div>
                    <div class="form-group">
                      <button id="btnsubmit" type="submit" name="registerSubmit" class="btn btn-primary">Register</button>
                    </div>
                  </form><small>Already have an account? </small><a href="login.php" class="signup">Login</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="copyrights text-center">
        <p>Design by <a href="https://bootstrapious.com" class="external">Bootstrapious</a>
          <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
        </p>
      </div>
    </div>
    <!-- JavaScript files-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper.js/umd/popper.min.js"> </script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="vendor/swal/sweetalert2.all.min.js"></script>
    <script src="vendor/jquery-validation/jquery.validate.min.js"></script>
    <!-- Main File-->
    <script src="js/front.js"></script>
    <script>
      var data = null;
      function cekKelengkapanUser(){
              var a = $("input, textarea").filter(function() {
                  return this.value === "";
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
      $(document).ready(function() {
        
        $("input").attr('autocomplete', 'off');
        

          $("#gambar").change(function() {
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
              $("#path-gambar").html(gambar.name);
            }
          }
          });
        $("#register").submit(function(e) {
          e.preventDefault();
          if (cekKelengkapanUser()) {
            data = new FormData(this);
            $.ajax({
              url: 'ajax_daftar.php',
              type: 'POST',
              data: data,
              dataType: 'json',
              contentType: false,
              cache: false,
              processData:false,
              success: function(data){
                console.log(data);
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
                $("#btnsubmit").removeClass('disabled');
              }
            });
          }
          else {
            swal("Belum Lengkap!","Harap lengkapi lalu coba lagi.","warning");
          }
        });
      });
    </script>
  </body>
</html>