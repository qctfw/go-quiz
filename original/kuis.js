var countdown, waktu, id_soal;
$(document).ready(function() {
  function reloadKuisAjax() {
    $("#field-kuis").addClass('d-none');
    $("#loadkuis").removeClass('d-none');
    $.ajax({
      url: 'ajax_kuis.php',
      type: 'GET',
      dataType: 'json',
      data: {soal: true},
      success: function(data) {
        if (data.selesai) {
          $("#isi-kuis").load("hasil_kuis.php");
        }
        else {
          $("#nyawa").html("");
          id_soal = data.soal.id_soal;
          for (var i = 1; i <= 3; i++) {
            var gambarnyawa = "<img class='my-2' src='img/heart";
            if (data.nyawa < i) {
              gambarnyawa = gambarnyawa + "-d";
            }
            gambarnyawa = gambarnyawa + ".svg' width='30' height='30' style='float:left;'>";
            $("#nyawa").append(gambarnyawa);
          }
          $("#namalevel-1").html(data.namalevel);
          $("#namalevel-2").html(data.namalevel);
          $("#nomorsoal").html(data.nomorsoal + "/" + data.totalsoal);
          $("#deskripsi_soal").html(data.soal.deskripsi_soal);
          if (data.soal.gambar != null) {
            $("#gambar").attr('onclick','window.open("img-soal/' + data.soal.gambar + '","_blank")');
            $("#gambar").html("<img src='img-soal/" + data.soal.gambar + "' style='max-width: 100%; max-height: 100%;'>");
          }
          else {
            $("#gambar").attr('onclick','javascript:void(0);');
            $("#gambar").html("");
          }
          $("#jawaban_a").html(data.soal.jawaban_a);
          $("#jawaban_b").html(data.soal.jawaban_b);
          $("#jawaban_c").html(data.soal.jawaban_c);
          $("#jawaban_d").html(data.soal.jawaban_d);
          waktu = data.waktu;
          $("#pembuat").html("Soal ini dibuat oleh: " + data.soal.nama);
          $("#tgl_buat").html(data.soal.tgl_buat);
          $('#btn-jawab').attr('disabled',false);
          $("#loadkuis").addClass('d-none');
          $("#field-kuis").removeClass('d-none');
          setWaktu();
          countdownManager(true);
        }
      },
      error: function (jqXHR) {
        failSwal();
      }
    });
  }
  reloadKuisAjax();
  function failSwal(optional) {
      optional = optional || "";
      swal({
          type: "warning",
          text: "Koneksi anda sedang bermasalah." + optional,
          position: "bottom-end",
          toast: true
      });
  }
  function cheatSwal(){
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
  }
  function setWaktu() {
    if ($("#waktu").data('seconds') == null) {
      $("#waktu").timer({
        countdown: true,
        duration: waktu,
        format: '%M:%S',
        callback: function(){
		  if ($("#waktu").length == 1) {
			$("#field-kuis").html("<h1 style='background: rgba(0,0,0,0);'>Waktu Habis!</h1>");
				swal({
					type: 'info',
					title: 'Waktu Habis!',
					text: 'Waktu anda sudah habis!',
					animation: false,
					customClass: 'animated tada',
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
		  }
        }
      });
      $("#waktu").timer();
    }
    else {
      $("#waktu").timer('resume');
    }
  }
  function countdownManager(flag) {
    if (flag) {
      countdown = setInterval(function(){
		if ($("#waktu").length < 1) {
      console.log("Cheat Detected: Removing timer");
			$.post('ajax_kuis.php',{cheated: true}, function(){
				$("#field-kuis").html("<h1 style='background: rgba(0,0,0,0);'>Don't cheating</h1>");
                clearInterval(countdown);
				cheatSwal();
			});
		}
        else if ($("#waktu").data('seconds') > 0) {
          $.ajax({
            url: 'ajax_kuis.php',
            type: 'POST',
            dataType: 'json',
            data: {waktu: $("#waktu").data('seconds')},
            success: function (data) {
              if (data.cheated) {
                console.log('Cheat Detected: Modifying timer');
                $("#field-kuis").html("<h1 style='background: rgba(0,0,0,0);'>Don't cheating</h1>");
                clearInterval(countdown);
                $("#waktu").timer("remove");
                cheatSwal();
              }
            },
            error: function (jqXHR) {
              failSwal(" Error Code: " + jqXHR.status);
            }
          });
        }
      },1000);
    }
    else {
      clearInterval(countdown);
    }
  }
  $("#formjawab").submit(function(e) {
    e.preventDefault();
    countdownManager(false);
    $("#waktu").timer('pause');
    $("#loadsubmit").show(0);
    $('#btn-jawab').hide(0);
    if ($("[name=jawaban]").is(':checked')) {
      $.post('ajax_kuis.php', $(this).serialize() + "&" + $.param({idsoal:id_soal, time: $("#waktu").data('seconds')}), function(data) {
        if (data == 'true') {
          swal("BENAR!", "Jawaban Anda Benar!", "success").then(function(){
            $("#waktu").timer("remove");
            reloadKuisAjax();
          });
        }
        else {
          swal("SALAH!", "Jawaban Anda Salah! Nyawa berkurang 1", "warning").then(function(){
            reloadKuisAjax();
          });
        }
        $("#loadsubmit").hide(0);
        $('#btn-jawab').show(0);
        $("[name=jawaban]").prop('checked', false);
        $("label.btn.btn-primary").removeClass('active').removeClass('btn-success');
      });
    }
    else {
      swal("Anda belum menjawab soal!","", "warning").then(function(){$('#btn-jawab').attr('disabled',false);});
    }
  });
  
  $("input[name=jawaban]").change(function() {
    $(".btn-success").removeClass('btn-success');
    $("input[name=jawaban]:checked").parent().addClass("btn-success");
  });
});