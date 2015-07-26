<?php
if (isset($discenti) && is_array($discenti) && !empty($discenti)) {
    $sel = '';
    foreach ($discenti as $i) {
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

    var s_multi_discente  = false;
    var s_autosubmit_discente = false;
    var selezione_discente = [<?php echo $sel ?>];
    var dataInput_discente = '';
    var origElem_discente = '';
    var geoPolitica_discente = '';
    var stato_discente = '';

    $(document).ready(function () {
        $("[data-selettore-discente]").each(function (i, e) {
            if (typeof $(e).data('comitati') == 'undefined') {
                geoPolitica_discente = false;
            } else {
                geoPolitica_discente = $(e).data('comitati');
            }

            if (typeof $(e).data('stato_discente') == 'undefined') {
                stato_discente = false;
            } else {
                stato_discente = $(e).data('stato_discente');
                if (typeof stato_discente === 'string') {
                    stato_discente = stato_discente.split(",");
                }
            }

            $(e).click(function () {

                s_multi_discente = false;
                if ($(e).data('multi')) {
                    s_multi_discente = parseInt($(e).data('multi'));
                    $(".s_multi_discente").show();
                    $(".s_sing_discente").hide();
                } else {
                    $(".s_multi_discente").hide();
                    $(".s_sing_discente").show();
                }
                if ($(e).data('autosubmit')) {
                    s_autosubmit_discente = true;
                }

                dataInput_discente = $(e).data('input');
                origElem_discente = $(e);

                $("#selettoreDiscente").modal('show');

                setTimeout(function () {
                    $("#selettoreCercaDiscente").val('').focus();
                }, 800);

            });
        });

        $("#selettoreCercaDiscente").keyup(keyupRicercaDiscente);

        $("#selettoreSalvaDiscente").click(function () {
            // Rimuove già esistenti.
            $('[data-generato-discente]').remove();
            $("#selettoreDiscente").modal('hide');

            if (s_multi_discente) {
                for (var i in selezione_discente) {
                    var stringa = '';
                    stringa += '<input data-generato-discente="true" type="hidden" ';
                    stringa += 'name="' + dataInput_discente + '[]" ';
                    stringa += 'value="' + selezione_discente[i] + '" />';
                    $(stringa).insertAfter($(origElem_discente));
                }
                $(origElem_discente).html(selezione_discente.length + ' discenti selez. <i class="icon-pencil"></i>');
            } else {
                var ilNome;
                if (selezione_discente.length == 0) {
                    ilNome = '(Nessun discente)';
                } else {
                    var stringa = '';
                    stringa += '<input data-generato-discente="true" type="hidden" ';
                    stringa += 'name="' + dataInput_discente + '" ';
                    stringa += 'value="' + selezione_discente[0] + '" />';
                    $(stringa).insertAfter($(origElem_discente));
                    var ilNome = $("[data-sel]").data('nome');
                }
                $(origElem_discente).html(ilNome + ' <i class="icon-pencil"></i>');
            }
            if (s_autosubmit_discente) {
                $(origElem_discente).parents('form').submit();
            }
        });
    });

    var _ultimaRicerca = null;
    function keyupRicercaDiscente() {
        window.clearTimeout(_ultimaRicerca);
        $(".icona-ricerca").removeClass().addClass("icon-time");
        var query = $("#selettoreCercaDiscente").val();
        if (query.length < 1) {
            $("#selettoreRisultatiDiscente").html('');
            return;
        }
        _ultimaRicerca = setTimeout(function () {
            $(".icona-ricerca").removeClass().addClass("icon-spin").addClass("icon-spinner");
            api('volontari:cerca', {query: query, perPagina: 80, ordine: 'selettoreDiscente', comitati: geoPolitica_discente, stato_discente: stato_discente}, function (x) {
                if ($("#selettoreCercaDiscente").val() != x.richiesta.parametri.query) {
                    return false;
                }

                $("#selettoreRisultatiDiscente").html('');
                if (x.risposta.length < 1) {
                    $("#selettoreRisultatiDiscente").html('<span class="text-warning"><i class="icon-warning-sign"></i> Nessun discente trovato.</span>');
                }
                for (var i in x.risposta.risultati) {
                    var stringa = '';
                    stringa += "<div data-id='" + x.risposta.risultati[i].id + "' data-nome='" + x.risposta.risultati[i].nome + "' class='collaMano'>";
                    stringa += "<i class='icon-plus'></i> <span class='grassetto'>" + x.risposta.risultati[i].nome + " " + x.risposta.risultati[i].cognome + "</span> (";
                    stringa += "<span class='muted'>" + x.risposta.risultati[i].comitato.nome + "</span>)</div>";

                    $(stringa).appendTo("#selettoreRisultatiDiscente").click(function () {
                        var _id, _nome;
                        _id = $(this).data('id');
                        _nome = $(this).data('nome');
                        if (jQuery.inArray(_id, selezione_discente) != -1) {
                            return;
                        } // Gia presente

                        if (!s_multi_discente && selezione_discente.length == 1) {
                            alert('Non puoi scegliere più di un discente.');
                            return;
                        }
                        
                        
                        if (s_multi_discente && s_multi_discente == selezione_discente.length) {
                            alert('Non puoi scegliere altri discenti, hai raggiunto il numero massimo consentito di '+selezione_discente.length+'.');
                            return;
                        }

                        selezione_discente.push(_id);

                        $("#nvsDiscente").hide();
                        $("#uvsDiscente").show();

                        var stringa = '';
                        stringa += "<div data-id='" + _id + "' data-sel='true' data-nome='" + _nome + "' class='collaMano ctr'>";
                        stringa += "<i class='icon-remove'></i> <span class='grassetto'>" + _nome + "</span>";
                        stringa += "</div>";

                        $(stringa).appendTo("#selettoreSelezioneDiscente").click(function () {
                            selezione_discente.splice($.inArray(_id, selezione_discente), 1); // Rimuove
                            $(this).remove();
                            if (selezione_discente.length == 0) {
                                $("#nvsDiscente").show();
                                $("#uvsDiscente").hide();
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

<div id="selettoreDiscente" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="selettoreDiscente" aria-hidden="true">
    <div class="modal-header">
        <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>-->
        <h3><i class="icon-user"></i> Selezione degli discenti</h3>
    </div>
    <div class="modal-body">
        <div class="row-fluid">
            <div class="span6">
                <h4>Ricerca discenti</h4>

                <div class="input-prepend">
                    <span class="add-on">
                        <i class="icon-search icona-ricerca"></i>
                    </span>
                    <input class="span9 allinea-centro" id="selettoreCercaDiscente" placeholder="Cerca per nome, cognome..." />
                </div>

                <hr />

                <div id="selettoreRisultatiDiscente">
                    <i>Cerca nome o parte del nome.</i>
                </div>
            </div>
            <div class="span6">

                <h4 class="s_multi_discente">Discenti selezionati</h4>
                <h4 class="s_sing_discente">Discente selezionato</h4>

                <div id="selettoreSelezioneDiscente">
                    <span id="nvsDiscente" style="display: <?php echo $nvsDiscenteStyle; ?>"><i class="icon-warning-sign"></i> Nessun discente selezionato.</span>
                </div>
                <hr />
                <p id="uvsDiscente" class="text-warning nascosto">

                    <i class="icon-info-sign"></i> Per rimuovere un discente, clicca sul nome.
                </p>

            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div class="btn-group">
            <button class="btn btn-large" data-dismiss="modal" aria-hidden="true">Annulla</button>
            <button id="selettoreSalvaDiscente" class="btn btn-large btn-primary"><i class="icon-save"></i> Salva</button>
        </div>
    </div>
</div>
