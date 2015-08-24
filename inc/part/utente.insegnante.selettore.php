<?php
if (isset($insegnanti) && is_array($insegnanti) && !empty($insegnanti)) {
    $sel = '';
    foreach ($insegnanti as $i) {
        if (empty($sel)) {
            $sel .= ',';
        }
        if (is_int($sel)) {
            $sel .= $i;
        }
    }
}
?>

<script type="text/javascript">
    $(document).ready( function () {        
        $(".chosen-select")
            .chosen({width: '100%'})
            .data('chosen')
            .container.on('keyup', function(event) {

                var geoPolitica_insegnante = '';
                var stato_insegnante = '';
                var input = $(this).find('input')[0];

                var query = $(input).val();
                if (query.length < 1) {
                    return;
                }

                api('volontari:cerca', {query: query, perPagina: 80, ordine: 'selettoreInsegnante', comitati: geoPolitica_insegnante, stato_insegnante: stato_insegnante}, function (x) {
                    alert('ciups');
                });
            });
    });
    
<?php /*
    var s_multi_insegnante  = false;
    var s_autosubmit_insegnante = false;
    var selezione_insegnante = [<?php echo $sel ?>];
    var dataInput_insegnante = '';
    var origElem_insegnante = '';
    var geoPolitica_insegnante = '';
    var stato_insegnante = '';

    $(document).ready(function () {
        $("[data-selettore-insegnante]").each(function (i, e) {
            if (typeof $(e).data('comitati') == 'undefined') {
                geoPolitica_insegnante = false;
            } else {
                geoPolitica_insegnante = $(e).data('comitati');
            }

            if (typeof $(e).data('stato_insegnante') == 'undefined') {
                stato_insegnante = false;
            } else {
                stato_insegnante = $(e).data('stato_insegnante');
                if (typeof stato_insegnante === 'string') {
                    stato_insegnante = stato_insegnante.split(",");
                }
            }

            $(e).click(function () {

                s_multi_insegnante = false;
                if ($(e).data('multi')) {
                    s_multi_insegnante = parseInt($(e).data('multi'));
                    $(".s_multi_insegnante").show();
                    $(".s_sing_insegnante").hide();
                } else {
                    $(".s_multi_insegnante").hide();
                    $(".s_sing_insegnante").show();
                }
                if ($(e).data('autosubmit')) {
                    s_autosubmit_insegnante = true;
                }

                dataInput_insegnante = $(e).data('input');
                origElem_insegnante = $(e);

                $("#selettoreInsegnante").modal('show');

                setTimeout(function () {
                    $("#selettoreCercaInsegnante").val('').focus();
                }, 800);

            });
        });

        $("#selettoreCercaInsegnante").keyup(keyupRicercaInsegnante);

        $("#selettoreSalvaInsegnante").click(function () {
            // Rimuove già esistenti.
            $('[data-generato-insegnante]').remove();
            $("#selettoreInsegnante").modal('hide');

            if (s_multi_insegnante) {
                for (var i in selezione_insegnante) {
                    var stringa = '';
                    stringa += '<input data-generato-insegnante="true" type="hidden" ';
                    stringa += 'name="' + dataInput_insegnante + '[]" ';
                    stringa += 'value="' + selezione_insegnante[i] + '" />';
                    $(stringa).insertAfter($(origElem_insegnante));
                }
                $(origElem_insegnante).html(selezione_insegnante.length + ' insegnanti selez. <i class="icon-pencil"></i>');
            } else {
                var ilNome;
                if (selezione_insegnante.length == 0) {
                    ilNome = '(Nessun insegnante)';
                } else {
                    var stringa = '';
                    stringa += '<input data-generato-insegnante="true" type="hidden" ';
                    stringa += 'name="' + dataInput_insegnante + '" ';
                    stringa += 'value="' + selezione_insegnante[0] + '" />';
                    $(stringa).insertAfter($(origElem_insegnante));
                    var ilNome = $("[data-sel]").data('nome');
                }
                $(origElem_insegnante).html(ilNome + ' <i class="icon-pencil"></i>');
            }
            if (s_autosubmit_insegnante) {
                $(origElem_insegnante).parents('form').submit();
            }
        });
    });

    var _ultimaRicerca = null;
    function keyupRicercaInsegnante() {
        window.clearTimeout(_ultimaRicerca);
        $(".icona-ricerca").removeClass().addClass("icon-time");
        var query = $("#selettoreCercaInsegnante").val();
        if (query.length < 1) {
            $("#selettoreRisultatiInsegnante").html('');
            return;
        }
        _ultimaRicerca = setTimeout(function () {
            $(".icona-ricerca").removeClass().addClass("icon-spin").addClass("icon-spinner");
            api('volontari:cerca', {query: query, perPagina: 80, ordine: 'selettoreInsegnante', comitati: geoPolitica_insegnante, stato_insegnante: stato_insegnante}, function (x) {
                if ($("#selettoreCercaInsegnante").val() != x.richiesta.parametri.query) {
                    return false;
                }

                $("#selettoreRisultatiInsegnante").html('');
                if (x.risposta.length < 1) {
                    $("#selettoreRisultatiInsegnante").html('<span class="text-warning"><i class="icon-warning-sign"></i> Nessun insegnante trovato.</span>');
                }
                for (var i in x.risposta.risultati) {
                    var stringa = '';
                    stringa += "<div data-id='" + x.risposta.risultati[i].id + "' data-nome='" + x.risposta.risultati[i].nome + "' class='collaMano'>";
                    stringa += "<i class='icon-plus'></i> <span class='grassetto'>" + x.risposta.risultati[i].nome + " " + x.risposta.risultati[i].cognome + "</span> (";
                    stringa += "<span class='muted'>" + x.risposta.risultati[i].comitato.nome + "</span>)</div>";

                    $(stringa).appendTo("#selettoreRisultatiInsegnante").click(function () {
                        var _id, _nome;
                        _id = $(this).data('id');
                        _nome = $(this).data('nome');
                        if (jQuery.inArray(_id, selezione_insegnante) != -1) {
                            return;
                        } // Gia presente

                        if (!s_multi_insegnante && selezione_insegnante.length == 1) {
                            alert('Non puoi scegliere più di un insegnante.');
                            return;
                        }
                        
                        
                        if (s_multi_insegnante && s_multi_insegnante == selezione_insegnante.length) {
                            alert('Non puoi scegliere altri insegnanti, hai raggiunto il numero massimo consentito di '+selezione_insegnante.length+'.');
                            return;
                        }

                        selezione_insegnante.push(_id);

                        $("#nvsInsegnante").hide();
                        $("#uvsInsegnante").show();

                        var stringa = '';
                        stringa += "<div data-id='" + _id + "' data-sel='true' data-nome='" + _nome + "' class='collaMano ctr'>";
                        stringa += "<i class='icon-remove'></i> <span class='grassetto'>" + _nome + "</span>";
                        stringa += "</div>";

                        $(stringa).appendTo("#selettoreSelezioneInsegnante").click(function () {
                            selezione_insegnante.splice($.inArray(_id, selezione_insegnante), 1); // Rimuove
                            $(this).remove();
                            if (selezione_insegnante.length == 0) {
                                $("#nvsInsegnante").show();
                                $("#uvsInsegnante").hide();
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
*/ ?>
</script>

