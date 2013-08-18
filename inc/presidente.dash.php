<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPresidenziale();
// caricaSelettore();


$comitati = $me->comitatiDiCompetenza();

if ( $sessione->attenzione == false ){
    $sessione->attenzione = true;
    ?>

<div class="modal fade automodal">
        <div class="modal-header">
          <h3 class="text-success"><i class="icon-phone"></i> Gaia da oggi ti risponde!</h3>
        </div>
        <div class="modal-body">
          <p>Salve Presidente <?php echo $me->nome; ?>, da oggi Gaia ti risponde!</p>
          <p>Se hai bisogno di assistenza immediata chiama il <strong>+39 0692928574</strong></p>
        </div>
        <div class="modal-footer">
          <button data-dismiss="modal" aria-hidden="true" class="btn btn-primary">
            Ok, grazie
          </a>
        </div>
</div>
    
<?php } ?>

<div class="row-fluid">
    <div class="span3">
        <?php menuVolontario(); ?>
    </div>
    <div class="span9">

        
        <div class="row-fluid">
            
            <div class="span9">
                <h2>Salve, <?php if($me->admin()){?>Admin <?php }else{ ?> Presidente <?php } echo $me->cognome; ?>.</h2>
            </div>
            
            <div class="span3 allinea-destra">
                <br />
                <a href="?p=utente.supporto">Aiuto <i class="icon-question-sign"></i></a>
            </div>
            
        </div>
                    
        <div class="row-fluid">
            
            <div class="span3">
                <div class="btn-group btn-group-vertical span12">
                    <a href="?p=presidente.utenti" class="btn btn-primary btn-block">
                        <i class="icon-list"></i>
                        Elenco volontari
                    </a>
                    <a href="?p=presidente.titoli.ricerca" class="btn btn-block">
                        <i class="icon-search"></i>
                        Ricerca per titolo
                    </a>
                </div>
            </div>
            
            <div class="span6 allinea-centro">
                <img src="https://upload.wikimedia.org/wikipedia/it/thumb/4/4a/Emblema_CRI.svg/75px-Emblema_CRI.svg.png" />
            </div>
            
            
            <div class="span3">
                
                <table class="table table-striped table-condensed">
                
                    <tr><td>Num. comitati</td><td><?php echo count($comitati); ?></td></tr>
                    <tr><td>Num. volontari</td><td><?php echo $me->numVolontariDiCompetenza(); ?></td></tr>
                    
                </table>
                
                
            </div>
            

            
        </div>
        
        <hr />
        
        <p class="text-success"><i class="icon-info-sign"></i> <strong>Unità di competenza</strong> &mdash;
            Cliccare sul nome di una unità per modificarne <strong>delegati, obiettivi, responsabili, ecc.</strong>:</p>
        
        <div class="" id="comitati">
            
            <table class="table table-condensed table-striped">
            <?php 
            $livello = 0;
            $massimo = 5;
            $ricorsiva = function( $comitato ) use (&$ricorsiva, &$livello, $massimo) {
                ?>
                <tr>
                    <?php for ( $a = 0; $a <= $livello; $a++ ) { ?>
                        <td>&nbsp;</td>
                    <?php } ?>
                    <td data-livello="<?php echo $livello; ?>" colspan="<?php echo ($massimo - $livello); ?>">
                        <a href="?p=presidente.comitato&oid=<?php echo $comitato->oid(); ?>">
                            <?php if ( $comitato instanceOf Comitato ) { ?>
                                <i class="icon-pencil"></i> <?php echo $comitato->nome; ?>
                            <?php } else { ?>
                                <strong><?php echo $comitato->nomeCompleto(); ?></strong>
                            <?php } ?>
                        </a>
                    </td>

                    <?php if ( $comitato instanceOf Comitato ) { ?>
                        <td>
                                <a 
                                    href="?p=presidente.utenti.excel&comitato=<?php echo $comitato->id; ?>"
                                    data-attendere="generazione..."
                                    >
                                    <i class="icon-download-alt"></i>
                                    scarica volontari
                                </a>
                        </td>
                        <td>
                                <a href="?p=utente.mail.nuova&id=<?php echo $comitato->id; ?>">
                                    <i class="icon-envelope-alt"></i>
                                    email di massa
                                </a>
                        </td>
                    <?php } else { ?>
                        <td colspan="2">
                            <a href="?p=presidente.comitato&oid=<?php echo $comitato->oid(); ?>">
                                <i class="icon-pencil"></i>
                                modifica dettagli e delegati
                            </a>
                        </td>
                    <?php } ?>
                </tr>
                    <?php if ($figli = $comitato->figli()) { 
                        $livello++;
                        ?>
                            <?php foreach ( $figli as $figlio ) {
                                $ricorsiva($figlio);
                            } ?>
                        
                    <?php 
                    $livello--;
                    } ?>
                <?php
            };

            foreach ( $me->entitaDelegazioni(APP_PRESIDENTE) as $c ) { 
                $ricorsiva($c);
            } ?>
            </table>
            
        </div>
        
            


    </div>
</div>
            


