$(function() {
  var egg = document.getElementById("egg");
  function playEgg() {
    egg.play();
    $("#egg-play").remove();
    $("#egg-close").show(0);
    $(".logo img").fadeIn(500).delay(2500).fadeOut(500, function() {
      $('.logo h2').fadeIn(500).delay(2500).fadeOut(500, function() {
        $('.logo .egg-end').delay(1000).fadeIn(500, function () {
          $("#egg-control").fadeIn(500);
          $("#egg-mute").fadeIn(500);
        });
      });
    });
    egg.addEventListener('ended', function () {
      egg.currentTime = 22.073;
      egg.play();
    });
  }
  $("#egg-play").click(function() {
    playEgg();
  });
  $("#egg-control").click(function() {
    if (egg.paused) {
      $(this).html('Pause');
      egg.play();
    }
    else {
      $(this).html('Resume');
      egg.pause();
    }
  });
  $("#egg-mute").click(function() {
    egg.muted = !egg.muted;
    $(this).text(egg.muted ? "Unmute" : "Mute");
  });
  $("#egg-close").click(function() {
    swal({
      type: 'success',
      text: 'Easter Egg 01: Author',
      toast: true,
      timer: 3000,
      position: 'bottom-end'
    });
    $("#blank").html(null);
  });
});