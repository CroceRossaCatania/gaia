<script type="text/javascript">

var s_multi = false;
var s_autosubmit = false;
var selezione = [];
var dataInput = '';
var origElem = '';
var geoPolitica = '';
var stato = '';

    $(document).ready( function() {
        $("[data-selettore-istruttore]").each( function( i, e ) {
            if ( typeof $(e).data('comitati') == 'undefined') {
              geoPolitica = false;
            } else {
              geoPolitica = $(e).data('comitati');
            } 

            if ( typeof $(e).data('stato') == 'undefined') {
              stato = false;
            } else {
              stato = $(e).data('stato');
              if ( typeof stato === 'string' ) {
                stato = stato.split(",");
              }
            } 

            $(e).click( function() {
                
                s_multi = false;
                if ( $(e).data('multi') ) {
                    s_multi = true;
                    $(".s_multi").show();
                    $(".s_sing").hide();
                } else {
                    $(".s_multi").hide();
                    $(".s_sing").show();
                }
                if ( $(e).data('autosubmit') ) {
                    s_autosubmit = true;
                }
                
                dataInput = $(e).data('input');
                origElem = $(e);
                
                $("#selettoreIstruttore").modal('show');
                
                setTimeout( function() {
                 $("#selettoreIstruttoreCerca").val('').focus();
                }, 800);
            
            });
        });
        
        $("#selettoreIstruttoreCerca").keyup(keyupRicercaIstruttore);
        
        $("#selettoreIstruttoreSalva").click( function() {
            // Rimuove già esistenti.
            $('[data-generato]').remove();
            $("#selettoreIstruttore").modal('hide');

            if ( s_multi ){
                for (var i in selezione) {
                    var stringa = '';
                    stringa += '<input data-generato="true" type="hidden" ';
                    stringa += 'name="' + dataInput + '[]" ';
                    stringa += 'value="' + selezione[i] +'" />';
                    $(stringa).insertAfter($(origElem));
                }
                $(origElem).html(selezione.length + ' istruttori selez. <i class="icon-pencil"></i>');
            } else {
                var ilNome;
                if ( selezione.length == 0 ) { 
                    ilNome = '(Nessun istruttore)';
                } else {
                    var stringa = '';
                    stringa += '<input data-generato="true" type="hidden" ';
                    stringa += 'name="' + dataInput + '" ';
                    stringa += 'value="' + selezione[0] +'" />';
                    $(stringa).insertAfter($(origElem));
                    var ilNome = $("[data-sel]").data('nome');
                }
                $(origElem).html(ilNome + ' <i class="icon-pencil"></i>');
            }
            if ( s_autosubmit ) {
                $(origElem).parents('form').submit();
            }
        });
    });

var _ultimaRicerca = null;
function keyupRicercaIstruttore() {
    window.clearTimeout(_ultimaRicerca);
    $(".icona-ricerca").removeClass().addClass("icon-time");
    var query = $("#selettoreIstruttoreCerca").val();
    if ( query.length < 1 ) { $("#selettoreIstruttoreRisultati").html(''); return; }
    _ultimaRicerca = setTimeout( function() {
    $(".icona-ricerca").removeClass().addClass("icon-spin").addClass("icon-spinner");
    api('istruttori:cerca', {query: query, perPagina: 80, ordine: 'selettoreIstruttore', comitati: geoPolitica, stato: stato}, function( x ) {
        if ( $("#selettoreIstruttoreCerca").val() != x.richiesta.parametri.query ) {
          return false;
        }
          
         $("#selettoreIstruttoreRisultati").html('');
         if ( x.risposta.length < 1 ) {
             $("#selettoreIstruttoreRisultati").html('<span class="text-warning"><i class="icon-warning-sign"></i> Nessun istruttore trovato.</span>');
         }
         for ( var i in x.risposta.risultati ) {
             var stringa = '';
             stringa += "<div data-id='" + x.risposta.risultati[i].id + "' data-nome='" + x.risposta.risultati[i].nome + "' class='collaMano'>";
             stringa += "<i class='icon-plus'></i> <span class='grassetto'>" + x.risposta.risultati[i].nome + " " + x.risposta.risultati[i].cognome + "</span> (";
             stringa += "<span class='muted'>" + x.risposta.risultati[i].comitato.nome + "</span>)</div>";
             
             $(stringa).appendTo("#selettoreIstruttoreRisultati").click(function() {
                 var _id, _nome;
                 _id = $(this).data('id');
                 _nome = $(this).data('nome');
                 if (jQuery.inArray(_id, selezione) != -1 ) { return; } // Gia presente
                 
                 if ( !s_multi && selezione.length == 1 ) {
                     alert('Non puoi scegliere più di un istruttore.');
                     return;
                 }
                 
                 selezione.push(_id);
                 
                 $("#nvs").hide();
                 $("#uvs").show();
                 
                  var stringa = '';
                  stringa += "<div data-id='" + _id + "' data-sel='true' data-nome='" + _nome + "' class='collaMano ctr'>";
                  stringa += "<i class='icon-remove'></i> <span class='grassetto'>" + _nome + "</span>";
                  stringa += "</div>";
             
                 $(stringa).appendTo("#selettoreIstruttoreSelezione").click( function() {
                     selezione.splice( $.inArray(_id, selezione), 1 ); // Rimuove
                     $(this).remove();
                     if ( selezione.length == 0 ) {
                         $("#nvs").show();
                         $("#uvs").hide();
                     }
                 });
                 
                 
             });
         }

         $(".icona-ricerca").removeClass().addClass("icon-search");
         return true;

      });

  // setTimeout
  }, 600);

}
</script>
    
<div id="selettoreIstruttore" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="selettoreIstruttore" aria-hidden="true">
  <div class="modal-header">
    <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>-->
    <h3><i class="icon-user"></i> Selezione degli istruttori</h3>
  </div>
  <div class="modal-body">
      <div class="row-fluid">
          <div class="span6">
              <h4>Ricerca istruttori</h4>
             
              <div class="input-prepend">
                  <span class="add-on">
                      <i class="icon-search icona-ricerca"></i>
                  </span>
                  <input class="span9 allinea-centro" id="selettoreIstruttoreCerca" placeholder="Cerca per nome, cognome..." />
              </div>
                  
              <hr />
              
              <div id="selettoreIstruttoreRisultati">
                  <i>Cerca nome o parte del nome.</i>
              </div>
          </div>
          <div class="span6">
              
              <h4 class="s_multi">Istruttori selezionati</h4>
              <h4 class="s_sing">Istruttore selezionato</h4>
              
              <div id="selettoreIstruttoreSelezione">
                  <span id="nvs"><i class="icon-warning-sign"></i> Nessun istruttore selezionato.</span>
              </div>
          <hr />
              <p id="uvs" class="text-warning nascosto">
                  
                  <i class="icon-info-sign"></i> Per rimuovere un istruttore, clicca sul nome.
              </p>
              
          </div>
      </div>
  </div>
  <div class="modal-footer">
      <div class="btn-group">
        <button class="btn btn-large" data-dismiss="modal" aria-hidden="true">Annulla</button>
        <button id="selettoreIstruttoreSalva" class="btn btn-large btn-primary"><i class="icon-save"></i> Salva</button>
      </div>
  </div>
</div>
