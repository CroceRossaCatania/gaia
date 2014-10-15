$(document).ready( function() {
  $("#emesso").change( function(){
    $("#motivo").fadeOut('slow');
    $("#inputMotivo").val('');
  });
  $("#non").change( function(){
    $("#motivo").fadeIn('slow');
  });
});
