
$("form").each ( function( i, e ) {
    $(e).submit( function () {
        var vuoti = 0;
        $(e).find('[required]').each(function(i,x){
            if ( $(x).val().length < 1 || $(x).val() == $(x).attr('placeholder') ) {
                vuoti += 1;
                $(x).hide().show('highlight', 5000);
                $(x).focus();
            }
        });
        if ( vuoti == 0 ) {
            return true;
        } else {
            alert('Campo obbligatorio!');
            return false;
        }
    });
});