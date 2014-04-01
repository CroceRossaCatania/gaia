<?php

/*
 * ©2013 Croce Rossa Italiana
 */
paginaApp([APP_CO , APP_PRESIDENTE]);

?>
<?php if ( isset($_GET['monta']) ) { ?>
    <script>
        $(window).load(function () {
            $('#ok').toggle(1500);
            $('.monta').toggle(1500);
            $('.smonta').toggle(1500);
            $('.visualizza').toggle(1500);
        });
    </script>
        <div id="ok" class="alert alert-success">
            <i class="icon-ok"></i><strong> Volontario in turno</strong>
        </div>
<?php } elseif ( isset($_GET['smonta']) )  { ?>
    <script>
        $(window).load(function () {
            $('#no').toggle(1500);
            $('.monta').toggle(1500);
            $('.smonta').toggle(1500);
            $('.visualizza').toggle(1500);
        });
    </script>
    <div id="no" class="alert alert-block alert-error">
        <i class="icon-exclamation-sign"></i><strong> Volontario smontato</strong>
    </div>
<?php }else{ ?>
    <script>
        $(window).load(function () {
            $('.monta').toggle(1500);
            $('.smonta').toggle(1500);
            $('.visualizza').toggle(1500);
        });
    </script>
<?php } ?>
    <br/>
<div class="row-fluid">
    <div class="span5 allinea-sinistra">
        <h2>
            <i class="icon-time muted"></i>
            Elenco attività odierne
        </h2>
    </div>
    
    <div class="span3">
        <div class="btn-group btn-group-vertical span12">
                <a href="?p=co.dash" class="btn btn-block ">
                    <i class="icon-reply"></i> Torna alla dash
                </a>
        </div>
    </div>
    
    <div class="span4 allinea-destra">
        <div class="input-prepend">
            <span class="add-on"><i class="icon-search"></i></span>
            <input autofocus required id="cercaUtente" placeholder="Cerca Volontari e Attività..." type="text">
        </div>
    </div>    
</div>
<div class="row-fluid">
   <div class="span12">
        <?php if (isset($_GET['err'])) { ?>
            <div class="alert alert-block alert-error">
                <h4><i class="icon-warning-sign"></i> <strong>Qualcosa non ha funzionato</strong>.</h4>
                <p>L'operazione che stavi tentando di eseguire non è andata a buon fine. Per favore riprova.</p>
            </div> 
        <?php } ?>
        <hr />
       <table class="table table-striped table-bordered table-condensed" id="tabellaUtenti">
            <thead>
                <th>Turno</th>
                <th>Inizio</th>
                <th>Fine</th>
            </thead>
        <?php
        $f = time()-3600;
        $comitati = $me->comitatiApp ([ APP_CO, APP_PRESIDENTE ]);
        foreach($comitati as $comitato){
            $turni = $comitato->coTurni();
                    foreach($turni as $turno){
                        $z=0;
                        $partecipanti = $turno->partecipazioniStato(AUT_OK);
                        foreach ($partecipanti as $partecipante){ 
                            $partecipante = $partecipante->volontario();
                            $m = Coturno::filtra([['volontario', $partecipante],['turno',$turno]]); 
                            if ( $turno->fine >= $f || ($m[0]->pMonta && !$m[0]->pSmonta) ) {
                                $attivita = $turno->attivita();
                                if($x!=$attivita){ 
                                    $x=$attivita; ?> 
                                    <tr class="primary">
                                        <td colspan="4" class="grassetto">
                                        <?php echo $attivita->nome ," - Referente: " , $attivita->referente()->nomeCompleto() , " Cell: ", $attivita->referente()->cellulare(); ?>
                                        </td>
                                    </tr>
                                    <?php 
                                    } 
                                    if ( $z == 0){
                                    ?>
                                <tr class="info">
                                       <td><?php echo $turno->nome; ?></td>
                                       <td><?php echo date('d-m-Y H:i', $turno->inizio); ?></td>
                                       <td><?php echo date('d-m-Y H:i', $turno->fine); ?></td>
                                </tr>
                                    <?php $z++;
                                    
                                    } ?>
                                <tr class="<?php if(!$m[0]->pSmonta && !$m[0]->stato == CO_MONTA){ ?> warning <?php }elseif($m[0]->stato == CO_MONTA){ ?> success <?php }else{ ?> error <?php } ?>">
                                   <td><?php echo $partecipante->nomeCompleto(); ?></td>
                                   <td><?php echo $partecipante->cellulare(); ?></td>
                                   <td>
                                       <div class="btn-group">
                                           <?php if($m[0]->stato == '' || !$m[0]->stato == CO_MONTA || $m[0]->stato == CO_MONTA){ ?>
                                            <a class="visualizza btn btn-small btn nascosto" target="_new" href="?p=profilo.controllo&id=<?php echo $partecipante->volontario(); ?>" title="Visualizza">
                                                <i class="icon-eye-open"></i> Visualizza
                                            </a>
                                           <?php } ?>
                                           <?php if(!$m[0]->stato == CO_MONTA){ ?>
                                                <a onclick="$('.monta').hide(500); $('.smonta').hide(500); $('.visualizza').hide(500); $('.m1').toggle(500);" class="monta btn btn-small btn-success nascosto" href="?p=co.attivita.ok&v=<?php echo $partecipante->volontario(); ?>&t=<?php echo $turno; ?>&monta" title="Monta">
                                                    <i class="icon-arrow-up"></i> Monta
                                                </a>
                                                <div class="m1 alert alert-block alert-warning nascosto">
                                                    <h4><i class="icon-warning-sign"></i> <strong>Attendere...</strong>.</h4>
                                                </div>
                                            <?php } 
                                            if($m[0]->stato == CO_MONTA){ ?>
                                                <a class="smonta btn btn-small btn-danger nascosto" onclick="$('.smonta').hide(500); $('.monta').hide(500); $('.visualizza').hide(500);  $('.m1').toggle(500);" href="?p=co.attivita.ok&v=<?php echo $partecipante->volontario(); ?>&t=<?php echo $turno; ?>&smonta" title="Smonta">
                                                    <i class="icon-arrow-down"></i> Smonta
                                                </a>
                                                <div class="m1 alert alert-block alert-success nascosto">
                                                    <h4><i class="icon-warning-sign"></i> <strong>Attendere...</strong>.</h4>
                                                </div>
                                           <?php } ?>
                                       </div>
                                   </td>
                                </tr>
        <?php }}}}?>
        </table>
    </div>
</div>