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

  $(document).on('change keyup', '.switch_checkbox, .uploaded_file_title, .uploaded_file_description, .uploaded_file_tag', function() {
    var file_id = $(this).data('file-id');
    $(".submit_file_changes_btn[data-file-id='"+file_id+"']").addClass('bg_lightblue');
    $(".submit_file_changes_btn[data-file-id='"+file_id+"']").text('SAVE');
  });

  $(document).on('change', '.switch_checkbox', function() {
    var file_id = $(this).data('file-id');
    if($(this).prop('checked') == true) {
      $(".switch_title[data-file-id='"+file_id+"']").text('Public');
    }
    else if($(this).prop('checked') == false) {
      $(".switch_title[data-file-id='"+file_id+"']").text('Private');
    }
  });

  $(document).on('click', '.submit_file_changes_btn', function() {


    var this_button = $(this);
    var file_id = $(this).data('file-id');
    var update_url = $(this).data('update-url');
    var file_title = $(".uploaded_file_title[data-file-id='"+file_id+"']").val();

    var file_is_public = 1;
    if($(".switch_checkbox[data-file-id='"+file_id+"']").prop('checked') == true) {
      file_is_public = 1;
    }
    else if($(".switch_checkbox[data-file-id='"+file_id+"']").prop('checked') == false) {
      file_is_public = 0;
    }

    var file_description = $(".uploaded_file_description[data-file-id='"+file_id+"']").val();

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
    });

    $.ajax({
      type: 'POST',
      url: update_url,
      data: {
        "file_id" : file_id ,
        "title" : file_title ,
        "is_public" : file_is_public ,
        "description" : file_description
      },
      success: function(response){
        this_button.removeClass('bg_lightblue');
        this_button.text('SAVED');
      }
    });
  });

  $('.redirect_to_page').click(function() {
    var url = $(this).data('redirect-url');
    window.location.href = url;
  });

  $('.bulk_action_trigger').click(function() {
    $('.bulk_action_group').show();
    $(this).hide();
    $('.bulk_action_checkbox_container').fadeIn();
    $('.bulk_action_checkbox_container').siblings('.user_thumbnail').fadeOut();
    $('.bulk_action_checkbox_container').siblings('.play_button').fadeOut();
  });

  $('.cancel_bulk_action').click(function() {
    var bulk_id = $(this).data('bulk-action-id');

    $('.bulk_action_group').hide();
    $('.bulk_action_trigger').fadeIn();
    $('.bulk_action_checkbox_container').hide();
    $('.bulk_action_checkbox_container').siblings('.user_thumbnail').fadeIn();
    $('.bulk_action_checkbox_container').siblings('.play_button').fadeIn();
  });

  $('.bulk_action_checkbox').on('change', function() {
    if($(this).prop('checked') == true) {
      $(this).siblings('.tick_symbol').show().css({'display':'flex'});
    }
    else if ($(this).prop('checked') == false) {
      $(this).siblings('.tick_symbol').hide();
    }
  });

  $('.submit_bulk_action').click(function(e) {

    if($(".bulk_action_checkbox:checked").length == 0) {
      alert('No item selected, please select at least 1 item.');
      e.preventDefault();
    }

    if ($('.bulk_action_select').val() == '') {
      alert('No action is selected, please select an action.');
      e.preventDefault();
    }
  });

  $('.profile_img').hover(
    function () {
      $('.edit_profile_image').css({'opacity':'0.5'});
      $('.upload_profile_btn').fadeIn();
    },
    function () {
      $('.edit_profile_image').css({'opacity':'1'});
      $('.upload_profile_btn').fadeOut();
    }
  );

  $('.edit_profile_btn').click(function() {
    $('.edit_user_detail_lightbox').fadeIn().css({'display':'flex'});
  });

  $('.special_close').on('click', function(event) {
    if ($(event.target).has('.not_to_close').length) {
      $(".lightbox").fadeOut();
    }
  });

  $('.update_user_detail_submit_btn').click(function(e) {
    var bday = $('.user_detail_birthday').val();
    var surname = $('.user_detail_surname').val();
    var givenname = $('.user_detail_givenname').val();
    var gender = $('.user_detail_gender select').val();
    var error = 0;
    $('.ui.form').addClass('loading');

    if (bday == '') { $('.user_detail_birthday').parent('.field').addClass('error'); error+=1;} else if (bday != '') { $('.user_detail_birthday').parent('.field').removeClass('error');}
    if (surname == '') { $('.user_detail_surname').parent('.field').addClass('error'); error+=1;} else if (surname != '') { $('.user_detail_surname').parent('.field').removeClass('error');}
    if (givenname == '') { $('.user_detail_givenname').parent('.field').addClass('error'); error+=1;} else if (givenname != '') { $('.user_detail_givenname').parent('.field').removeClass('error');}
    if (gender == '') { $('.user_detail_gender').parent('.field').addClass('error'); error+=1;} else if (gender != '') { $('.user_detail_gender').parent('.field').removeClass('error');}

    if (error > 0) {
      alert('Please fill in the form correctly.');
      $('.ui.form').removeClass('loading');
      e.preventDefault();
    }

  });

  $('.preview_trigger_btn').click(function() {
    $('.video_preview_wrapper').fadeIn();
  });


});
