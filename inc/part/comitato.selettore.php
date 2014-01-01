<script type="text/javascript">

var comitati = {};
var albero   = {};

$(document).ready( function() {

    /* Scarico elenco comitati... */
    api('comitati', {}, function( x ) {
       comitati = x.response[0];
       _carica_regionali();
    });
    
    $("#_sel_regionale")        .change( _carica_provinciali );
    $("#_sel_provinciale")      .change( _carica_locali );
    $("#_sel_locale")           .change( _seleziona_unita );
    
});

var c_autosubmit = false;

var selezione_comitato = null;
var superiore_comitato = null;
var c_dataInput = '';
var c_origElem = '';

var nomePerOID = {};

function _carica_regionali() {
    $("#_sel_regionale").html('<option disabled selected="selected">- Seleziona regione...</option>');
    $.each(comitati.regionali, function (i, v) {
        $("#_sel_regionale").append("<option value='" + i + "'>" + v.nome + "</option>");
    });
}

function _carica_provinciali() {
    $("#_sel_provinciale").html('<option disabled selected="selected">- Seleziona provincia...</option>');
    var regione = $("#_sel_regionale").val();
    $.each(comitati.regionali[regione].provinciali, function (i, v) {
        $("#_sel_provinciale").append("<option value='" + i + "'>" + v.nome + "</option>");
    });
}

function _carica_locali() {
    $("#_sel_locale").html('<option disabled selected="selected">- Seleziona comitato...</option>');
    var regione = $("#_sel_regionale").val();
    var provincia = $("#_sel_provinciale").val();
    $.each(comitati.regionali[regione].provinciali[provincia].comitati, function (i, v) {
        $("#_sel_locale").append("<option value='" + v.oid + "'>" + v.nome + "</option>");
        nomePerOID[v.oid] = {'nome': v.nome, 'oid': v.oid};
        $.each(
            v.unita,
            function(y, h) {
                $("#_sel_locale").append("<option value='" + h.oid + "'>- " + h.nome + "</option>");
                nomePerOID[h.oid] = {'nome': h.nome, 'oid': h.oid};
            }
        );

    });
}

function _seleziona_unita() {
    var regione     = $("#_sel_regionale").val();
    var provincia   = $("#_sel_provinciale").val();
    var comitato    = $("#_sel_locale").val();

    selezione_comitato = nomePerOID[comitato];
    superiore_comitato = comitati.regionali[regione].provinciali[provincia];
    
    /* Attiva il pulsante... */
    $("#selettoreSalvaComitato").removeAttr('disabled').removeClass('disabled');
}

    $(document).ready( function() {
        $("[data-selettore-comitato]").each( function( i, e ) {
            $(e).click( function() {
                

                if ( $(e).data('autosubmit') ) {
                    c_autosubmit = true;
                }
                
                c_dataInput = $(e).data('input');
                c_origElem = $(e);
                
                $("#selettoreComitato").modal('show');
                
                setTimeout( function() {
                 $("#_sel_regionale").focus();
                }, 800);
                            
            });
        });
        
        $("#selettoreSalvaComitato").click( function() {
            $('[data-generato-comitato]').remove();
            $("#selettoreComitato").modal('hide');

            var stringa = '';
            stringa += '<input data-generato-comitato="true" type="hidden" ';
            stringa += 'name="' + c_dataInput + '" ';
            stringa += 'value="' + selezione_comitato.oid +'" />';
            $(stringa).insertAfter($(c_origElem));
                        
            $(c_origElem).html(selezione_comitato.nome + " (" + superiore_comitato.nome +') <i class="icon-pencil"></i>');

            if ( c_autosubmit ) {
                $(c_origElem).parents('form').submit();
            }
        });
    });
</script>
    
<div id="selettoreComitato" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="selettoreComitato" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3><i class="icon-user"></i> Selezione del Comitato</h3>
  </div>
  <div class="modal-body">
      <div class="row-fluid">          
          <table class="table table-bordered table-striped table-condensed">
              
              <tr>
                  <td class="allinea-destra">Regionale</td>
                  <td>
                      <select class="span12" id="_sel_regionale">
                          <option value="" selected="selected" disabled>ATTENDERE: Scaricamento elenco...</option>
                      </select>
                  </td>
              </tr>
              
              <tr>
                  <td class="allinea-destra">Provinciale</td>
                  <td>
                      <select class="span12" id="_sel_provinciale">
                      </select>
                  </td>
              </tr>              
              <tr>
                  <td class="allinea-destra">Unit&agrave;</td>
                  <td>
                      <select class="span12" id="_sel_locale">
                      </select>
                  </td>
              </tr>                          
          </table>
      </div>
  </div>
  <div class="modal-footer">
      <div class="btn-group">
        <button class="btn btn-large" data-dismiss="modal" aria-hidden="true">Annulla</button>
        <button id="selettoreSalvaComitato" class="btn btn-large btn-primary disabled" disabled="disabled"><i class="icon-save"></i> Salva</button>
      </div>
  </div>
</div>
