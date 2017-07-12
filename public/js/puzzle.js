// puzzle script here
$(document).ready(function() {

  // drag video preview container
  // $( ".video_preview_wrapper" ).draggable({
  //   containment: '.body_container'
  // });

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
    var clipping_path = "";
    clipping_path = "-webkit-clip-path: polygon(0 0, 18% 0, 33% 0, 49% 0, 67% 0, 67% 18%, 82% 33%, 67% 49%, 67% 67%, 49% 67%, 33% 82%, 18% 67%, 0 67%, 0 49%, 0 33%, 0 18%);clip-path: polygon(0 0, 18% 0, 33% 0, 49% 0, 67% 0, 67% 18%, 82% 33%, 67% 49%, 67% 67%, 49% 67%, 33% 82%, 18% 67%, 0 67%, 0 49%, 0 33%, 0 18%);";

    if((x == 0) && (y == 0)) {
      clipping_path = "-webkit-clip-path: polygon(0 0, 18% 0, 33% 0, 49% 0, 67% 0, 67% 18%, 82% 33%, 67% 49%, 67% 67%, 49% 67%, 33% 82%, 18% 67%, 0 67%, 0 49%, 0 33%, 0 18%);clip-path: polygon(0 0, 18% 0, 33% 0, 49% 0, 67% 0, 67% 18%, 82% 33%, 67% 49%, 67% 67%, 49% 67%, 33% 82%, 18% 67%, 0 67%, 0 49%, 0 33%, 0 18%);";
    }
    else if((x == 0) && (y < (matrix_y -1))) {
      clipping_path = "-webkit-clip-path: polygon(0 0, 18% 0, 33% 15%, 49% 0, 67% 0, 67% 18%, 82% 33%, 67% 49%, 67% 67%, 49% 67%, 33% 82%, 18% 67%, 0 67%, 0 49%, 0 33%, 0 18%);clip-path: polygon(0 0, 18% 0, 33% 15%, 49% 0, 67% 0, 67% 18%, 82% 33%, 67% 49%, 67% 67%, 49% 67%, 33% 82%, 18% 67%, 0 67%, 0 49%, 0 33%, 0 18%);";
    }
    else if((x < (matrix_x -1)) && (y == 0)) {
      clipping_path = "-webkit-clip-path: polygon(0 0, 18% 0, 33% 0, 49% 0, 67% 0, 67% 18%, 82% 33%, 67% 49%, 67% 67%, 49% 67%, 33% 82%, 18% 67%, 0 67%, 0 49%, 15% 33%, 0 18%);clip-path: polygon(0 0, 18% 0, 33% 0, 49% 0, 67% 0, 67% 18%, 82% 33%, 67% 49%, 67% 67%, 49% 67%, 33% 82%, 18% 67%, 0 67%, 0 49%, 15% 33%, 0 18%);";
    }
    else if((x < (matrix_x -1)) && (y < (matrix_y -1))) {
      clipping_path = "-webkit-clip-path: polygon(0 0, 18% 0, 33% 15%, 49% 0, 67% 0, 67% 18%, 82% 33%, 67% 49%, 67% 67%, 49% 67%, 33% 82%, 18% 67%, 0 67%, 0 49%, 15% 33%, 0 18%);clip-path: polygon(0 0, 18% 0, 33% 15%, 49% 0, 67% 0, 67% 18%, 82% 33%, 67% 49%, 67% 67%, 49% 67%, 33% 82%, 18% 67%, 0 67%, 0 49%, 15% 33%, 0 18%);";
    }
    else if((x == (matrix_x -1)) && (y < (matrix_y -1))) {
      clipping_path = "-webkit-clip-path: polygon(0 0, 18% 0, 33% 15%, 49% 0, 67% 0, 67% 18%, 67% 33%, 67% 49%, 67% 67%, 49% 67%, 33% 82%, 18% 67%, 0 67%, 0 49%, 15% 33%, 0 18%);clip-path: polygon(0 0, 18% 0, 33% 15%, 49% 0, 67% 0, 67% 18%, 67% 33%, 67% 49%, 67% 67%, 49% 67%, 33% 82%, 18% 67%, 0 67%, 0 49%, 15% 33%, 0 18%);";
      if((x == (matrix_x -1)) && (y == 0)) {
        clipping_path = "-webkit-clip-path: polygon(0 0, 18% 0, 33% 0, 49% 0, 67% 0, 67% 18%, 67% 33%, 67% 49%, 67% 67%, 49% 67%, 33% 82%, 18% 67%, 0 67%, 0 49%, 15% 33%, 0 18%);clip-path: polygon(0 0, 18% 0, 33% 0, 49% 0, 67% 0, 67% 18%, 67% 33%, 67% 49%, 67% 67%, 49% 67%, 33% 82%, 18% 67%, 0 67%, 0 49%, 15% 33%, 0 18%);";
      }
    }
    else if((x < (matrix_x -1)) && (y == (matrix_y -1))) {
      clipping_path = "-webkit-clip-path: polygon(0 0, 18% 0, 33% 15%, 49% 0, 67% 0, 67% 18%, 82% 33%, 67% 49%, 67% 67%, 49% 67%, 35% 67%, 18% 67%, 0 67%, 0 49%, 15% 33%, 0 18%);clip-path: polygon(0 0, 18% 0, 33% 15%, 49% 0, 67% 0, 67% 18%, 82% 33%, 67% 49%, 67% 67%, 49% 67%, 35% 67%, 18% 67%, 0 67%, 0 49%, 15% 33%, 0 18%);";
      if((x == 0) && (y == (matrix_y -1))) {
        clipping_path = "-webkit-clip-path: polygon(0 0, 18% 0, 33% 15%, 49% 0, 67% 0, 67% 18%, 82% 33%, 67% 49%, 67% 67%, 49% 67%, 35% 67%, 18% 67%, 0 67%, 0 49%, 0 33%, 0 18%);clip-path: polygon(0 0, 18% 0, 33% 15%, 49% 0, 67% 0, 67% 18%, 82% 33%, 67% 49%, 67% 67%, 49% 67%, 35% 67%, 18% 67%, 0 67%, 0 49%, 0 33%, 0 18%);";
      }
    }
    else if((x == (matrix_x -1)) && (y == (matrix_y -1))) {
      clipping_path = "-webkit-clip-path: polygon(0 0, 18% 0, 33% 15%, 49% 0, 67% 0, 67% 28%, 67% 37%, 68% 46%, 67% 67%, 43% 67%, 35% 67%, 27% 67%, 0 67%, 0 49%, 15% 33%, 0 18%);clip-path: polygon(0 0, 18% 0, 33% 15%, 49% 0, 67% 0, 67% 28%, 67% 37%, 68% 46%, 67% 67%, 43% 67%, 35% 67%, 27% 67%, 0 67%, 0 49%, 15% 33%, 0 18%);";

    }

    // randomize the pieaces
    var random_x_coord = Math.floor((Math.random() * 90) + 1);
    var random_y_coord = Math.floor((Math.random() * 400) + 1);

    $(".puzzle_wrapper").append("<div id='pieaces_"+x+y+"' data-number='"+x+y+"' class='canvas_pieces' style='"+clipping_path+" left: "+random_x_coord+"px; top:"+random_y_coord+"px;'><canvas id='c"+x+y+"'></canvas></div>");

    var v = document.getElementById('v');
    var canvas = document.getElementById('c'+x+y);
    var context = canvas.getContext('2d');
    var back = document.createElement('canvas');
    var backcontext = back.getContext('2d');

    var videoHeight = $('#v').height();
    var videoWidth = $('#v').width();
    $('.canvas_pieces').width((videoWidth/matrix_x) * 1.5);
    $('.canvas_pieces').height((videoHeight/matrix_y) * 1.5);

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
      cw = v.clientWidth;
      ch = v.clientHeight;
      canvas.width = (videoWidth/matrix_x) * 1.4;
      canvas.height = (videoHeight/matrix_y) * 1.65;
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
    setTimeout(draw,60,v,c,bc,w,h,x,y,matrix_x, matrix_y);
  }

  // drag individual pieace
  $( ".canvas_pieces" ).draggable({
    containment: '.puzzle_wrapper',
    start: function(e) {
      $('.canvas_pieces').css({'z-index':'998'});
      $(this).css({'z-index':'1000'});
    }
  });

});
