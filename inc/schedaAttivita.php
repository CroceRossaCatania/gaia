<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();
$a = new Attivita($_GET['id']);


?>


<div class="row-fluid">
    
    <div class="span3">
        <?php menuVolontario(); ?>
     


    </div>

    <div class="span9">
        
        <div class="row-fluid">
            
            <div class="span8 btn-group">
                
                <a href="?p=attivita" class="btn btn-large">
                    <i class="icon-reply"></i> Calendario
                </a>
                
                <?php if ( $a->modificabileDa($me) ) { ?>
                <a href="?p=attivita.nuova&id=<?php echo $a->id; ?>" class="btn btn-large btn-info">
                    <i class="icon-edit"></i>
                    Modifica
                </a>
                <?php } ?>
            </div>
            
            <div class="span4 allinea-destra">
                <span class="muted">
                    <strong>Ultimo aggiornamento</strong>:<br />
                    <i class="icon-time"></i> <?php echo date('d/m/Y H:i:s', $a->timestamp); ?>
                </span>
            </div>
           
            
        </div>
        
        <hr />
        
        <div class="row-fluid well allinea-centro">
            <h2><?php echo $a->nome; ?></h2>
            <h4 class="muted"><i class="icon-map-marker"></i> <?php echo $a->luogo; ?></h4>
        </div>
        
        
        <div class="row-fluid allinea-centro">
            <div class="span3">
                <span>
                    <i class="icon-user"></i>
                    Referente
                </span><br />
                <a href="mailto:<?php echo $a->referente()->email; ?>">
                    <?php echo $a->referente()->nome . ' ' . $a->referente()->cognome; ?>
                     </a>
                <br />
                    <span class="muted">+39</span> <?php echo $a->referente()->cellulare; ?>
               
            </div>  
            
            <div class="span3">
                <span>
                    <i class="icon-globe"></i>
                    Località
                </span><br />
                <a target="_new" href="<?php echo $a->linkMappa(); ?>">
                    Vedi sulla mappa
                </a>
            </div>   
            
            <div class="span3">
                <span>
                    <i class="icon-home"></i>
                    Organizzato da
                </span><br />
                <span class="text-info"><?php echo $a->comitato()->nome; ?></span>
            </div>   
            
            <div class="span3">
                <span>
                   <i class="icon-lock"></i>
                    Partecipazione
                </span><br />
                <span class="text-info">
                <?php if ( $a->pubblica ) { ?>
                    <strong>Permessa a tutti i volontari di Croce Rossa Italiana</strong>
                <?php } else { ?>
                    Permessa ai volontari del comitato organizzatore.
                <?php } ?>
                </span>
                
            </div>
        </div>
        
        <hr />
        
        <div class="row-fluid">
            
            <div class="span5">
               <div class="row-fluid allinea-centro">
                    <i class="icon-certificate"></i> Tipologia attività<br />
                    <span class="text-info"><?php echo $conf['app_attivita'][$a->tipo]; ?></span>
                </div>
                <hr />
                <p><i class="icon-info-sign"></i> Ulteriori informazioni</p>
                <blockquote class="span12"><?php echo nl2br($a->descrizione); ?></blockquote>
            </div>
            
            <div class="span7">

                <?php
                $ts = $a->turniScoperti();
                $tsn = count($ts);
                if ( $ts ) { ?>
                <h2 class="text-warning allinea-centro"><i class="icon-warning-sign"></i> Ci sono <?php echo $tsn; ?> turni scoperti</h2>
                
                
                <?php } ?>
            </div>
            
        </div>
        
        
    </div>
      
    
</div>

