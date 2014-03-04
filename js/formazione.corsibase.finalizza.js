$(document).ready( function() {

  // Selezione blocco ammesso

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

  // Selezione blocco non ammesso

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

  // Selezione blocco assente

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

// Se verifica solo su parte 1 disabilita blocco parte 2

  $("[data-extra2]").each( function(i, e){
    $(e).click( function(){
      var id = $(e).data('extra2');
      if($(e).is(':checked')) {
        $('.p2_' + id).attr('disabled', 'disabled');
        $('.p2_' + id).removeAttr('checked');
        $('#opt_p2_' + id).addClass('muted');
        $('#tdex1_' + id).addClass('muted');
        $('#extra_1_' + id).attr('disabled', true);
        $('#extra_1_' + id).attr('checked', false);
        // se hai anche superato parte 1
        if($("#ct1_" + id).is(':checked')) {
          $('#riga_' + id).removeClass('error');
          $('#opt_p1_' + id).removeClass('error');
          $('#opt_p2_' + id).removeClass('error');
          $('#opt_p3_' + id).removeClass('error');
          $('#tdex1_' + id).addClass('muted');
          $('#extra_1_' + id).attr('disabled', true);
          $('#extra_1_' + id).attr('checked', false);
          $('#riga_' + id).addClass('success');
          $('#opt_p1_' + id).addClass('success');
          $('#opt_p2_' + id).addClass('success');
          $('#opt_p3_' + id).addClass('success');
        }
      } else {
        $('.p2_' + id).removeAttr('disabled');
        $('#opt_p2_' + id).removeClass('muted');
        $('#riga_' + id).removeClass('success');
        $('#opt_p1_' + id).removeClass('success');
        $('#opt_p2_' + id).removeClass('success');
        $('#opt_p3_' + id).removeClass('success');
        $('#tdex1_' + id).removeClass('muted');
        $('#extra_1_' + id).removeAttr('disabled');
      }
    });
  });

  // Se passato colora di verde altrimenti di rosso

  $("[data-ammesso]").each( function(i, e){
    var id = $(e).data('ammesso');

    // Superata parte 1...

    $("#ct1_" + id).click( function(){
      // ...e parte 2
      if($("#ct1_" + id).is(':checked') && $("#ct2_" + id).is(':checked')) {
        $('#riga_' + id).removeClass('error');
        $('#opt_p1_' + id).removeClass('error');
        $('#opt_p2_' + id).removeClass('error');
        $('#opt_p3_' + id).removeClass('error');
        $('#riga_' + id).addClass('success');
        $('#opt_p1_' + id).addClass('success');
        $('#opt_p2_' + id).addClass('success');
        $('#opt_p3_' + id).addClass('success');
      }
      // ... e verifica solo su parte 1
      if($("#ct1_" + id).is(':checked') && $("#ex2_" + id).is(':checked')) {
        $('#riga_' + id).removeClass('error');
        $('#opt_p1_' + id).removeClass('error');
        $('#opt_p2_' + id).removeClass('error');
        $('#opt_p3_' + id).removeClass('error');
        $('#tdex1_' + id).addClass('muted');
        $('#riga_' + id).addClass('success');
        $('#opt_p1_' + id).addClass('success');
        $('#opt_p2_' + id).addClass('success');
        $('#opt_p3_' + id).addClass('success');
      }
    });

    // Parte uno non superata

    $("#cf1_" + id).click( function(){
      if($("#cf1_" + id).is(':checked')){
        $('#riga_' + id).removeClass('success');
        $('#opt_p1_' + id).removeClass('success');
        $('#opt_p2_' + id).removeClass('success');
        $('#opt_p3_' + id).removeClass('success');
        $('#riga_' + id).addClass('error');
        $('#opt_p1_' + id).addClass('error');
        $('#opt_p2_' + id).addClass('error');
        $('#opt_p3_' + id).addClass('error');
      }
    });

    // Superata parte 2...

    $("#ct2_" + id).click( function(){
      // ...e parte 1
      if($("#ct1_" + id).is(':checked') && $("#ct2_" + id).is(':checked')) {
        $('#riga_' + id).removeClass('error');
        $('#opt_p1_' + id).removeClass('error');
        $('#opt_p2_' + id).removeClass('error');
        $('#opt_p3_' + id).removeClass('error');
        $('#riga_' + id).addClass('success');
        $('#opt_p1_' + id).addClass('success');
        $('#opt_p2_' + id).addClass('success');
        $('#opt_p3_' + id).addClass('success');
      }
    });

    // Parte 2 non superata

    $("#cf2_" + id).click( function(){
      if($("#cf2_" + id).is(':checked')){
        $('#riga_' + id).removeClass('success');
        $('#opt_p1_' + id).removeClass('success');
        $('#opt_p2_' + id).removeClass('success');
        $('#opt_p3_' + id).removeClass('success');
        $('#riga_' + id).addClass('error');
        $('#opt_p1_' + id).addClass('error');
        $('#opt_p2_' + id).addClass('error');
        $('#opt_p3_' + id).addClass('error');
      }
    });
  });       
});
