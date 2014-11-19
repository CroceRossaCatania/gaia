$(document).ready( function() {

  // controllo se ho tutte le righe

  var data = {};
  $("[data-riga]").each( function(i, e){
    data[$(e).data('riga')] = false;
  });

  // Selezione blocco ammesso

  $("[data-ammesso]").each( function(i, e){
    $(e).click( function(){
      var id = $(e).data('ammesso');
      if($(e).is(':checked')) {
        $('#riga_' + id).removeClass('error');
        $('#riga_' + id).removeClass('warning');
        $('#opt_non_' + id).hide();
        $('#opt_p1_' + id).fadeIn('slow');
        $('#arg_p1_' + id).fadeIn('slow');
        $('#arg_p2_' + id).fadeIn('slow');
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
        $('#arg_p1_' + id).hide();
        $('#arg_p2_' + id).hide();
        $('#opt_non_' + id).fadeIn('slow');
        data[id] = true;
        if(Object.keys(data).every(function(k){ return data[k]; })){
          $('#pulsantone').show();
        } else {
          $('#pulsantone').hide();
        }
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
        $('#arg_p1_' + id).hide();
        $('#arg_p2_' + id).hide();
        $('#opt_non_' + id).fadeOut('fast');
        data[id] = true;
        if(Object.keys(data).every(function(k){ return data[k]; })){
          $('#pulsantone').show();
        } else {
          $('#pulsantone').hide();
        }
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
          data[id] = true;
          if(Object.keys(data).every(function(k){ return data[k]; })){
            $('#pulsantone').show();
          } else {
           $('#pulsantone').hide();
          }
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
        data[id] = false;
        if(Object.keys(data).every(function(k){ return data[k]; })){
          $('#pulsantone').show();
        } else {
         $('#pulsantone').hide();
        }
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
        $('#arg_p1_' + id).removeClass('error');
        $('#arg_p2_' + id).removeClass('error');
        $('#riga_' + id).addClass('success');
        $('#opt_p1_' + id).addClass('success');
        $('#opt_p2_' + id).addClass('success');
        $('#opt_p3_' + id).addClass('success');
        $('#arg_p1_' + id).addClass('success');
        $('#arg_p2_' + id).addClass('success');
        data[id] = true;
        if(Object.keys(data).every(function(k){ return data[k]; })){
          $('#pulsantone').show();
        } else {
          $('#pulsantone').hide();
        }
      }
      // ...e parte 2 non superata
      if($("#ct1_" + id).is(':checked') && $("#cf2_" + id).is(':checked')) {
        data[id] = true;
        if(Object.keys(data).every(function(k){ return data[k]; })){
          $('#pulsantone').show();
        } else {
          $('#pulsantone').hide();
        }
      }
      // ... e verifica solo su parte 1
      if($("#ct1_" + id).is(':checked') && $("#ex2_" + id).is(':checked')) {
        $('#riga_' + id).removeClass('error');
        $('#opt_p1_' + id).removeClass('error');
        $('#opt_p2_' + id).removeClass('error');
        $('#opt_p3_' + id).removeClass('error');
        $('#arg_p1_' + id).removeClass('error');
        $('#arg_p2_' + id).removeClass('error');
        $('#tdex1_' + id).addClass('muted');
        $('#riga_' + id).addClass('success');
        $('#opt_p1_' + id).addClass('success');
        $('#opt_p2_' + id).addClass('success');
        $('#opt_p3_' + id).addClass('success');
        $('#arg_p1_' + id).addClass('success');
        $('#arg_p2_' + id).addClass('success');
        data[id] = true;
        if(Object.keys(data).every(function(k){ return data[k]; })){
          $('#pulsantone').show();
        } else {
          $('#pulsantone').hide();
        }
      }
    });

    // Parte uno non superata

    $("#cf1_" + id).click( function(){
      if($("#cf1_" + id).is(':checked')){
        $('#riga_' + id).removeClass('success');
        $('#opt_p1_' + id).removeClass('success');
        $('#opt_p2_' + id).removeClass('success');
        $('#opt_p3_' + id).removeClass('success');
        $('#arg_p1_' + id).removeClass('success');
        $('#arg_p2_' + id).removeClass('success');
        $('#riga_' + id).addClass('error');
        $('#opt_p1_' + id).addClass('error');
        $('#opt_p2_' + id).addClass('error');
        $('#opt_p3_' + id).addClass('error');
        $('#arg_p1_' + id).addClass('error');
        $('#arg_p2_' + id).addClass('error');
      }
      if($("#cf1_" + id).is(':checked') && ($("#ct2_" + id).is(':checked') || $("#cf2_" + id).is(':checked'))){
        data[id] = true;
        if(Object.keys(data).every(function(k){ return data[k]; })){
          $('#pulsantone').show();
        } else {
          $('#pulsantone').hide();
        }
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
        $('#arg_p1_' + id).removeClass('error');
        $('#arg_p2_' + id).removeClass('error');
        $('#riga_' + id).addClass('success');
        $('#opt_p1_' + id).addClass('success');
        $('#opt_p2_' + id).addClass('success');
        $('#opt_p3_' + id).addClass('success');
        $('#arg_p1_' + id).addClass('success');
        $('#arg_p2_' + id).addClass('success');
        data[id] = true;
        if(Object.keys(data).every(function(k){ return data[k]; })){
          $('#pulsantone').show();
        } else {
          $('#pulsantone').hide();
        }
      }
      if(($("#ct1_" + id).is(':checked') || $("#cf1_" + id).is(':checked')) && $("#ct2_" + id).is(':checked')) {
        data[id] = true;
        if(Object.keys(data).every(function(k){ return data[k]; })){
          $('#pulsantone').show();
        } else {
          $('#pulsantone').hide();
        }
      }
    });

    // Parte 2 non superata

    $("#cf2_" + id).click( function(){
      if($("#cf2_" + id).is(':checked')){
        $('#riga_' + id).removeClass('success');
        $('#opt_p1_' + id).removeClass('success');
        $('#opt_p2_' + id).removeClass('success');
        $('#opt_p3_' + id).removeClass('success');
        $('#arg_p1_' + id).removeClass('success');
        $('#arg_p2_' + id).removeClass('success');
        $('#riga_' + id).addClass('error');
        $('#opt_p1_' + id).addClass('error');
        $('#opt_p2_' + id).addClass('error');
        $('#opt_p3_' + id).addClass('error');
        $('#arg_p1_' + id).addClass('error');
        $('#arg_p2_' + id).addClass('error');
      }
      if(($("#ct1_" + id).is(':checked') || $("#cf1_" + id).is(':checked')) && $("#cf2_" + id).is(':checked')){
        data[id] = true;
        if(Object.keys(data).every(function(k){ return data[k]; })){
          $('#pulsantone').show();
        } else {
          $('#pulsantone').hide();
        }
      }
    });
  });

  $('#pulsantone').click(function(){
    $(this).fadeOut('slow');
    $('#messaggio').fadeIn('slow');
    $('#salva').fadeIn('slow');
    $('#annulla').fadeIn('slow');
    $('#annulla').addClass('bottone-lungo');
    $('input[type=text]').prop('disabled', true);
    $('input[type=radio]').prop('disabled', true);
    $('input[type=checkbox]').prop('disabled', true);
  });
  $('#verbale').submit(function(){
    $('input[type=text]').prop('disabled', false);
    $('input[type=radio]').prop('disabled', false);
    $('input[type=checkbox]').prop('disabled', false);
  });
});
