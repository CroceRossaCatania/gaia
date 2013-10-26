<?php

/*
 * ©2012 Croce Rossa Italiana
 */

paginaAnonimo();

?>
<div class="row-fluid">
    <?php if ( !$me instanceof Anonimo ) { ?>
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
    <?php } else { ?>
    <div class="span12">
    <?php } 
     if ( $me instanceOf Anonimo ) { ?>
    
        <div class="alert alert-block alert-warning">

            <h4><i class="icon-globe"></i> Stai vedendo le attività di tutti i comitati.</h4>
            <a href="?p=login&back=attivita"><i class="icon-signin"></i> Entra su Gaia</a> per filtrare le attività del tuo comitato o 
            <a href="?p=public.attivita.mappa">clicca qui per vedere cosa fa Croce Rossa attorno a te <i class="icon-map-marker"></i></a>.

        </div>

    <?php } ?>
        
        <!--<div class="row-fluid">
            <div class="span12">
                <h2><span class="muted">Le </span>attività.</h2>
            </div>
        </div>-->
        
            
            <div class="row-fluid">
                
                <div class="span6 offset6">
                    <div class="btn-group">
                        <?php if ( $me->comitatiAreeDiCompetenza() ) { ?>

                        <a href="?p=attivita.idea" class="btn btn-large btn-success">
                            <i class="icon-plus-sign"></i>
                                Crea attività
                        </a>
                        
                        <?php } ?>
                        
                        <?php if ( $me->attivitaDiGestione() ) { ?>
                        <a href="?p=attivita.gestione" class="btn btn-primary btn-large">
                            <i class="icon-list"></i>
                                Gestisci attività
                        </a>
                        
                        <?php } ?>
                    </div>
                </div>
                
                 
            </div><hr />

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

