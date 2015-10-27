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
    $(document).ready( function () {        
        var value;
        var ruolo = $(".chosen-select").data("ruolo");
        var qualifica = $(".chosen-select").data("qualifica");
        chs = $(".chosen-select")
            .chosen({
                max_selected_options: <?php echo $maxDiscenti ?>, 
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
                
                var geoPolitica_discente = '';
                var stato_discente = '';
                var input = $(this).find('input')[0];
                var select = $( $(this).prev('select')[0] );
                var notfound = $(this).find('.no-results')[0];

                var insertlink = '?p='+select.data('insert-page');

                value = $(input).val();
                
                if (value.length < 1) {
                    return;
                }
                
                api('corsi:popolazione:cerca', {query: value, perPagina: 80, ordine: 'selettoreDiscente', comitati: geoPolitica_discente, stato_docente: stato_discente, ruolo: ruolo, qualifica: qualifica}, function (x) {
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