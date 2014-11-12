<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPresidenziale();

controllaParametri(array('inputData'));

$array=explode('/',$_POST['inputData']);
$anno = $array[1];
$mese = $array[0];
$inizio = mktime(0, 0, 0, $mese, 1, $anno);
$giorno = cal_days_in_month(CAL_GREGORIAN, $mese, $anno);
$fine = mktime(0, 0, 0, $mese, $giorno, $anno);

?>
<script type="text/javascript"><?php require './assets/js/presidente.utenti.js'; ?></script>
<br/>
<div class="row-fluid">
    <div class="span8">
        <h2>
            <i class="icon-time muted"></i>
            Volontari che non hanno effettuato turno
        </h2>
        <p>nel mese di <strong><?php echo $conf['mesi'][(INT) $mese]; ?> <?php echo $anno; ?></strong></p>
    </div>
    
    <div class="span4 allinea-destra">
        <div class="input-prepend">
            <span class="add-on"><i class="icon-search"></i></span>
            <input autofocus required id="cercaUtente" placeholder="Cerca Volontario..." type="text">
        </div>
    </div>    
</div>

<hr />
<div class="row-fluid">
    <div class="span12">
        <div class="btn-group btn-group-vertical span12">
         <?php if ( count($me->comitatiApp (APP_PRESIDENTE)) > 1 ) { ?>
         <a href="?p=presidente.turni.zero.excel&time=<?php echo $inizio; ?>&com" class="btn btn-block btn-inverse" data-attendere="Generazione e compressione in corso...">
             <i class="icon-download"></i>
             <strong>Presidente</strong> &mdash; Scarica tutti i fogli dei volontari che non hanno effettuato servizio nel mese specificato.
         </a>
         <?php } ?>
         <a href="?p=utente.mail.nuova&zeroturnicom&time=<?php echo $inizio; ?>" class="btn btn-block btn-success">
             <i class="icon-envelope"></i>
             <strong>Presidente</strong> &mdash; Invia mail di massa a tutti i Volontari.
         </a><hr />
     </div>
     <table class="table table-striped table-bordered" id="tabellaUtenti">
        <thead>
            <th>Nome</th>
            <th>Cognome</th>
            <th>Codice Fiscale</th>
            <th>Data di nascita</th>
            <th>Azione</th>
        </thead>
        <?php
        $comitati = $me->comitatiApp (APP_PRESIDENTE);
        foreach($comitati as $comitato){
            $volontari = $comitato->membriAttuali();
            ?>
            <tr class="success">
                <td colspan="5" class="grassetto">
                    <?php echo $comitato->nomeCompleto(); ?>
                    <a class="btn btn-success btn-small pull-right" href="?p=utente.mail.nuova&zeroturniunit&id=<?php echo $comitato->id; ?>&time=<?php echo $inizio; ?>">
                     <i class="icon-envelope"></i> Invia mail
                 </a>
                 <a class="btn btn-small pull-right" 
                 href="?p=presidente.turni.zero.excel&c=<?php echo $comitato->id; ?>&unit&time=<?php echo $inizio; ?>"
                 data-attendere="Generazione...">
                 <i class="icon-download"></i> scarica come foglio excel
             </a>
         </td>
     </tr>
     <?php   foreach($volontari as $v){
        $partecipazioni = $v->partecipazioni();
        $x=0;
        foreach ($partecipazioni as $part){
            if ($x==0){
                if ( $part->turno()->inizio >= $inizio && $part->turno()->fine <= $fine ){
                    $auts = $part->autorizzazioni();
                    if ($auts[0]->stato == AUT_OK){
                        $x=1;
                    }
                    $turno = $part->turno();
                    $co = Coturno::filtra([['turno', $turno],['volontario', $v]]);
                    if ($co){
                        $x=1;
                    }
                }
            }
        }

        if ( $x==0 ){
            ?>

            <tr>
                <td><?php echo $v->nome; ?></td>
                <td><?php echo $v->cognome; ?></td>
                <td><?php echo $v->codiceFiscale; ?></td>
                <td><?php echo date('d/m/Y', $v->dataNascita); ?></td>
                <td>
                    <div class="btn-group">
                        <a class="btn btn-small" href="?p=presidente.utente.visualizza&id=<?php echo $v->id; ?>" target="_new" title="Dettagli">
                            <i class="icon-eye-open"></i> Dettagli
                        </a>
                        <a class="btn btn-info btn-small" href="?p=presidente.utente.turni&id=<?php echo $v->id; ?>" target="_new" title="Storico turni">
                            <i class="icon-time"></i> Storico Turni
                        </a>
                        <a class="btn btn-small btn-danger" href="?p=presidente.utente.dimetti&id=<?php echo $v->id; ?>" title="Dimetti Volontario">
                            <i class="icon-ban-circle"></i> Dimetti
                        </a>
                        <a class="btn btn-small btn-success" href="?p=utente.mail.nuova&id=<?php echo $_->id; ?>" title="Invia Mail">
                            <i class="icon-envelope"></i>
                        </a>
                    </div>   
                </td>
                
            </tr>
            <?php 

        }
    }
}?>
</table>
</div>
</div>