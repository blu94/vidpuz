// puzzle script here
$(document).ready(function() {

  function adjustStyle(width) {
    width = parseInt(width);
    if (width < 701) {
    } else if (width < 1100) {
      show_hints_mobile();
    } else {
      show_hints_desk();
    }
  }

  // responsive
  $(function() {
      adjustStyle(screen.width);
      $(window).resize(function() {
        adjustStyle(screen.width);
      });
  });

  $('#v').get(0).play();

  // drag up and down prevent scroll on mobile
  $(".puzzle_wrapper").bind('touchmove', function(e) {
    e.preventDefault();
  }, false);
  // get video height and width and set video height and width
  var videoHeight = $('#v').height();
  var videoWidth = $('#v').width();
  // $('#v').width(videoWidth * 2);
  // $('#v').height(videoHeight * 2);
  $('#v').width(600);
  $('#v').height(300);



  // initialize puzzle
  var hints_counter = 0;
  for (var i = 0; i < matrix_x; i++) {
    for (var j = 0; j < matrix_y; j++) {
      hints_counter+=1;
      create_pieaces (i, j, matrix_x, matrix_y, hints_counter);
    }
  }


  function create_pieaces (x, y, matrix_x, matrix_y, hints_counter) {

    var videoHeight = $('#v').height();
    var videoWidth = $('#v').width();
    // $('.canvas_pieces').width((videoWidth/matrix_x) * 1.25);
    // $('.canvas_pieces').height((videoHeight/matrix_y) * 1.25);

    var extra_styles = "";
    var pieces_class = "";
    var alignment_of_hints = "";
    var convas_rate_width = 0;
    var convas_rate_height = 0;
    var canvas_location_x = 0;
    var canvas_location_y = 0;
    extra_styles = "width:"+((videoWidth/matrix_x) * 1.25)+"px; height:"+((videoHeight/matrix_y) * 1.25)+"px;";
    pieces_class = "pieces_top_left";
    alignment_of_hints = "padding_20per_btm_rgt";
    convas_rate_width = 1;
    convas_rate_height = 1;
    canvas_location_x = 1.25;
    canvas_location_y = 1.25;

    if((x == 0) && (y == 0)) {
      extra_styles = "width:"+((videoWidth/matrix_x) * 1.25)+"px; height:"+((videoHeight/matrix_y) * 1.25)+"px;";
      pieces_class = "pieces_top_left";
      alignment_of_hints = "padding_20per_btm_rgt";
      convas_rate_width = 1;
      convas_rate_height = 1;
      canvas_location_x = 1.25;
      canvas_location_y = 1.25;
    }
    else if((x == 0) && (y < (matrix_y -1))) {
      extra_styles = "width:"+((videoWidth/matrix_x) * 1.25)+"px; height:"+((videoHeight/matrix_y) * 1.25)+"px;";
      pieces_class = "pieces_center_left";
      alignment_of_hints = "padding_20per_btm_rgt";
      convas_rate_width = 1.25;
      convas_rate_height = 1.25;
      canvas_location_x = 1.55;
      canvas_location_y = 1.55;
    }
    else if((x < (matrix_x -1)) && (y == 0)) {
      extra_styles = "width:"+((videoWidth/matrix_x) * 1.25)+"px; height:"+((videoHeight/matrix_y) * 1.25)+"px;";
      pieces_class = "pieces_top_center";
      alignment_of_hints = "padding_20per_btm_rgt";
      convas_rate_width = 1;
      convas_rate_height = 1;
      canvas_location_x = 1.25;
      canvas_location_y = 1.25;
    }
    else if((x < (matrix_x -1)) && (y < (matrix_y -1))) {
      extra_styles = "width:"+((videoWidth/matrix_x) * 1.25)+"px; height:"+((videoHeight/matrix_y) * 1.25)+"px;";
      pieces_class = "pieces_center_center";
      alignment_of_hints = "padding_20per_btm_rgt";
      convas_rate_width = 1.25;
      convas_rate_height = 1.25;
      canvas_location_x = 1.55;
      canvas_location_y = 1.55;
    }
    else if((x == (matrix_x -1)) && (y < (matrix_y -1))) {
      extra_styles = "width:"+((videoWidth/matrix_x) * 1)+"px; height:"+((videoHeight/matrix_y) * 1.25)+"px;";
      pieces_class = "pieces_center_right";
      alignment_of_hints = "padding_20per_btm";
      convas_rate_width = 1.25;
      convas_rate_height = 1;
      canvas_location_x = 1.25;
      canvas_location_y = 1.25;

      if((x == (matrix_x -1)) && (y == 0)) {
        extra_styles = "width:"+((videoWidth/matrix_x) * 1)+"px; height:"+((videoHeight/matrix_y) * 1.25)+"px;";
        pieces_class = "pieces_top_right";
        alignment_of_hints = "padding_20per_btm";
        convas_rate_width = 1.25;
        convas_rate_height = 1;
        canvas_location_x = 1.25;
        canvas_location_y = 1.25;
      }
    }
    else if((x < (matrix_x -1)) && (y == (matrix_y -1))) {
      extra_styles = "width:"+((videoWidth/matrix_x) * 1.25)+"px; height:"+((videoHeight/matrix_y) * 1)+"px;";
      pieces_class = "pieces_bottom_center";
      alignment_of_hints = "padding_20per_rgt";
      convas_rate_width = 1;
      convas_rate_height = 1.25;
      if((x == 0) && (y == (matrix_y -1))) {
        extra_styles = "width:"+((videoWidth/matrix_x) * 1.25)+"px; height:"+((videoHeight/matrix_y) * 1)+"px;";
        pieces_class = "pieces_bottom_left";
        alignment_of_hints = "padding_20per_rgt";
        convas_rate_width = 1;
        convas_rate_height = 1.25;
        canvas_location_x = 1.25;
        canvas_location_y = 1.25;
      }
    }
    else if((x == (matrix_x -1)) && (y == (matrix_y -1))) {
      extra_styles = "width:"+((videoWidth/matrix_x) * 1)+"px; height:"+((videoHeight/matrix_y) * 1)+"px;";
      pieces_class = "pieces_bottom_right";
      alignment_of_hints = "";
      convas_rate_width = 1.25;
      convas_rate_height = 1.25;
      canvas_location_x = 1.25;
      canvas_location_y = 1.25;
    }



    // randomize the pieaces
    var random_x_coord = Math.floor((Math.random() * 90) + 1);
    var random_y_coord = Math.floor((Math.random() * 250) + 1);

    $(".puzzle_wrapper").append("<div id='pieaces_"+x+y+"' data-number='"+x+y+"' class='canvas_pieces "+pieces_class+"' style='"+extra_styles+" left: "+random_x_coord+"%; top:"+random_y_coord+"px;'><span class='hints_container "+alignment_of_hints+"'>"+hints_counter+"</span><canvas id='target_canvas"+x+y+"'></canvas></div>");

    var v = document.getElementById('v');
    var canvas = document.getElementById('target_canvas'+x+y);
    var context = canvas.getContext('2d');
    var back = document.createElement('canvas');
    var backcontext = back.getContext('2d');



    // grid wrapper size
    $('.puzzle_grids_wrapper').width((videoWidth/matrix_x) * matrix_x);
    $('.puzzle_grids_wrapper').height((videoHeight/matrix_y) * matrix_y);

    // grid item size
    $('.grid_item'+x+y).width(videoWidth/matrix_x);
    $('.grid_item'+x+y).height(videoHeight/matrix_y);

    if(y == (matrix_y - 1)) {
      $('.grid_item'+x+y).css({'clear':'right'});
    }


    // $('.canvas_pieces #c'+x+y).css({'left': (-100 * x)+'%', 'top': (-100 * y)+'%'});
    var cw,ch;

    v.addEventListener('play', function(){
      cw = v.clientWidth * convas_rate_width;
      ch = v.clientHeight * convas_rate_height;
      canvas.width = (videoWidth/matrix_x) * canvas_location_x;
      canvas.height = (videoHeight/matrix_y) * canvas_location_y;
      back.width = cw;
      back.height = ch;


      draw(v,context,context,cw,ch,x,y,matrix_x, matrix_y);
    },false);
  }

  function draw(v,c,bc,w,h,x,y,matrix_x,matrix_y) {
    if(v.paused || v.ended)	return false;
    // First, draw it into the backing canvas

    var x_coord = -((w/matrix_x) * x);
    var y_coord = -((h/matrix_y) * y);
    // alert(x_coord+','+y_coord);

    bc.drawImage(v,x_coord,y_coord,w,h);
    // Grab the pixel data from the backing canvas
    var idata = bc.getImageData(0,0,(w),(h));


    var data = idata.data;
    // Loop through the pixels, turning them grayscale
    // for(var i = 0; i < data.length; i+=4) {
    //   var r = data[i];
    //   var g = data[i+1];
    //   var b = data[i+2];
    //   var brightness = (3*r+4*g+b)>>>3;
    //   data[i] = brightness;
    //   data[i+1] = brightness;
    //   data[i+2] = brightness;
    // }
    idata.data = data;
    // Draw the pixels onto the visible canvas
    c.putImageData(idata,0,0);
    // Start over!
    // setTimeout(draw,30,v,c,bc,w,h,x,y,matrix_x, matrix_y);
    window.requestAnimationFrame(function(timestamp) { draw(v,c,bc,w,h,x,y,matrix_x,matrix_y);})
  }

  // drag individual pieace
  $( ".canvas_pieces" ).draggable({
    containment: '.puzzle_wrapper',
    start: function(e) {
      $('.canvas_pieces').css({'z-index':'998'});
      $(this).css({'z-index':'1000'});
    }
  });

  // add preview box
  var canvas = document.getElementById('target_video');
  var ctx = canvas.getContext('2d');
  var video = document.getElementById('v');

  // set canvas size = video size when known
  video.addEventListener('loadedmetadata', function() {
    canvas.width = (videoWidth / 0.8);
    canvas.height = (videoHeight / 0.8);
  });

  video.addEventListener('play', function() {
    var $this = this; //cache
    (function loop() {
      if (!$this.paused && !$this.ended) {
        ctx.drawImage($this, 0, 0, (videoWidth / 0.8), (videoHeight / 0.8));
        requestAnimationFrame(loop); // drawing at 30fps
        // setTimeout(loop, 1000 / 30); // drawing at 30fps
      }
    })();
  }, 0);

  $('.video_preview_wrapper').draggable({
    containment: '.body_container'
  }).css({
    'display': 'none',
    'width': (videoWidth / 0.8),
    'height' : (videoHeight / 0.8),
    'right' : (videoWidth / 0.8)
  }).resizable({
    maxWidth: (videoWidth / 0.8),
    maxHeight: (videoHeight / 0.8),
    minWidth: (videoWidth / 0.8) - 50,
    minHeight: (videoHeight / 0.8) - 50,
    aspectRatio: true
  });

  // close preview button
  $('.close_preview_button').click(function() {
    $('.video_preview_wrapper').fadeOut();
  });

  // video volume
  $('#volume_range').range({
    min: 0,
    max: 10,
    start: 0,
    onChange: function(value) {

      if (value == 0) {
        $('.volume_btn').removeClass('up');
        $('.volume_btn').removeClass('down');
        $('.volume_btn').removeClass('off');
        $('.volume_btn').addClass('off');
      }
      else if (value > 0 && value < 10) {
        $('.volume_btn').removeClass('up');
        $('.volume_btn').removeClass('down');
        $('.volume_btn').removeClass('off');
        $('.volume_btn').addClass('down');
      }
      else if (value == 10) {
        $('.volume_btn').removeClass('up');
        $('.volume_btn').removeClass('down');
        $('.volume_btn').removeClass('off');
        $('.volume_btn').addClass('up');
      }
      $(".source_video").prop('muted', false);
      $('.source_video').prop("volume", (value / 10));
    }
  });

  $('.play_pause_btn_video').click(function() {
    var play_pause_status = $(this).children('.icon').attr('class');

    // alert(play_pause_status);
    if (~play_pause_status.indexOf('pause')) {
      $(this).children('.icon').removeClass('pause');
      $(this).children('.icon').removeClass('play');
      $(this).children('.icon').addClass('play');
      $(this).children('.play_pause_btn_title').text('Play');
      $('#v')[0].pause();
    }
    else if (~play_pause_status.indexOf('play')) {
      $(this).children('.icon').removeClass('pause');
      $(this).children('.icon').removeClass('play');
      $(this).children('.icon').addClass('pause');
      $(this).children('.play_pause_btn_title').text('Pause');
      $('#v')[0].play();
    }
  });

  // show hints
  $('.hints_container').fadeOut();

  function show_hints_desk () {
    $('.show_hints').on('mousedown', function() {
      $('.hints_container').fadeIn().css({'display':'flex'});
    }).on('mouseup mouseleave', function() {
      $('.hints_container').fadeOut();
    });
  }

  function show_hints_mobile () {
    $('.show_hints').on('touchstart', function() {
      $('.hints_container').fadeIn().css({'display':'flex'});
    }).on('touchend', function() {
      $('.hints_container').fadeOut();
    });
  }


  // start stopwatch
  var taken_time = $('.timer_wrapper .duration').runner({
    autostart: true,
    format: function(value) {
      var ms = value % 1000;
      value = (value - ms) / 1000;
      var secs = value % 60;
      value = (value - secs) / 60;
      var mins = value % 60;
      var hrs = (value - mins) / 60;

      return pad(hrs) + ':' + pad(mins) + ':' + pad(secs);
    }
  });

  function pad(d) {
    return (d < 10) ? '0' + d.toString() : d.toString();
  }


});
