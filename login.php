<?php   

  require_once "config/controller.php";

  $fungsi = new Controller();
  $fungsi -> cekCookie();
  if ($fungsi->isLogin()) {
      header("Location: index.php");
      exit;
  }

  $config = $fungsi->getKonfigurasi();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login - <?= $config['nama_aplikasi']; ?></title>
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
    <link rel="stylesheet" href="css/style.<?= $config['tema']; ?>.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="css/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/favicon.ico?t=<?= strtotime($config['last_updated']); ?>">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
  </head>
  <body>
    <div class="page login-page">
      <div class="container d-flex align-items-center">
        <div class="form-holder has-shadow">
          <div class="row">
            <!-- Logo & Information Panel-->
            <div class="col-lg-6">
              <div class="info align-items-center" style="padding: 100px 10px;">
                <div class="row">
                  <div class="col-md-12 text-center">
                      <img src="img/logo/logo.png?t=<?= strtotime($config['last_updated']); ?>" class="rounded-circle" style="width: 150px; height: 150px;">
                  </div>
                </div>
                <br><br>
                <div class="content text-center">
                  <div class="logo">
                    <h1><?= $config['nama_aplikasi']; ?></h1>
                  </div>
                  <p><?= $config['deskripsi']; ?></p>
                </div>
              </div>
            </div>
            <!-- Form Panel    -->
            <div class="col-lg-6 bg-white">
              <div class="form d-flex align-items-center">
                <div class="content">
                  <h3 style="font-size: 40px; margin-top: -30px; margin-bottom: 30px;">Login</h3>
                  <form method="post" class="form-validate" id="login">
                    <div class="form-group">
                      <input id="login-username" type="text" name="loginUsername" required data-msg="Masukkan username Anda" class="input-material" autocomplete="off" autofocus="on">
                      <label for="login-username" class="label-material">Username</label>
                    </div>
                    <div class="form-group">
                      <input id="login-password" type="password" name="loginPassword" required data-msg="Masukkan password Anda" class="input-material" autocomplete="off">
                      <label for="login-password" class="label-material">Password</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                    <div id="loader" class="gambarload align-middle ml-2 d-none" style="display: inline-block; width: 30px; height: 30px;"></div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="copyrights text-center">
        <p>Design by <a href="https://bootstrapious.com/admin-templates" class="external">Bootstrapious</a>
          <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
        </p>
      </div>
    </div>
    <!-- JavaScript files-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper.js/umd/popper.min.js"> </script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/swal/sweetalert2.all.min.js"></script>
    <script src="vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="vendor/jquery-validation/jquery.validate.min.js"></script>
    
    <!-- Main File-->
    <script src="js/front.js"></script>
    <script>
      $(document).ready(function() {
        $("label[for=login-username]").addClass('active');
        $("#login").submit(function(e) {
          e.preventDefault();
          $("#loader").removeClass('d-none');
          $("input").prop('readonly', true);
          $("button").prop('disabled', true);
          $.post('ajax_login.php', $(this).serializeArray(), function(data) {
            data = JSON.parse(data);
            if (data.response) {
              swal("Login Berhasil","Selamat Datang " + data.name,"success").then(function(){document.location.href='index.php';});
            }
            else {
              swal("Gagal","Username atau Password salah!","warning");
            }
            $("#loader").addClass('d-none');
            $("input").prop('readonly', false);
            $("button").prop('disabled', false);
          });
        });
      });
    </script>
  </body>
</html>