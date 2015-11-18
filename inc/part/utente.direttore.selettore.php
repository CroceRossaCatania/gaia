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
        var element = $(".chosen-select.direttori");
        var ruolo = element.data("ruolo");
        var qualifica = element.data("qualifica");
        var comitato = element.data("comitato");
        
        var select = $(".chosen-select.direttori");
        var input = null;
        var notfound = null;
        
        select.on('chosen:ready', function(event) {
                var $button = $('<button class="btn btn-sm btn-primary pull-right">cerca</button>');
                $(".chosen-select.direttori").next('.chosen-container').find('.search-field').append($button);
                
                input = $(".chosen-select.direttori").next('.chosen-container').find('input')[0];
                
                $button.on('click', function() {
                    
                    $button.addClass('loading');
                    $button.html('.....');
                    
                    var stato_direttore = '';

                    //var insertlink = '?p='+select.data('insert-page');

                    value = $(input).val();
                    if (value.length < 1) {
                        return;
                    }

                    api('corsi:volontari:cerca', {query: value, perPagina: 80, ordine: 'selettoreDirettore', comitati: comitato, stato_docente: stato_direttore, ruolo: ruolo, qualifica: qualifica}, function (x) {
                        select.children().remove('option:not(:selected)');
                        if (x.risposta.risultati.length) {
                            for (var i in x.risposta.risultati) {
                                select.append('<option value="'+x.risposta.risultati[i].id+'">'+x.risposta.risultati[i].nome + ' ' + x.risposta.risultati[i].cognome+'</option>');
                            }
                            select.trigger("chosen:updated");
                        } else {
                            $('.chosen-select.direttori + .chosen-container .no-results').html('NESSUN RISULTATO trovato per "'+value+'"');
                        }

                        $(input).val(value);
                    
                        $button.removeClass('loading');
                        $button.html('cerca');
                    });

                })
            })
            .chosen({
                max_selected_options: <?php echo $maxDirettori ?>, 
                no_results_text: "Premere CERCA per trovare un direttore",
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