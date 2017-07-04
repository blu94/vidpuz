$(document).ready(function() {
  var version = $('meta[name=version]').attr("content");
  var style_wide = $('meta[name=wide_style]').attr("content");
  var style_medium = $('meta[name=medium_style]').attr("content");
  var style_small = $('meta[name=small_style]').attr("content");

  function adjustStyle(width) {
    width = parseInt(width);
    if (width < 701) {
      $("#responsive_stylesheet").attr("href", style_small+"?v="+version);
    } else if (width < 1100) {
      $("#responsive_stylesheet").attr("href", style_medium+"?v="+version);
    } else {
      $("#responsive_stylesheet").attr("href", style_wide+"?v="+version);
    }
  }


 // responsive
  $(function() {
      adjustStyle(screen.width);
      $(window).resize(function() {
        adjustStyle(screen.width);
      });
  });

  $('.sidebar_trigger').click(function() {
    $('.sidebar').toggleClass('sidebar_triggered');

  });
});
