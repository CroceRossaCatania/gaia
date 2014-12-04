$(document).ready( function() {
   $('.modDocumento').submit( function() {
      $(this).find('button').addClass('disabled').attr('disabled', 'disabled').html('<i class="icon-spinner icon-spin"></i> Attendere...');
    });
});