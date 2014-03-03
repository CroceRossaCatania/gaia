$(document).ready( function() {
  $("[data-ammesso]").each( function(i, e){
    $(e).click( function(){
      var id = $(e).data('ammesso');
      if($(e).is(':checked')) {
        $('#opt_non_' + id).fadeOut('fast');
        $('#opt_ammesso_' + id).fadeIn('slow');
        }
    });
  });

  $("[data-non]").each( function(i, e){
    $(e).click( function(){
      var id = $(e).data('non');
      if($(e).is(':checked')) {
        $('#opt_ammesso_' + id).fadeOut('fast');
        $('#opt_non_' + id).fadeIn('slow');
        }
    });
  });

  $("[data-assente]").each( function(i, e){
    $(e).click( function(){
      var id = $(e).data('assente');
      if($(e).is(':checked')) {
        $('#opt_ammesso_' + id).fadeOut('fast');
        $('#opt_non_' + id).fadeOut('fast');
        }
    });
  });       
});
