<?php
if (isset($affiancamenti) && is_array($affiancamenti) && !empty($affiancamenti)) {
    $sel = '';
    foreach ($affiancamenti as $i) {
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
        chs = $(".chosen-select.affiancamenti")
            .chosen({
                max_selected_options: <?php echo $maxAffiancamenti ?>, 
                no_results_text: "Nessun affiancamento trovato!",
                width: '100%'
            })
            .data('chosen')
            .container.on('keyup', function(event) {

                var geoPolitica_affiancamento = '';
                var stato_affiancamento = '';
                var input = $(this).find('input')[0];
                var select = $( $(this).prev('select')[0] );

                var query = $(input).val();
                if (query.length < 1) {
                    return;
                }
                
                api('volontari:cerca', {query: query, perPagina: 80, ordine: 'selettoreAffiancamento', comitati: geoPolitica_affiancamento, stato_affiancamento: stato_affiancamento}, function (x) {
                    
                    select.children().remove('option:not(:selected)');
                    for (var i in x.risposta.risultati) {
                        select.append('<option value="'+x.risposta.risultati[i].id+'">'+x.risposta.risultati[i].nome + ' ' + x.risposta.risultati[i].cognome+'</option>');
                    }
                    select.trigger("chosen:updated");

                });
            });
    });
</script>