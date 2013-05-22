<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAnonimo();
$a = new Attivita($_GET['id']);

$_titolo        = $a->nome . ' - Attività CRI su Gaia';
$_descrizione   = $a->luogo . " || Aperto a: " . $conf['att_vis'][$a->visibilita]
                    ." || Organizzato da " . $a->comitato()->nomeCompleto();


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
                <a href="?p=attivita.modifica&id=<?php echo $a->id; ?>" class="btn btn-large btn-info">
                    <i class="icon-edit"></i>
                    Modifica
                </a>
                <?php } ?>
                
                <a class="btn btn-large btn-primary" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode("http://www.gaiacri.it/index.php?p=attivita.scheda&id={$a->id}"); ?>" target="_blank">
                  <i class="icon-facebook-sign"></i> Condividi
                </a>
            </div>
            
            <div class="span4 allinea-destra">
                <span class="muted">
                    <strong>Ultimo aggiornamento</strong>:<br />
                    <i class="icon-time"></i> <?php echo date("d/m/Y H:i:s", $a->timestamp); ?>
                </span>
            </div>
           
            
        </div>
        
        <hr />
        
        <div class="row-fluid allinea-centro">
            <div class="span12">
                <h2 class="text-success"><?php echo $a->nome; ?></h2>
                <h4 class="text-info">
                    <i class="icon-map-marker"></i>
                        <a target="_new" href="<?php echo $a->linkMappa(); ?>">
                            <?php echo $a->luogo; ?>
                        </a>
                                            
                </h4>
            </div>
        </div>
        
        <hr />
        
        <div class="span12">

                <?php
                $ts = $a->turniScoperti();
                $tsn = count($ts);
                if ( $ts ) { ?>
                
                <div class="alert alert-block alert-error allinea-centro">
                    
                    <h4 class="text-error ">
                        <i class="icon-warning-sign"></i>
                        Ci sono <?php echo $tsn; ?> turni scoperti
                    </h4>
                    
                    <p>Aiutaci a colmare i posti mancanti!</p>
                    
                </div>
                
                <?php } ?>
            </div>
        
        <hr/>
        
        <div class="row-fluid allinea-centro">
            <div class="span3">
                <span>
                    <i class="icon-user"></i>
                    Referente
                </span><br />
                <a href="?p=utente.mail.nuova&id=<?php echo $a->referente()->id;?>">
                    <?php echo $a->referente()->nome . ' ' . $a->referente()->cognome; ?>
                     </a>
                <br />
                    <span class="muted">+39</span> <?php if($a->referente()->cellulareServizio){echo $a->referente()->cellulareServizio;}else{echo $a->referente()->cellulare;} ?>
               
            </div>  
            
            <div class="span3">
                <span>
                    <i class="icon-globe"></i>
                    Area d'intervento
                </span><br />
                <span class="text-info">
                    <?php echo $a->area()->nomeCompleto(); ?>
                </span>
            </div>   
            
            <div class="span3">
                <span>
                    <i class="icon-home"></i>
                    Organizzato da
                </span><br />
                <span class="text-info"><?php echo $a->comitato()->nomeCompleto(); ?></span>
            </div>   
            
            <div class="span3">
                <span>
                   <i class="icon-lock"></i>
                    Partecipazione
                </span><br />
                <span class="text-info">
                    <strong><?php echo $conf['att_vis'][$a->visibilita]; ?></strong>
                </span>
                
            </div>
        </div>
        
        <hr />
        
        <div class="row-fluid">
            
            <div class="span12">
                <p><i class="icon-info-sign"></i> Ulteriori informazioni</p>
                <?php echo nl2br($a->descrizione); ?>
            </div>
            
        </div>
        
        <hr />
        
        <h2><i class="icon-time"></i> Elenco turni dell'Attività</h2>
        
        <div class="row-fluid">
            <table class="table table-bordered table-striped" id="turniAttivita">
                <thead>
                    <th>Nome</th>
                    <th>Data ed ora</th>
                    <th>Volontari</th>
                    <th>Partecipa</th>
                </thead>
                
                <?php foreach ( $a->turni() as $turno ) { ?>
                
                    <tr<?php if ( $turno->scoperto() ) { ?> class="warning"<?php } ?> data-timestamp="<?php echo $turno->fine()->toJSON(); ?>">

                        <td>
                            <big><strong><?php echo $turno->nome; ?></strong></big>

                            <br />
                                <?php echo $turno->durata()->format('%H ore %i min'); ?>

                        </td>
                        <td>
                            <big><?php echo $turno->inizio()->inTesto(); ?></big><br />
                            <span class="muted">Fine: <strong><?php echo $turno->fine()->inTesto(); ?></strong></span>
                        </td>
                        
                        <td>
                            <?php if ( $turno->scoperto() ) { ?>
                                <span class="label label-warning">
                                    Scoperto!
                                </span><br />
                            <?php } ?>
                            <?php if ( $turno->pieno() ) { ?>
                                <span class="label label-important">
                                    Pieno!
                                </span><br />
                            <?php } ?>
                            <?php $pp = $turno->partecipazioni(); ?>
                            <strong>Volontari: <?php echo count($pp); ?></strong><br />
                            Min. <?php echo $turno->minimo; ?> &mdash; Max. <?php echo $turno->massimo; ?>
                            <?php if ( $pp ) { ?><br /><?php } ?>
                            <?php foreach ( $pp as $ppp ) { 
                                $vv = $ppp->volontario();
                                $ok = $turno->partecipazione($vv);
                            if($ok->stato == PART_OK){?>
                                <a href="#" title="<?php echo $vv->nomeCompleto(); ?>">
                                    <img class="img-circle" src="<?php echo $vv->avatar()->img(10); ?>" />
                                </a>
                            <?php }} ?>
                            
                            
                        </td>
                        <td>
                            
                            <?php if ( $pk = $turno->partecipazione($me) ) { ?>
                                
                                
                                 <a class="btn btn-block btn-info btn-large disabled" href="">
                                      <?php echo $conf['partecipazione'][$pk->stato]; ?>
                                 </a>
                                 <?php if($pk->stato == PART_PENDING) {?>
                                 <a class="btn btn-block btn-danger " href="?p=attivita.ritirati&id=<?php echo $pk->id; ?>">
                                      <i class="icon-remove"></i>
                                      Ritirati
                                 </a>
                                 <?php } ?>
                                
                                
                                
                            <?php } elseif ( $turno->puoRichiederePartecipazione($me) && !$me->inriserva()) { ?>
                                <a href="?p=attivita.partecipa&turno=<?php echo $turno->id; ?>" class="btn btn-success btn-large btn-block">
                                    <i class="icon-ok"></i> Partecipa
                                </a>
                                
                                
                            <?php } else { ?>
                                 <a class="btn btn-block disabled">
                                     <i class="icon-info-sign"></i> 
                                     Non puoi partecipare
                                 </a>

                            <?php } ?>
                        </td>
                    </tr>
                
                <?php } ?>
                
                <tr class="nascosto" id="rigaMostraTuttiTurni">
                    <td colspan="4">
                        <a id="mostraTuttiTurni" class="btn btn-block">
                            <i class="icon-info-sign"></i>
                            Ci sono <span id="numTurniNascosti"></span> turni passati nascosti.
                            <strong>Clicca per mostrare i turni nascosti.</strong>
                        </a>
                    </td>
                </tr>
            
            </table>
        </div>
        <hr />
        <?php $c = Commento::filtra([['attivita', $a],['upCommento', '0']], 'tCommenta DESC'); 
        if(!$c){ ?>
                <div class="alert alert-info">
                    <h4><i class="icon-thumbs-down"></i> Nessuna discussione.</h4>
                    <p><strong><?php echo $me->nomeCompleto(); ?></strong>, inizia tu una nuova discussione clicca qui.</p>
                </div>
            <?php }else{ ?>
            <h5><i class="icon-comment"></i> Commenti </h5>
            <?php foreach($c as $_c){ 
                if($i==2){
                    break;
                }else{ ?>
        <div class="row-fluid">
                <div class="row-fluid" id="commento">
                    <div class="span2 allinea-destra">
                        <?php $g= Volontario::by('id',$_c->volontario); ?>
                        <img src="<?php echo $g->avatar()->img(10); ?>" class="img-polaroid" />
                    </div>
                    <div class="span10">
                        <p class="text-info"><?php echo $g->nomeCompleto(); ?> <?php echo $_c->quando()->inTesto(); ?></p>
                        <p class="text"><blockquote><?php echo $_c->commento; ?></blockquote></p>
                    </div>
                </div>
                <br />
            </div>
        <?php 
                    $i++;
                    }}
                ?>
                <div class="span12 allinea-destra">
                    <a href="?p=attivita.pagina&a=<?php echo $a->id; ?>">Leggi tutto...</a> 
                </div>
                <?php } ?>
        
        
    </div>
      
    
</div>

