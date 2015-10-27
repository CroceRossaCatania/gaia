<?php
if (isset($direttori) && is_array($direttori) && !empty($direttori)) {
    $sel = '';
    foreach ($direttori as $i) {
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
        var value;
        var ruolo = $(".chosen-select").data("ruolo");
        var qualifica = $(".chosen-select").data("qualifica");
        
        chs = $(".chosen-select")
            .chosen({
                max_selected_options: <?php echo $maxDirettori ?>, 
                no_results_text: "Premere invio per cercare ",
                width: '100%'
            })
            .data('chosen')
            .container.on('keyup', function(event) {

                var code = event.which;
                if (code==13) {
                    event.preventDefault();
                } else {
                    return;
                }
                
                var geoPolitica_direttore = '';
                var stato_direttore = '';
                var input = $(this).find('input')[0];
                var select = $( $(this).prev('select')[0] );
                var notfound = $(this).find('.no-results')[0];

                var insertlink = '?p='+select.data('insert-page');

                value = $(input).val();
                if (value.length < 1) {
                    return;
                }
                
                api('corsi:volontari:cerca', {query: value, perPagina: 80, ordine: 'selettoreDirettore', comitati: geoPolitica_direttore, stato_docente: stato_direttore, ruolo: ruolo, qualifica: qualifica}, function (x) {
                    select.children().remove('option:not(:selected)');
                    if (x.risposta.risultati.length) {
                        for (var i in x.risposta.risultati) {
                            select.append('<option value="'+x.risposta.risultati[i].id+'">'+x.risposta.risultati[i].nome + ' ' + x.risposta.risultati[i].cognome+'</option>');
                        }
                        select.trigger("chosen:updated");
                    } else {
                        
                        $(notfound).html('NESSUN RISULTATO trovato per "'+value+'"<br/>Se non trovi questa persona, puoi <a class="btn btn-success" href="'+insertlink+'">inserire i suoi dati</a> nel sistema.');
                    }
                    
                    $(input).val(value);
                });
            });
        
//        chs.before(msgBox);
    });
</script>