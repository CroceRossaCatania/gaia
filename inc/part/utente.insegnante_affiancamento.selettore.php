<script type="text/javascript">

var s_multi = false;
var s_autosubmit = false;
var selezioneIA = [];
var dataInput = '';
var origElem = '';
var geoPolitica = '';
var stato = '';

    $(document).ready( function() {
        $("[data-selettore-insegnante-affiancamento]").each( function( i, e ) {
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
                
                $("#selettoreInsegnanteAffiancamento").modal('show');
                
                setTimeout( function() {
                 $("#selettoreInsegnanteAffiancamentoCerca").val('').focus();
                }, 800);
            
            });
        });
        
        $("#selettoreInsegnanteAffiancamentoCerca").keyup(keyupRicercaInsegnanteAffiancamento);
        
        $("#selettoreInsegnanteAffiancamentoSalva").click( function() {
            // Rimuove già esistenti.
            $('[data-generato-insegnante-affiancamento]').remove();
            $("#selettoreInsegnanteAffiancamento").modal('hide');

            if ( s_multi ){
                for (var i in selezioneIA) {
                    var stringa = '';
                    stringa += '<input data-generato-insegnante-affiancamento="true" type="hidden" ';
                    stringa += 'name="' + dataInput + '[]" ';
                    stringa += 'value="' + selezioneIA[i] +'" />';
                    $(stringa).insertAfter($(origElem));
                }
                $(origElem).html(selezioneIA.length + ' insegnanti selez. <i class="icon-pencil"></i>');
            } else {
                var ilNome;
                if ( selezioneIA.length == 0 ) { 
                    ilNome = '(Nessun insegnante in affiancamento)';
                } else {
                    var stringa = '';
                    stringa += '<input data-generato-insegnante-affiancamento="true" type="hidden" ';
                    stringa += 'name="' + dataInput + '" ';
                    stringa += 'value="' + selezioneIA[0] +'" />';
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
function keyupRicercaInsegnanteAffiancamento() {
    window.clearTimeout(_ultimaRicerca);
    $(".icona-ricerca").removeClass().addClass("icon-time");
    var query = $("#selettoreInsegnanteAffiancamentoCerca").val();
    if ( query.length < 1 ) { $("#selettoreInsegnanteAffiancamentoRisultati").html(''); return; }
    _ultimaRicerca = setTimeout( function() {
    $(".icona-ricerca").removeClass().addClass("icon-spin").addClass("icon-spinner");
    api('insegnanti_in_affiancamento:cerca', {query: query, perPagina: 80, ordine: 'selettoreInsegnanteAffiancamento', comitati: geoPolitica, stato: stato}, function( x ) {
        if ( $("#selettoreInsegnanteAffiancamentoCerca").val() != x.richiesta.parametri.query ) {
          return false;
        }
          
         $("#selettoreInsegnanteAffiancamentoRisultati").html('');
         if ( x.risposta.length < 1 ) {
             $("#selettoreInsegnanteAffiancamentoRisultati").html('<span class="text-warning"><i class="icon-warning-sign"></i> Nessun insegnante trovato.</span>');
         }
         for ( var i in x.risposta.risultati ) {
             var stringa = '';
             stringa += "<div data-id='" + x.risposta.risultati[i].id + "' data-nome='" + x.risposta.risultati[i].nome + "' class='collaMano'>";
             stringa += "<i class='icon-plus'></i> <span class='grassetto'>" + x.risposta.risultati[i].nome + " " + x.risposta.risultati[i].cognome + "</span> (";
             stringa += "<span class='muted'>" + x.risposta.risultati[i].comitato.nome + "</span>)</div>";
             
             $(stringa).appendTo("#selettoreInsegnanteAffiancamentoRisultati").click(function() {
                 var _id, _nome;
                 _id = $(this).data('id');
                 _nome = $(this).data('nome');
                 if (jQuery.inArray(_id, selezioneIA) != -1 ) { return; } // Gia presente
                 
                 if ( !s_multi && selezioneIA.length == 1 ) {
                     alert('Non puoi scegliere più di un insegnante in affiancamento.');
                     return;
                 }
                 
                 selezioneIA.push(_id);
                 
                 $("#nvs-ia").hide();
                 $("#uvs-ia").show();
                 
                  var stringa = '';
                  stringa += "<div data-id='" + _id + "' data-sel='true' data-nome='" + _nome + "' class='collaMano ctr'>";
                  stringa += "<i class='icon-remove'></i> <span class='grassetto'>" + _nome + "</span>";
                  stringa += "</div>";
             
                 $(stringa).appendTo("#selettoreInsegnanteAffiancamentoSelezione").click( function() {
                     selezioneIA.splice( $.inArray(_id, selezioneIA), 1 ); // Rimuove
                     $(this).remove();
                     if ( selezioneIA.length == 0 ) {
                         $("#nvs-ia").show();
                         $("#uvs-ia").hide();
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
    
<div id="selettoreInsegnanteAffiancamento" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="selettoreInsegnanteAffiancamento" aria-hidden="true">
  <div class="modal-header">
    <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>-->
    <h3><i class="icon-user"></i> Selezione degli insegnanti in affiancamento</h3>
  </div>
  <div class="modal-body">
      <div class="row-fluid">
          <div class="span6">
              <h4>Ricerca insegnanti in affiancamento</h4>
             
              <div class="input-prepend">
                  <span class="add-on">
                      <i class="icon-search icona-ricerca"></i>
                  </span>
                  <input class="span9 allinea-centro" id="selettoreInsegnanteAffiancamentoCerca" placeholder="Cerca per nome, cognome..." />
              </div>
                  
              <hr />
              
              <div id="selettoreInsegnanteAffiancamentoRisultati">
                  <i>Cerca nome o parte del nome.</i>
              </div>
          </div>
          <div class="span6">
              
              <h4 class="s_multi">Insegnanti in affiancamento selezionati</h4>
              <h4 class="s_sing">Insegnante in affiancamento selezionato</h4>
              
              <div id="selettoreInsegnanteAffiancamentoSelezione">
                  <span id="nvs-ia"><i class="icon-warning-sign"></i> Nessun insegnante in affiancamento selezionato.</span>
              </div>
          <hr />
              <p id="uvs-ia" class="text-warning nascosto">
                  
                  <i class="icon-info-sign"></i> Per rimuovere un insegnante in affiancamento, clicca sul nome.
              </p>
              
          </div>
      </div>
  </div>
  <div class="modal-footer">
      <div class="btn-group">
        <button class="btn btn-large" data-dismiss="modal" aria-hidden="true">Annulla</button>
        <button id="selettoreInsegnanteAffiancamentoSalva" class="btn btn-large btn-primary"><i class="icon-save"></i> Salva</button>
      </div>
  </div>
</div>
