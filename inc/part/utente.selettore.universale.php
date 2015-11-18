<?php
$key = microtime();

if (isset($istruttori) && is_array($istruttori) && !empty($istruttori)) {
    $sel = '';
    foreach ($istruttori as $i) {
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

    var s_multi_<?php echo $key ?>  = false;
    var s_autosubmit_<?php echo $key ?> = false;
    var selezione_<?php echo $key ?> = [<?php echo $sel ?>];
    var dataInput_<?php echo $key ?> = '';
    var origElem_<?php echo $key ?> = '';
    var geoPolitica_<?php echo $key ?> = '';
    var stato_<?php echo $key ?> = '';

    $(document).ready(function () {
        $("[data-selettore-<?php echo $key ?>]").each(function (i, e) {
            if (typeof $(e).data('comitati') == 'undefined') {
                geoPolitica_<?php echo $key ?> = false;
            } else {
                geoPolitica_<?php echo $key ?> = $(e).data('comitati');
            }

            if (typeof $(e).data('stato_<?php echo $key ?>') == 'undefined') {
                stato_<?php echo $key ?> = false;
            } else {
                stato_<?php echo $key ?> = $(e).data('stato_<?php echo $key ?>');
                if (typeof stato_<?php echo $key ?> === 'string') {
                    stato_<?php echo $key ?> = stato_<?php echo $key ?>.split(",");
                }
            }

            $(e).click(function () {

                s_multi_<?php echo $key ?> = false;
                if ($(e).data('multi')) {
                    s_multi_<?php echo $key ?> = true;
                    $(".s_multi_<?php echo $key ?>").show();
                    $(".s_sing_<?php echo $key ?>").hide();
                } else {
                    $(".s_multi_<?php echo $key ?>").hide();
                    $(".s_sing_<?php echo $key ?>").show();
                }
                if ($(e).data('autosubmit')) {
                    s_autosubmit_<?php echo $key ?> = true;
                }

                dataInput_<?php echo $key ?> = $(e).data('input');
                origElem_<?php echo $key ?> = $(e);

                $("#selettore<?php echo $key ?>").modal('show');

                setTimeout(function () {
                    $("#selettoreCerca<?php echo $key ?>").val('').focus();
                }, 800);

            });
        });

        $("#selettoreCerca<?php echo $key ?>").keyup(keyupRicerca<?php echo $key ?>);

        $("#selettoreSalva<?php echo $key ?>").click(function () {
            // Rimuove già esistenti.
            $('[data-generato-<?php echo $key ?>]').remove();
            $("#selettore<?php echo $key ?>").modal('hide');

            if (s_multi_<?php echo $key ?>) {
                for (var i in selezione_<?php echo $key ?>) {
                    var stringa = '';
                    stringa += '<input data-generato-<?php echo $key ?>="true" type="hidden" ';
                    stringa += 'name="' + dataInput_<?php echo $key ?> + '[]" ';
                    stringa += 'value="' + selezione_<?php echo $key ?>[i] + '" />';
                    $(stringa).insertAfter($(origElem_<?php echo $key ?>));
                }
                $(origElem_<?php echo $key ?>).html(selezione_<?php echo $key ?>.length + ' istruttori selez. <i class="icon-pencil"></i>');
            } else {
                var ilNome;
                if (selezione_<?php echo $key ?>.length == 0) {
                    ilNome = '(Nessun istruttore)';
                } else {
                    var stringa = '';
                    stringa += '<input data-generato-<?php echo $key ?>="true" type="hidden" ';
                    stringa += 'name="' + dataInput_<?php echo $key ?> + '" ';
                    stringa += 'value="' + selezione_<?php echo $key ?>[0] + '" />';
                    $(stringa).insertAfter($(origElem_<?php echo $key ?>));
                    var ilNome = $("[data-sel]").data('nome');
                }
                $(origElem_<?php echo $key ?>).html(ilNome + ' <i class="icon-pencil"></i>');
            }
            if (s_autosubmit_<?php echo $key ?>) {
                $(origElem_<?php echo $key ?>).parents('form').submit();
            }
        });
    });

    var _ultimaRicerca = null;
    function keyupRicerca<?php echo $key ?>() {
        window.clearTimeout(_ultimaRicerca);
        $(".icona-ricerca").removeClass().addClass("icon-time");
        var query = $("#selettoreCerca<?php echo $key ?>").val();
        if (query.length < 1) {
            $("#selettoreRisultati<?php echo $key ?>").html('');
            return;
        }
        _ultimaRicerca = setTimeout(function () {
            $(".icona-ricerca").removeClass().addClass("icon-spin").addClass("icon-spinner");
            api('istruttori:cerca', {query: query, perPagina: 80, ordine: 'selettore<?php echo $key ?>', comitati: geoPolitica_<?php echo $key ?>, stato_<?php echo $key ?>: stato_<?php echo $key ?>}, function (x) {
                if ($("#selettoreCerca<?php echo $key ?>").val() != x.richiesta.parametri.query) {
                    return false;
                }

                $("#selettoreRisultati<?php echo $key ?>").html('');
                if (x.risposta.length < 1) {
                    $("#selettoreRisultati<?php echo $key ?>").html('<span class="text-warning"><i class="icon-warning-sign"></i> Nessun istruttore trovato.</span>');
                }
                for (var i in x.risposta.risultati) {
                    var stringa = '';
                    stringa += "<div data-id='" + x.risposta.risultati[i].id + "' data-nome='" + x.risposta.risultati[i].nome + "' class='collaMano'>";
                    stringa += "<i class='icon-plus'></i> <span class='grassetto'>" + x.risposta.risultati[i].nome + " " + x.risposta.risultati[i].cognome + "</span> (";
                    stringa += "<span class='muted'>" + x.risposta.risultati[i].comitato.nome + "</span>)</div>";

                    $(stringa).appendTo("#selettoreRisultati<?php echo $key ?>").click(function () {
                        var _id, _nome;
                        _id = $(this).data('id');
                        _nome = $(this).data('nome');
                        if (jQuery.inArray(_id, selezione_<?php echo $key ?>) != -1) {
                            return;
                        } // Gia presente

                        if (!s_multi_<?php echo $key ?> && selezione_<?php echo $key ?>.length == 1) {
                            alert('Non puoi scegliere più di un istruttore.');
                            return;
                        }

                        selezione_<?php echo $key ?>.push(_id);

                        $("#nvs<?php echo $key ?>").hide();
                        $("#uvs<?php echo $key ?>").show();

                        var stringa = '';
                        stringa += "<div data-id='" + _id + "' data-sel='true' data-nome='" + _nome + "' class='collaMano ctr'>";
                        stringa += "<i class='icon-remove'></i> <span class='grassetto'>" + _nome + "</span>";
                        stringa += "</div>";

                        $(stringa).appendTo("#selettoreSelezione<?php echo $key ?>").click(function () {
                            selezione_<?php echo $key ?>.splice($.inArray(_id, selezione_<?php echo $key ?>), 1); // Rimuove
                            $(this).remove();
                            if (selezione_<?php echo $key ?>.length == 0) {
                                $("#nvs<?php echo $key ?>").show();
                                $("#uvs<?php echo $key ?>").hide();
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

<div id="selettore<?php echo $key ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="selettore<?php echo $key ?>" aria-hidden="true">
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
                    <input class="span9 allinea-centro" id="selettoreCerca<?php echo $key ?>" placeholder="Cerca per nome, cognome..." />
                </div>

                <hr />

                <div id="selettoreRisultati<?php echo $key ?>">
                    <i>Cerca nome o parte del nome.</i>
                </div>
            </div>
            <div class="span6">

                <h4 class="s_multi_<?php echo $key ?>">Istruttori selezionati</h4>
                <h4 class="s_sing_<?php echo $key ?>">Istruttore selezionato</h4>

                <div id="selettoreSelezione<?php echo $key ?>">
                    <span id="nvs<?php echo $key ?>" style="display: <?php echo $nvsStyle; ?>"><i class="icon-warning-sign"></i> Nessun istruttore selezionato.</span>
                </div>
                <hr />
                <p id="uvs<?php echo $key ?>" class="text-warning nascosto">

                    <i class="icon-info-sign"></i> Per rimuovere un istruttore, clicca sul nome.
                </p>

            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div class="btn-group">
            <button class="btn btn-large" data-dismiss="modal" aria-hidden="true">Annulla</button>
            <button id="selettoreSalva<?php echo $key ?>" class="btn btn-large btn-primary"><i class="icon-save"></i> Salva</button>
        </div>
    </div>
</div>
