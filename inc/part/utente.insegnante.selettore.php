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
        chs = $(".chosen-select")
            .chosen({
                max_selected_options: <?php echo $maxInsegnanti ?>, 
                no_results_text: "Nessun insegnante trovato!",
                width: '100%'
            })
            .data('chosen')
            .container.on('keyup', function(event) {

                var geoPolitica_insegnante = '';
                var stato_insegnante = '';
                var input = $(this).find('input')[0];
                var select = $( $(this).prev('select')[0] );

                var query = $(input).val();
                if (query.length < 1) {
                    return;
                }
                
                api('volontari:cerca', {query: query, perPagina: 80, ordine: 'selettoreInsegnante', comitati: geoPolitica_insegnante, stato_insegnante: stato_insegnante}, function (x) {
                    
                    select.children().remove('option:not(:selected)');
                    for (var i in x.risposta.risultati) {
                        select.append('<option value="'+x.risposta.risultati[i].id+'">'+x.risposta.risultati[i].nome + ' ' + x.risposta.risultati[i].cognome+'</option>');
                    }
                    select.trigger("chosen:updated");

                });
            });
    });
</script>