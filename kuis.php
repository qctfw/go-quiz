<?php
    require_once 'config/controller.php';
    $c = new Controller();
    if (!$c->isLogin()) {
        header("Location: login.php");
        exit;
    }
    if (!isset($_SESSION['id_level'])) {
      echo "<script>document.location.href='index.php'</script>";
      exit;
    }
    $config = $c->getKonfigurasi();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Kuis - <?= $config['nama_aplikasi']; ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
    <!-- Fontastic Custom icon font-->
    <link rel="stylesheet" href="css/fontastic.css">
    <!-- Data Tables -->
    <link rel="stylesheet" href="vendor/datatables/datatables.min.css">
    <!-- Google fonts - Poppins -->
    <link rel="stylesheet" href="css/fonts.css">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="css/style.<?= $config['tema']; ?>.css" id="theme-stylesheet">
    <!-- animate.css -->
    <link rel="stylesheet" href="vendor/animate.css/animate.min.css">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="css/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/favicon.ico?t=<?= strtotime($config['last_updated']); ?>">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
    <style>
        .box-shadow {
            box-shadow: 0px 0px 100px -40px #000;
        }
    </style>
  </head>
  <body>
    <div class="page">
      <!-- Main Navbar-->
      <header class="header">
        <nav class="navbar">
          <div class="container-fluid">
            <div class="navbar-holder d-flex align-items-center justify-content-between">
              <!-- Navbar Header-->
              <div class="navbar-header">
                <!-- Navbar Brand -->
                <a href="javascript:void(0);" class="navbar-brand">
                  <div class="brand-text brand-big"><?= $config['nama_aplikasi']; ?></div>
                  <div class="brand-text brand-small"><?= $config['nama_aplikasi']; ?></div>
                </a>
              </div>
              <!-- Navbar Menu -->
              <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                <!-- Languages dropdown    -->
                <!-- Logout    -->
                <li class="nav-item" id="logout"><a href="javascript:void(0);" class="nav-link logout"><span class="d-none d-sm-inline-block">Logout</span><i class="fa fa-sign-out"></i></a></li>
              </ul>
            </div>
          </div>
        </nav>
      </header>
      <!-- Page Header -->
      <header class="page-header container-fluid" style="height: 60px;">
        <div class="container-fluid">
          <div class="row">
            <div class="col-6">
              <h2 class="no-margin-bottom pull-left" id="header-judul">Kuis</h2>
            </div>
            <div class="col-6">
              <h1 class="no-margin-bottom text-right" id="waktu"></h1>
            </div>
          </div>
            
            
        </div>
      </header>
      <div class="container-fluid d-flex align-items-stretch">
        <div class="col-md-12">
          <br>
          <div id="isi-kuis">
            <div id="loadkuis" class="gambarload d-none"></div>
              <div class="container bg-white" id="field-kuis">
                <div class="breadcrumbs">
                  <div class="row align-items-center" style="z-index: 0;">
                    <div class="col-6 col-sm-4">
                      <div class="p-0 pl-sm-2 page-header float-left text-center" id="nyawa" style="box-shadow: 0 0 0; background: rgba(0,0,0,0);">
                        <div class="page-title" id="nyawa">

                        </div>
                      </div>
                    </div>
                    <div class="col-2 col-sm-4 d-none d-sm-block">
                      <div class="page-header" style="box-shadow: 0 0 0; background: rgba(0,0,0,0);">
                        <div class="page-title text-center">
                          <h1 style="font-size: 25px;" id="namalevel-1"></h1>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 col-sm-4 align-middle pt-1" style="height: 50px; background: rgba(0,0,0,0);">
                      <p class="align-middle text-right" id="nomorsoal" style="line-height: 30px;"></p>
                    </div>
                    <div class="col-12 d-sm-none d-md-none d-lg-none d-xl-none">
                      <div class="page-header" style="box-shadow: 0 0 0;">
                        <div class="page-title text-center">
                          <h1 style="font-size: 25px;" id="namalevel-2"></h1>
                        </div>
                      </div>
                    </div>
                  </div>                                    
                </div>
                <div class="container">
                  <div class="row">
                    <div class="col-md-12">
                      <h4 class="text-center font-weight-normal text-wrap" id="deskripsi_soal"></h4>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <p class="text-center" id="gambar" style="cursor: zoom-in;"></p>
                    </div>
                  </div>
                  <div class="row" style="margin-top: 50px;">
                    <div class="col-md-12">
                      <div class="row">
                        <div class="col-md-12">
                          <form method="post" id="formjawab">
                            <div data-toggle="buttons">
                              <div class="row">
                                <div class="col-md-6">
                                  <label class="btn btn-primary btn-block" for="jawaban_a" style="white-space: normal;" for="jawaban_a">
                                    <input class="pull-left d-none" type="radio" name="jawaban" value="a">
                                    <span id="jawaban_a"></span>
                                  </label>
                                </div>
                                <div class="col-md-6">
                                  <label class="btn btn-primary btn-block" for="jawaban_b" style="white-space: normal;" for="jawaban_b">
                                    <input class="pull-left d-none" type="radio" name="jawaban" value="b">
                                    <span id="jawaban_b"></span>
                                  </label>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-6">
                                  <label class="btn btn-primary btn-block" for="jawaban_c" style="white-space: normal;" for="jawaban_c">
                                    <input class="pull-left d-none" type="radio" name="jawaban" value="c">
                                    <span id="jawaban_c"></span>
                                  </label>
                                </div>
                                <div class="col-md-6">
                                  <label class="btn btn-primary btn-block" for="jawaban_d" style="white-space: normal;" for="jawaban_d">
                                    <input class="pull-left d-none" type="radio" name="jawaban" value="d">
                                    <span id="jawaban_d"></span>
                                  </label>                                    
                                </div>
                              </div>
                              <br />
                            </div>
                            <div class="text-center">
                              <div id="loadsubmit" class="gambarload align-middle" style="display: inline-block; width: 30px; height: 30px;"></div>
                              <button type="submit" id="btn-jawab" class="btn btn-primary btn-lg">Jawab</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>                                        
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-md-12">
                      <p class="text-center" id="pembuat"></p>
                      <p class="text-center" id="tgl_buat"></p>
                    </div>
                  </div>
                </div>
                <br>
              </div>
            </div>
          <br>
          <br>
        </div>
      </div>
        <!-- Page Footer-->
        <footer class="main-footer" style="position: relative;">
            <div class="container-fluid">
              <div class="row">
                <div class="col-sm-6">
                  <p id="company"></p>
                </div>
                <div class="col-sm-6 text-right">
                  <p>Design by <a href="https://bootstrapious.com/admin-templates" class="external">Bootstrapious</a></p>
                      <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
                </div>
              </div>
            </div>
        </footer>
    </div>
    <!-- JavaScript files-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper.js/umd/popper.min.js"> </script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="vendor/swal/sweetalert2.all.min.js"></script>
    <script src="vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="vendor/timer/timer.jquery.min.js"></script>
    <!-- Main File-->
    <script src="js/front.js"></script>
    <script>
      $("#loadsubmit").hide(0);
    </script>
    <script>
      var myName = '<?= $config['nama_perusahaan']; ?> &copy; ' + new Date().getFullYear();
      $("#company").html(myName);
      <?php if (@$_SESSION['skip']): ?>
        swal({
          type: "warning",
          text: "Harap menyelesaikan kuis ini terlebih dahulu!",
          position: "bottom-end",
          timer: 3000,
          toast: true
        });
      <?php unset($_SESSION['skip']); endif; ?>
      <?php if (@$_SESSION['cheated']): ?>
        swal({
          type: 'info',
          title: 'Terjadi kesalahan!',
          text: 'Apakah anda ingin curang?',
          animation: false,
          allowOutsideClick: false,
          showLoaderOnConfirm: true,
          preConfirm: () => {
            return new Promise((resolve) => {
              $.post('ajax_kuis.php', {waktuhabis: true}, function(data) {
                $("#isi-kuis").load("hasil_kuis.php");
              });
              resolve();  
            });
          }
        });
      <?php endif ?>
    </script>
    <script>
      function logout() {
        swal({
          title: "Yakin?",
          text: "Apakah Anda yakin ingin keluar?",
          type: "question",
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya',
          cancelButtonText: 'Tidak',
          showLoaderOnConfirm: true,
          preConfirm: () => {
            return new Promise((resolve) => {
              $.post('ajax_logout.php', null, function(data) {
                  if (data == "ok") {
                    resolve("true");
                  }
                  else {
                    resolve("gagal");
                  }
              });
            });
          },
      allowOutsideClick: false
        }).then((result) => {
            if (result.value == "true") {
              swal("Berhasil","Berhasil Logout","success").then(function(){document.location.href='login.php';});
            }
            else if (result.value == "gagal") {
              swal("Gagal","Gagal Logout. Coba Lagi.", "error");
            }
          });
      }
      $("#logout").click(function() {
        logout();
      });
    </script>
    <script src="js/quiz.js"></script>
  </body>
</html>