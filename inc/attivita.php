<?php

/*
 * ©2012 Croce Rossa Italiana
 */

paginaAnonimo();

if ( $me instanceof Anonimo || $me->stato == ASPIRANTE ) { 
    // Gli anonimi vengono riportati alla mappa!
    redirect('public.attivita.mappa');
}

?>


<div class="row-fluid">
        <div class="span3">
            <?php menuVolontario(); ?>
            <hr />
            <h4>Legenda dei colori</h4>
            <table class="table table-condensed table-striped">
                <tr>
                    <td style="color: #<?php echo $conf['attivita']['colore_pubbliche']; ?>;">
                        <i class="icon-sign-blank"></i>
                    </td>
                    <td>
                        Tutti i comitati
                    </td>
                </tr>
                <tr>
                    <td style="color: #<?php echo $conf['attivita']['colore_mie']; ?>;">
                        <i class="icon-sign-blank"></i>
                    </td>
                    <td>
                        Comitati di cui faccio parte
                    </td>
                </tr>
                <tr>
                    <td style="color: #B20000">
                        <i class="icon-sign-blank"></i>
                    </td>
                    <td>
                        Turni scoperti
                    </td>
                </tr>
            </table>
        </div>
        <div class="span9">
            <div class="row-fluid">
                <div class="span12">
                    <h2><i class="icon-calendar muted" id="icona-caricamento"></i>
                    Calendario delle attività</h2>
                    <hr />
                </div>
                <hr />
            </div>

            <div class="row-fluid">
                <div class="span12" id="calendario"></div>
            </div>
                
            <div class="row-fluid allinea-centro">
                <hr />
                <a href="?p=public.attivita.mappa" class="btn">
                    <i class="icon-map-marker"></i>
                    Vedi tutte le attività di Croce Rossa su una mappa
                </a>
            </div>
        
        </div>
      
</div>
