$(document).ready( function() {
    $("#caricaFoto").submit( function() {
        $("#caricaFoto").find('button').html('<i class="icon-spin icon-spinner"></i> Attendere...').attr('disabled', 'disabled');
    });
});