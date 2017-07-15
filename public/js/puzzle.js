// puzzle script here
$(document).ready(function() {

  // get video height and width and set video height and width
  var videoHeight = $('#v').height();
  var videoWidth = $('#v').width();
  $('#v').width(videoWidth * 2);
  $('#v').height(videoHeight * 2);



  // initialize puzzle
  for (var i = 0; i < matrix_x; i++) {
    for (var j = 0; j < matrix_y; j++) {
      create_pieaces (i, j, matrix_x, matrix_y);
    }
  }


  function create_pieaces (x, y, matrix_x, matrix_y) {

    var videoHeight = $('#v').height();
    var videoWidth = $('#v').width();
    // $('.canvas_pieces').width((videoWidth/matrix_x) * 1.25);
    // $('.canvas_pieces').height((videoHeight/matrix_y) * 1.25);

    var clipping_path = "";
    var convas_rate_width = 0;
    var convas_rate_height = 0;
    var canvas_location_x = 0;
    var canvas_location_y = 0;
    clipping_path = "-webkit-clip-path: polygon(0 0, 19.5% 0, 40% 0, 60% 0, 80.5% 0, 80.5% 19.5%, 100% 40%, 80.5% 60%, 80.5% 80.5%, 60% 80.5%, 40% 100%, 19.5% 80.5%, 0 80.5%, 0 60%, 0 40%, 0 19.5%);clip-path: polygon(0 0, 19.5% 0, 40% 0, 60% 0, 80.5% 0, 80.5% 19.5%, 100% 40%, 80.5% 60%, 80.5% 80.5%, 60% 80.5%, 40% 100%, 19.5% 80.5%, 0 80.5%, 0 60%, 0 40%, 0 19.5%); width:"+((videoWidth/matrix_x) * 1.25)+"px; height:"+((videoHeight/matrix_y) * 1.25)+"px;";
    convas_rate_width = 1;
    convas_rate_height = 1;
    canvas_location_x = 1.25;
    canvas_location_y = 1.25;

    if((x == 0) && (y == 0)) {
      clipping_path = "-webkit-clip-path: polygon(0 0, 19.5% 0, 40% 0, 60% 0, 80.5% 0, 80.5% 19.5%, 100% 40%, 80.5% 60%, 80.5% 80.5%, 60% 80.5%, 40% 100%, 19.5% 80.5%, 0 80.5%, 0 60%, 0 40%, 0 19.5%);clip-path: polygon(0 0, 19.5% 0, 40% 0, 60% 0, 80.5% 0, 80.5% 19.5%, 100% 40%, 80.5% 60%, 80.5% 80.5%, 60% 80.5%, 40% 100%, 19.5% 80.5%, 0 80.5%, 0 60%, 0 40%, 0 19.5%); width:"+((videoWidth/matrix_x) * 1.25)+"px; height:"+((videoHeight/matrix_y) * 1.25)+"px;";
      convas_rate_width = 1;
      convas_rate_height = 1;
      canvas_location_x = 1.25;
      canvas_location_y = 1.25;
    }
    else if((x == 0) && (y < (matrix_y -1))) {
      clipping_path = "-webkit-clip-path: polygon(0 0, 19.5% 0, 40% 19.5%, 60% 0, 80.5% 0, 80.5% 19.5%, 100% 40%, 80.5% 60%, 80.5% 80.5%, 60% 80.5%, 40% 100%, 19.5% 80.5%, 0 80.5%, 0 60%, 0 40%, 0 19.5%);clip-path: polygon(0 0, 19.5% 0, 40% 19.5%, 60% 0, 80.5% 0, 80.5% 19.5%, 100% 40%, 80.5% 60%, 80.5% 80.5%, 60% 80.5%, 40% 100%, 19.5% 80.5%, 0 80.5%, 0 60%, 0 40%, 0 19.5%); width:"+((videoWidth/matrix_x) * 1.25)+"px; height:"+((videoHeight/matrix_y) * 1.25)+"px;";
      convas_rate_width = 1.25;
      convas_rate_height = 1.25;
      canvas_location_x = 1.55;
      canvas_location_y = 1.55;
    }
    else if((x < (matrix_x -1)) && (y == 0)) {
      clipping_path = "-webkit-clip-path: polygon(0 0, 19.5% 0, 40% 0, 60% 0, 80.5% 0, 80.5% 19.5%, 100% 40%, 80.5% 60%, 80.5% 80.5%, 60% 80.5%, 40% 100%, 19.5% 80.5%, 0 80.5%, 0 60%, 19.5% 40%, 0 19.5%);clip-path: polygon(0 0, 19.5% 0, 40% 0, 60% 0, 80.5% 0, 80.5% 19.5%, 100% 40%, 80.5% 60%, 80.5% 80.5%, 60% 80.5%, 40% 100%, 19.5% 80.5%, 0 80.5%, 0 60%, 19.5% 40%, 0 19.5%); width:"+((videoWidth/matrix_x) * 1.25)+"px; height:"+((videoHeight/matrix_y) * 1.25)+"px;";
      convas_rate_width = 1;
      convas_rate_height = 1;
      canvas_location_x = 1.25;
      canvas_location_y = 1.25;
    }
    else if((x < (matrix_x -1)) && (y < (matrix_y -1))) {
      clipping_path = "-webkit-clip-path: polygon(0 0, 19.5% 0, 40% 19.5%, 60% 0, 80.5% 0, 80.5% 19.5%, 100% 40%, 80.5% 60%, 80.5% 80.5%, 60% 80.5%, 40% 100%, 19.5% 80.5%, 0 80.5%, 0 60%, 19.5% 40%, 0 19.5%);clip-path: polygon(0 0, 19.5% 0, 40% 19.5%, 60% 0, 80.5% 0, 80.5% 19.5%, 100% 40%, 80.5% 60%, 80.5% 80.5%, 60% 80.5%, 40% 100%, 19.5% 80.5%, 0 80.5%, 0 60%, 19.5% 40%, 0 19.5%); width:"+((videoWidth/matrix_x) * 1.25)+"px; height:"+((videoHeight/matrix_y) * 1.25)+"px;";
      convas_rate_width = 1.25;
      convas_rate_height = 1.25;
      canvas_location_x = 1.55;
      canvas_location_y = 1.55;
    }
    else if((x == (matrix_x -1)) && (y < (matrix_y -1))) {
      clipping_path = "-webkit-clip-path: polygon(0 0, 24.5% 0, 50% 19.5%, 75% 0, 100% 0, 100% 26%, 100% 40%, 100% 54%, 100% 80.5%, 75% 80.5%, 50% 100%, 24.5% 80.5%, 0 80.5%, 0 60%, 24.5% 40%, 0 19.5%);clip-path: polygon(0 0, 24.5% 0, 50% 19.5%, 75% 0, 100% 0, 100% 26%, 100% 40%, 100% 54%, 100% 80.5%, 75% 80.5%, 50% 100%, 24.5% 80.5%, 0 80.5%, 0 60%, 24.5% 40%, 0 19.5%); width:"+((videoWidth/matrix_x) * 1)+"px; height:"+((videoHeight/matrix_y) * 1.25)+"px;";
      convas_rate_width = 1.25;
      convas_rate_height = 1;
      canvas_location_x = 1.25;
      canvas_location_y = 1.25;

      if((x == (matrix_x -1)) && (y == 0)) {
        clipping_path = "-webkit-clip-path: polygon(0 0, 19.5% 0, 40% 0, 60% 0, 80.5% 0, 80.5% 19.5%, 80.5% 40%, 80.5% 60%, 80.5% 80.5%, 60% 80.5%, 40% 100%, 19.5% 80.5%, 0 80.5%, 0 60%, 19.5% 40%, 0 19.5%);clip-path: polygon(0 0, 19.5% 0, 40% 0, 60% 0, 80.5% 0, 80.5% 19.5%, 80.5% 40%, 80.5% 60%, 80.5% 80.5%, 60% 80.5%, 40% 100%, 19.5% 80.5%, 0 80.5%, 0 60%, 19.5% 40%, 0 19.5%); width:"+((videoWidth/matrix_x) * 1.25)+"px; height:"+((videoHeight/matrix_y) * 1.25)+"px;";
        convas_rate_width = 1;
        convas_rate_height = 1;
        canvas_location_x = 1.25;
        canvas_location_y = 1.25;
      }
    }
    else if((x < (matrix_x -1)) && (y == (matrix_y -1))) {
      clipping_path = "-webkit-clip-path: polygon(0 0, 19.5% 0, 40% 24.5%, 60% 0, 80.5% 0, 80.5% 24.5%, 100% 50%, 80.5% 75%, 80.5% 100%, 54% 100%, 39% 100%, 24.5% 100%, 0 100%, 0 75%, 19.5% 50%, 0 24.5%);clip-path: polygon(0 0, 19.5% 0, 40% 24.5%, 60% 0, 80.5% 0, 80.5% 24.5%, 100% 50%, 80.5% 75%, 80.5% 100%, 54% 100%, 39% 100%, 24.5% 100%, 0 100%, 0 75%, 19.5% 50%, 0 24.5%); width:"+((videoWidth/matrix_x) * 1.25)+"px; height:"+((videoHeight/matrix_y) * 1)+"px;";
      convas_rate_width = 1;
      convas_rate_height = 1.25;
      if((x == 0) && (y == (matrix_y -1))) {
        clipping_path = "-webkit-clip-path: polygon(0 0, 19.5% 0, 40% 24.5%, 60% 0, 80.5% 0, 80.5% 24.5%, 100% 50%, 80.5% 75%, 80.5% 100%, 54% 100%, 39% 100%, 24.5% 100%, 0 100%, 0 75%, 0 50%, 0 24.5%);clip-path: polygon(0 0, 19.5% 0, 40% 24.5%, 60% 0, 80.5% 0, 80.5% 24.5%, 100% 50%, 80.5% 75%, 80.5% 100%, 54% 100%, 39% 100%, 24.5% 100%, 0 100%, 0 75%, 0 50%, 0 24.5%); width:"+((videoWidth/matrix_x) * 1.25)+"px; height:"+((videoHeight/matrix_y) * 1)+"px;";
        convas_rate_width = 1;
        convas_rate_height = 1.25;
        canvas_location_x = 1.25;
        canvas_location_y = 1.25;
      }
    }
    else if((x == (matrix_x -1)) && (y == (matrix_y -1))) {
      clipping_path = "-webkit-clip-path: polygon(0 0, 24.5% 0, 50% 24.5%, 75% 0, 100% 0, 100% 19.5%, 100% 40%, 100% 60%, 100% 100%, 66% 100%, 51% 100%, 24.5% 100%, 0 100%, 0 75%, 24.5% 50%, 0 24.5%);clip-path: polygon(0 0, 24.5% 0, 50% 24.5%, 75% 0, 100% 0, 100% 19.5%, 100% 40%, 100% 60%, 100% 100%, 66% 100%, 51% 100%, 24.5% 100%, 0 100%, 0 75%, 24.5% 50%, 0 24.5%);; width:"+((videoWidth/matrix_x) * 1)+"px; height:"+((videoHeight/matrix_y) * 1)+"px;";
      convas_rate_width = 1.25;
      convas_rate_height = 1.25;
      canvas_location_x = 1.25;
      canvas_location_y = 1.25;
    }



    // randomize the pieaces
    var random_x_coord = Math.floor((Math.random() * 90) + 1);
    var random_y_coord = Math.floor((Math.random() * 400) + 1);

    $(".puzzle_wrapper").append("<div id='pieaces_"+x+y+"' data-number='"+x+y+"' class='canvas_pieces' style='"+clipping_path+" left: "+random_x_coord+"%; top:"+random_y_coord+"px;'><canvas id='target_canvas"+x+y+"'></canvas></div>");

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
    setTimeout(draw,10,v,c,bc,w,h,x,y,matrix_x, matrix_y);
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
        setTimeout(loop, 1000 / 30); // drawing at 30fps
      }
    })();
  }, 0);

  $('.video_preview_wrapper').draggable({
    containment: '.body_container'
  }).css({
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


  $('.close_preview_button').click(function() {
    $('.video_preview_wrapper').fadeOut();
  });
});
