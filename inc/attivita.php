<?php

/*
 * ©2012 Croce Rossa Italiana
 */

paginaAnonimo();

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
            <?php if ( !$me instanceof Anonimo ) { ?>
                <tr>
                    <td style="color: #<?php echo $conf['attivita']['colore_mie']; ?>;">
                        <i class="icon-sign-blank"></i>
                    </td>
                    <td>
                        Comitati di cui faccio parte
                    </td>
                </tr>
            <?php } ?>

        </table>


    </div>

    <div class="span9">
        
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

