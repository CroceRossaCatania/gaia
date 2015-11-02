<?php
if (isset($docenti) && is_array($docenti) && !empty($docenti)) {
    $sel = '';
    foreach ($docenti as $i) {
        if (empty($sel)) {
            $sel .= ',';
        }
        if (is_int($sel)) {
            $sel .= $i;
        }
    }
}
if (!isset($maxDocenti)) {
    $maxDocenti = 1;
}
?>

<script type="text/javascript">
    $(document).ready( function () { 
        var value;
        var ruolo = $(".chosen-select.docenti").data("ruolo");
        var qualifica = $(".chosen-select.docenti").data("qualifica");
        
        var select = $(".chosen-select.docenti");
        var input = null;
        var notfound = null;

        select.on('chosen:ready', function(event) {
                var $button = $('<button class="btn btn-sm btn-primary pull-right">cerca</button>');
                $(".chosen-select.docenti").next('.chosen-container').find('.search-field').append($button);
                
                input = $(".chosen-select.docenti").next('.chosen-container').find('input')[0];

                $button.on('click', function() {
                    
                    $button.addClass('loading');
                    
                    var geoPolitica_docente = '';
                    var stato_docente = '';

                    //var insertlink = '?p='+select.data('insert-page');

                    value = $(input).val();
                if (value.length < 1) {
                    return;
                }
                                
                    api('corsi:volontari:cerca', {query: value, perPagina: 80, ordine: 'selettoreDocente', comitati: geoPolitica_docente, stato_docente: stato_docente, ruolo: ruolo, qualifica: qualifica}, function (x) {
                    select.children().remove('option:not(:selected)');
                        if (x.risposta.risultati.length) {
                    for (var i in x.risposta.risultati) {
                        select.append('<option value="'+x.risposta.risultati[i].id+'">'+x.risposta.risultati[i].nome + ' ' + x.risposta.risultati[i].cognome+'</option>');
                    }
                    select.trigger("chosen:updated");
                        } else {
//                            $(notfound).html('NESSUN RISULTATO trovato per "'+value+'"');
                        }

                        $(input).val(value);
                    
                        $button.removeClass('loading');
                });

                })
            })
            .chosen({
                max_selected_options: <?php echo $maxDocenti ?>, 
                no_results_text: "Premere CERCA per trovare un docente",
                width: '100%'
            })
            .data('chosen')
            .container.on('keyup', function(event) {

                var input = $(this).find('input')[0];

                value = $(input).val();
                if (value.length < 1) {
                    return;
                }
/*
                var code = event.which;
                if (code==13) {
                    event.preventDefault();
                } else {
                    return;
                }
*/              
                
            });
            
    });
</script>