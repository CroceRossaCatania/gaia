<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_PATENTI , APP_PRESIDENTE]);
?>
<script type="text/javascript"><?php require './js/presidente.utenti.js'; ?></script>
<br/>
<div class="row-fluid">
    <div class="span5 allinea-sinistra">
        <h2>
            <i class="icon-list muted"></i>
            Elenco richieste
        </h2>
    </div>
            
            <div class="span3">
                <div class="btn-group btn-group-vertical span12">
                        <a href="?p=patenti.dash" class="btn btn-block">
                            <i class="icon-reply"></i>
                            Torna alla dash
                        </a>
                </div>
            </div>
    
    <div class="span4 allinea-destra">
        <div class="input-prepend">
            <span class="add-on"><i class="icon-search"></i></span>
            <input autofocus required id="cercaUtente" placeholder="Cerca Volontari..." type="text">
        </div>
    </div>    
</div>
    
<hr />
    
<div class="row-fluid">
   <div class="span12">
       <div class="btn-group btn-group-vertical span12">
       </div>
       
       <table class="table table-striped table-bordered table-condensed" id="tabellaUtenti">
            <thead>
                <th>Cognome</th>
                <th>Nome</th>
                <th>Patente</th>
                <th>Stato</th>
                <th>Azioni</th>
            </thead>
        <?php
        $elenco = $me->comitatiApp ([ APP_PATENTI, APP_PRESIDENTE ]);
        foreach($elenco as $comitato) {
            $t = $comitato->pratichePatenti();
                ?>
            
            <tr class="success">
                <td colspan="7" class="grassetto">
                    <?= $comitato->nomeCompleto(); ?>
                    <span class="label label-warning">
                        <?= count($t); ?>
                    </span>
                </td>
            </tr>
            
            <?php
            foreach ( $t as $v ) {
                $_v = $v->volontario();
                $t = TitoloPersonale::id($v->titolo);
                $t = Titolo::id($t->titolo());
            ?>
                <tr>
                    <td><?= $_v->cognome; ?></td>
                    <td><?= $_v->nome; ?></td>
                    <td><?= $t->nome; ?></td>
                    <td><?= $conf['patente'][$v->stato]; ?></td>
                    <td>
                        <div class="btn-group">
                            <?php if($v->stato == PATENTE_RICHIESTA_PEDENTE){ ?>
                                <a class="btn btn-small" href="?p=patenti.richieste.ok&id=<?= $v->id; ?>&presa" title="Prendi in carico">
                                    <i class="icon-folder-open"></i> Prendi in carico
                                </a>
                            <?php }elseif($v->stato == PATENTE_ATTESA_VISITA){ ?>
                                <a class="btn btn-small btn-danger" href="?p=patenti.richieste.time&id=<?= $v->id; ?>&visita" title="Visita effettuata">
                                        <i class="icon-user-md"></i> Visita effettuata
                                </a>
                            <?php }elseif($v->stato == PATENTE_ATTESA_STAMPA){ ?>
                                <a  class="btn btn-small btn-warning" href="?p=patenti.richieste.time&id=<?= $v->id; ?>&stampa" title="Patente stampata">
                                    <i class="icon-print"></i> Patente stampata
                                </a>
                            <?php }elseif($v->stato == PATENTE_ATTESA_CONSEGNA){ ?>
                                <a class="btn btn-small btn-primary" href="?p=patenti.richieste.time&id=<?= $v->id; ?>&consegna" title="Patente consegnata">
                                    <i class="icon-folder-close"></i> Patente consegnata
                                </a>
                            <?php } ?>
                            <a class="btn btn-small btn-success" href="?p=utente.mail.nuova&id=<?= $_v->id; ?>" title="Invia Mail">
                                <i class="icon-envelope"></i>
                            </a>
                   </td>
                </tr>
                
               
       
        <?php }
        }
        ?>

        </table>
       
    </div>
    
</div>
