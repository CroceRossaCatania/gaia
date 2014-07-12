$(document).ready( function() {
  $('#motivo').on('change', function() {
    var v = $( "#motivo option:selected" ).val();
    if(v != 10) {
      $('#blocco').addClass('nascosto');
      $('#ordinario').prop('checked', false);
    } else {
      $('#blocco').removeClass('nascosto');
    }
  });
});