<?php /*
<div id="selettoreInsegnante" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="selettoreInsegnante" aria-hidden="true">
    <div class="modal-header">
        <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>-->
        <h3><i class="icon-user"></i> Selezione degli insegnanti</h3>
    </div>
    <div class="modal-body">
        <div class="row-fluid">
            <div class="span6">
                <h4>Ricerca insegnanti</h4>

                <div class="input-prepend">
                    <span class="add-on">
                        <i class="icon-search icona-ricerca"></i>
                    </span>
                    <input class="span9 allinea-centro" id="selettoreCercaInsegnante" placeholder="Cerca per nome, cognome..." />
                </div>

                <hr />

                <div id="selettoreRisultatiInsegnante">
                    <i>Cerca nome o parte del nome.</i>
                </div>
            </div>
            <div class="span6">

                <h4 class="s_multi_insegnante">Insegnanti selezionati</h4>
                <h4 class="s_sing_insegnante">Insegnante selezionato</h4>

                <div id="selettoreSelezioneInsegnante">
                    <span id="nvsInsegnante" style="display: <?php echo $nvsInsegnanteStyle; ?>"><i class="icon-warning-sign"></i> Nessun insegnante selezionato.</span>
                </div>
                <hr />
                <p id="uvsInsegnante" class="text-warning nascosto">

                    <i class="icon-info-sign"></i> Per rimuovere un insegnante, clicca sul nome.
                </p>

            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div class="btn-group">
            <button class="btn btn-large" data-dismiss="modal" aria-hidden="true">Annulla</button>
            <button id="selettoreSalvaInsegnante" class="btn btn-large btn-primary"><i class="icon-save"></i> Salva</button>
        </div>
    </div>
</div>
*/ ?>
