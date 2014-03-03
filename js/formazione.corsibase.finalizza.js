$(document).ready( function() {
  $("[data-ammesso]").each( function(i, e){
    $(e).click( function(){
      var id = $(e).data('ammesso');
      if($(e).is(':checked')) {
        $('#riga_' + id).removeClass('error');
        $('#riga_' + id).removeClass('warning');
        $('#opt_non_' + id).hide();
        $('#opt_p1_' + id).fadeIn('slow');
        $('#opt_p2_' + id).fadeIn('slow');
        $('#opt_p3_' + id).fadeIn('slow');
        }
    });
  });

  $("[data-non]").each( function(i, e){
    $(e).click( function(){
      var id = $(e).data('non');
      if($(e).is(':checked')) {
        $('#riga_' + id).removeClass('success');
        $('#riga_' + id).removeClass('warning');
        $('#riga_' + id).addClass('error');
        $('#opt_p1_' + id).hide();
        $('#opt_p2_' + id).hide();
        $('#opt_p3_' + id).hide();
        $('#opt_non_' + id).fadeIn('slow');
        }
    });
  });

  $("[data-assente]").each( function(i, e){
    $(e).click( function(){
      var id = $(e).data('assente');
      if($(e).is(':checked')) {
        $('#riga_' + id).removeClass('success');
        $('#riga_' + id).removeClass('error');
        $('#riga_' + id).addClass('warning');
        $('#opt_p1_' + id).hide();
        $('#opt_p2_' + id).hide();
        $('#opt_p3_' + id).hide();
        $('#opt_non_' + id).fadeOut('fast');
        }
    });
  });
  $("[data-extra2]").each( function(i, e){
    $(e).click( function(){
      var id = $(e).data('extra2');
      if($(e).is(':checked')) {
        $('.p2_' + id).attr('disabled', 'disabled');
        $('.p2_' + id).removeAttr('checked');
        $('#opt_p2_' + id).addClass('muted');
      } else {
        $('.p2_' + id).removeAttr('disabled');
        $('#opt_p2_' + id).removeClass('muted');
      }
    });
  });       
});
