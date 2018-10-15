<?php
    require_once 'config/controller.php';
    $c = new Controller();
    if (!$c->isLogin()) {
        header("Location: login.php");
        exit;
    }
    if ($c->cekPermainan()) {
        header("Location: kuis.php");
        $_SESSION['skip'] = true;
        exit;
    }
    $gambar = $c->tampilData("tb_" . strtolower($_SESSION['level']) . " WHERE id_" . strtolower($_SESSION['level']) . " = '" . $_SESSION['id_anggota'] . "'", "gambar")[0]['gambar'];
    $config = $c->getKonfigurasi();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $config['nama_aplikasi']; ?></title>
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
    <!-- Slider by w3schools.com -->
    <link rel="stylesheet" href="css/slider.css">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="css/style.<?= $config['tema']; ?>.css" id="theme-stylesheet">
    <!-- Bootstrap-select -->
    <link rel="stylesheet" href="vendor/bootstrap-select/css/bootstrap-select.min.css">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="css/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/favicon.ico?t=<?= strtotime($config['last_updated']); ?>" id="favicon">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
  </head>
  <body>
    <div id="blank"></div>
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
                  <div class="brand-text brand-big"><span><?= $config['nama_aplikasi']; ?></span></div>
                  <a id="toggle-btn" href="#" class="d-xl-none menu-btn active"><span></span><span></span><span></span></a>
                </a>
              </div>
              <div class="brand-text d-xl-none" style="font-size: 20px;"><span><?= $config['nama_aplikasi']; ?></span></div>
              <!-- Navbar Menu -->
              <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                <!-- Languages dropdown    -->
                <li class="nav-item dropdown">
                  <a id="languages" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link language dropdown-toggle">
                    <span class="d-sm-none d-md-none d-lg-none d-xl-none">
                      <i class="fa fa-user fa-2x"></i>
                    </span>
                    <span class="d-none d-sm-inline-block"><?= $c->getNama(); ?></span>
                  </a>
                  <ul aria-labelledby="languages" class="dropdown-menu" style="list-style-type: none;">
                    <li class="dropdown-item d-sm-none d-md-none d-lg-none d-xl-none"><?= $c->getNama() . "\t-\t" . $c->getLevel(); ?></li>
                    <li id="btnUser"><a rel="nofollow" href="#" class="dropdown-item"><i class="fa fa-user"></i>Profil</a></li>
                    <li id="btnGantiPass"><a rel="nofollow" href="#" class="dropdown-item"><i class="fa fa-key"></i>Ganti Password</a></li>
                    <li class="d-sm-none d-md-none d-lg-none d-xl-none"><a rel="nofollow" href="javascript:void(0);" class="dropdown-item logout"><i class="fa fa-sign-out"></i>Logout</a></li>
                  </ul>
                </li>
                <!-- Logout    -->
                <li class="nav-item d-none d-sm-inline-block" id="logout"><a href="javascript:void(0);" class="nav-link logout">Logout<i class="fa fa-sign-out"></i></a></li>
              </ul>
            </div>
          </div>
        </nav>
      </header>
      <div class="page-content d-flex align-items-stretch"> 
        <!-- Side Navbar -->
        <nav class="side-navbar" style="position: relative; height: 600px; overflow-y: auto;">
          <!-- Sidebar Header-->
          <div class="sidebar-header d-flex align-items-center">
            <div class="avatar">
              <img src="img-db/<?= $gambar; ?>"  id="avatar-img" class="img-fluid rounded-circle">
            </div>
            <div class="title">
              <h1 class="h4"><?= $c->getNama(); ?></h1>
              <p><?= $c->getLevel(); ?></p>
            </div>
          </div>
          <!-- Sidebar Navidation Menus-->
          <span class="heading">Beranda</span>
          <ul class="list-unstyled">
              <li id="btnDashboard">
                <a href="#">
                  <i class="icon-home"></i>Dashboard
                </a>
              </li>
          </ul>
          <?php if ($c->cekLevel("Admin")): ?>
          <span class="heading">Admin</span>
          <ul class="list-unstyled">
            <li id="btnDaftar">
              <a href="#">
                <i class="icon-user"></i>Daftar Anggota
              </a>
            </li>
            <li id="btnKonfig">
              <a href="#">
                <i class="fa fa-gear"></i>Konfigurasi
              </a>
            </li>
          </ul>
          <?php endif ?>
          <?php if ($c->cekLevel("Siswa")): ?>
          <!-- <SISWA SIDEBAR> -->
          <span class="heading">Kuis</span>
          <ul class="list-unstyled">
            <li id="btnKuis">
              <a href="#">
                <i class="fa fa-pencil"></i>Mulai Kuis
              </a>
            </li>
          </ul>
          <!-- </SISWA SIDEBAR> -->
          <?php endif ?>
          <?php if ($c->cekLevel("Guru")): ?>
          <span class="heading">Pengelola Kuis</span>
          <ul class="list-unstyled">
            <li>
              <a href="#" aria-expanded="false" data-toggle="collapse" data-target="#btnCollapseKuis">  <i class="icon-paper-airplane"></i>Kelola Masukan </a>
              <ul id="btnCollapseKuis" class="collapse list-unstyled">
                <li id="btnLevel"><a href="#">Kelola Level</a></li>
                <li id="btnSoal"><a href="#">Kelola Soal</a></li>
              </ul>
            </li>
          </ul>
          <?php endif ?>
          <span class="heading">Lainnya</span>
          <ul class="list-unstyled">
            <li id="btnLaporan">
              <a href="#">
                <i class="fa fa-history"></i>Riwayat Permainan
              </a>
            </li>
          </ul>
        </nav>
        <div class="content-inner" style="padding-bottom: 0px;">
          <!-- Page Header-->
          <header class="page-header" style="padding: 10px 0;">
            <div class="container-fluid">
              <div class="row align-items-center">
                <div class="col-9">
                  <h2 class="no-margin-bottom" id="header-judul">Dashboard</h2>
                </div>
                <div class="col-3 text-right">
                  <img style="width: 50px; height: 50px;" src="img/logo/logo.png?t=<?= strtotime($config['last_updated']); ?>" class='logo-footer rounded-circle'>
                </div>
              </div>
            </div>
          </header>
          <!-- Main Page -->
          <br>
          <div id="isi-dashboard">
            <div class="gambarload"></div>
          </div>
          <div class="row d-none w-100 mt-2 ml-0 mb-4 mr-0" id="dashboard-footer">
            <div class="col-md-12">
              <p class="text-center">
                <?php if ($config['izinlogoakhir']): ?>
                  <img src="img/logo/logo.png?t=<?= strtotime($config['last_updated']); ?>" class="logo-footer rounded-circle">
                <?php endif ?>
              </p>
            </div>
          </div>
          <!-- Page Footer-->
          <footer class="main-footer" style="position: fixed; padding: 10px 10px; bottom: 0; z-index: 10; width: inherit;">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-md-6">
                    <p id="company"></p>
                  </div>
                  <div class="col-md-6 text-right">
                    <p>Design by <a href="https://bootstrapious.com/admin-templates" class="external">Bootstrapious</a></p>
                        <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :) -->
                  </div>
                </div>
              </div>
          </footer>
        </div>
      </div>
    </div>
    <!-- JavaScript files-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper.js/umd/popper.min.js"> </script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="vendor/swal/sweetalert2.all.min.js"></script>
    <!-- <script src="vendor/chart.js/Chart.min.js"></script> -->
    <script src="vendor/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script src="vendor/bootstrap-select/js/i18n/defaults-id_ID.min.js"></script>


    <!-- Main File-->
    <script src="js/front.js"></script>
    <script>
      function isNotImported(src) {
        var type = src.substring(src.lastIndexOf('.'));
        if (type == ".js") {  
          return ($("script[src*='" + src + "']").length < 1);
        }
        else if (type == ".css") {
          return ($("link[href*='" + src + "']").length < 1);
        }
      }
        $(document).ready(function() {
            var yearNow = new Date().getFullYear();
            var myName = '<?= $config['nama_perusahaan']; ?> &copy; ' + yearNow;
            $("#company").html(myName);
            var menu = "<?= @$_GET['menu']; ?>";
            var no = "0";
            if (menu == "") {
                menu = "dashboard";
            }
            function isiDashboard(menu, judul){
                document.title =  judul + " - <?= $config['nama_aplikasi']; ?>";
                window.history.pushState({menu: menu}, document.title, "?menu=" + menu);
                $("#header-judul").html(judul);
                $("#isi-dashboard").load("v_" + menu + ".php", function() {
                  $("#dashboard-footer").clone().appendTo('#isi-dashboard').removeClass('d-none');
                });
            }

            function getJudul(menu) {
                switch (menu) {
                    case "dashboard":
                        return "Dashboard";
                    break;
                    case "kuis":
                        return "Pilih Kuis";
                    break;
                    case "laporan":
                        return "Laporan";
                    break;
                    case "user":
                        return "Ganti Profil";
                    break;
                    case "gantipass":
                        return "Ganti Password";
                    break;
                    case "daftar":
                        return "Daftar Anggota";
                    break;
                    case "input_level":
                        return "Kelola Level";
                    break;
                    case "input_soal":
                        return "Kelola Soal";
                    break;
                    case "konfigurasi":
                        return "Konfigurasi Aplikasi";
                    break;
                    default:
                        return false;
                    break;
                }
            }

            function getMenuID(menu) {
                switch (menu) {
                    case "dashboard":
                        return "#btnDashboard";
                    break;
                    case "kuis":
                        return "#btnKuis";
                    break;
                    case "laporan":
                        return "#btnLaporan";
                    break;
                    case "user":
                        return "#btnUser";
                    break;
                    case "gantipass":
                        return "#btnGantiPass";
                    break;
                    case "daftar":
                        return "#btnDaftar";
                    break;
                    case "input_level":
                        return "#btnLevel";
                    break;
                    case "input_soal":
                        return "#btnSoal";
                    break;
                    case "konfigurasi":
                        return "#btnKonfig";
                    break;
                    default:
                        return false;
                    break;
                }
            }

            // FIRST RUN
            isiDashboard(menu, getJudul(menu));
            menuAktif(getMenuID(menu));
            // END FIRST RUN

            function gantiMenu(idmenu, targetmenu){
                $(idmenu).click(function(e) {
                    e.preventDefault();
                    $("#isi-dashboard").html("<div class='gambarload'></div>");
                    menu = targetmenu;
                    judul = getJudul(targetmenu);
                    menuAktif(idmenu);
                    isiDashboard(menu, judul);
                });
            }

            function menuAktif(idmenu) {
                $('li.active').removeClass('active');
                $(idmenu).addClass('active');
            }
            gantiMenu("#btnDashboard","dashboard");
            gantiMenu("#btnKuis","kuis");
            gantiMenu("#btnLaporan","laporan");
            gantiMenu("#btnUser","user");
            gantiMenu("#btnGantiPass","gantipass");
            gantiMenu("#btnDaftar","daftar");
            gantiMenu("#btnLevel","input_level");
            gantiMenu("#btnSoal","input_soal");
            gantiMenu("#btnKonfig","konfigurasi");

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
            $(".logout").click(function() {
              logout();
            });
        }); // end jquery
    </script>
  </body>
</html>