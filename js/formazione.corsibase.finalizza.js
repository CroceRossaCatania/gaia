$(document).ready( function() {
  /*
  $('[id^=ammesso_]').click(function(id){
        console.log(id);
        if(this.checked) {
            $('[id^=opt_non_]').hide();
            $('[id^=opt_ammesso_]').fadeIn('slow');
        }
  });
*/
  $('[id^=ammesso_]').each(function(id){
        console.log(id);
        $('[id^=ammesso_]' + id).click(function(){
          console.log(id);
          if(this.checked) {
              $('[id^=opt_ammesso_]' + id).fadeIn('slow');
              $('[id^=opt_non_]' + id).fadeOut('slow');
          }
        });
  });

  $('#non_1').click(function(){
        if(this.checked) {
            $('#opt_ammesso_1').hide();
            $('#opt_non_1').fadeIn('slow');
        }
  });
  $('#assente_1').click(function(){
        if(this.checked) {
            $('#opt_ammesso_1').fadeOut('slow');
            $('#opt_non_1').fadeOut('slow');
        }
  });            
});