<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);

?>
<script type="text/javascript"><?php require './js/presidente.utenti.js'; ?></script>
<?php if ( isset($_GET['ok']) ) { ?>
        <div class="alert alert-success">
            <i class="icon-save"></i> <strong>Quota registrata</strong>.
            La quota è stata registrata.
        </div>
<?php }elseif ( isset($_GET['close']) ) { ?>
        <div class="alert alert-success">
            <i class="icon-remove"></i> <strong>Quote annuali chiuse</strong>.
            Anno chiuso.
        </div>
<?php }elseif ( isset($_GET['gia']) ) { ?>
        <div class="alert alert-danger">
            <i class="icon-remove"></i> <strong>Quota già pagata</strong>.
            La quota del volontario risulta già pagata.
        </div>
<?php }elseif ( isset($_GET['err']) ) { ?>
        <div class="alert alert-danger">
            <i class="icon-remove"></i> <strong>Tesseramento non attivo</strong>.
            Al momento non è possibile registrare altre quote.
        </div>
<?php }
    $questanno = $anno = date('Y', time());
    if (!isset($_POST['anno'])) {
        $anno = $questanno;
    } else {
        $anno = $_POST['anno'];
        if ($anno < 2005 || $anno > (int) $questanno) {
            redirect('us.quoteNo');
        }
    } 
    if ($anno == $questanno) {
        $registraOk = true;
    }
    

    $t = Tesseramento::by('anno', $anno);
    $accettaPagamenti = false;
    if ($t)
        $accettaPagamenti = $t->accettaPagamenti();
    ?>
    <br/>
<div class="row-fluid">
    <div class="span4 allinea-sinistra">
        <h2>
            <i class="icon-group muted"></i>
            Quote non pagate
        </h2>
    </div>
            
   <div class="span4">
        <div class="btn-group btn-group-vertical">
            <div class="btn-group">
                <a href="#" class="btn btn-success btn-group">
                    <i class="icon-ok"></i>
                    Quote Pagate
                </a>
                <a class="btn btn-success dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="?p=us.quoteSi"><i class="icon-ok"></i> Volontari</a></li>
                    <li><a href="?p=us.quoteSi.ordinari"><i class="icon-ok"></i> Soci Ordinari</a></li>
                </ul>
            </div>
            <div class="btn-group">
                <a href="#" class="btn btn-danger btn-group">
                    <i class="icon-ok"></i>
                    Quote non pagate
                </a>
                <a class="btn btn-danger dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="?p=us.quoteNo"><i class="icon-ok"></i> Volontari</a></li>
                    <li><a href="?p=us.quoteNo.ordinari"><i class="icon-ok"></i> Soci Ordinari</a></li>
                </ul>
            </div>
            <a href="?p=us.dash" class="btn btn-block">
                <i class="icon-reply"></i>
                Torna alla dash
            </a>
        </div>
    </div>
    
    <div class="span4 allinea-destra">
        <div class="input-prepend">
            <span class="add-on"><i class="icon-search"></i></span>
            <input autofocus required id="cercaUtente" placeholder="Cerca Volontario..." type="text">
        </div>
       <form action="?p=us.quoteNo" method="POST">
        <div class="form-search">
            <span class="add-on"><i class="icon-calendar"></i></span>
            <input class="input-medium" autocomplete="off" name="anno" type="number" min="2005" max="<?php echo date('Y'); ?>" step="1" value="<?php echo $anno; ?>">
            <button class="btn btn-info" type="submit" ><i class="icon-search"></i>
            </button>
        </div>
        </form>
    </div>    
</div>
    
<hr />

<div class="row-fluid">
    <div class="alert alert-info">
    <p><i class="icon-warning-sign"></i> È possibile registrare i pagamenti solo se 
    il <strong>Codice Fiscale</strong> e la <strong>Partita Iva</strong> sono stati inseriti.<br />
    L'inserimento deve essere effettuato dal presidente del comitato nella scermata di inserimento
    dei dati del comitato.</p>
    </div>
</div>
    
<div class="row-fluid">
   <div class="span12">
       <div class="btn-group btn-group-vertical span12">
       <?php if ( count($me->comitatiApp ([ APP_SOCI, APP_PRESIDENTE ])) > 1 ) { ?>
       <a href="?p=admin.utenti.excel&quoteno" class="btn btn-block btn-inverse" data-attendere="Generazione e compressione in corso...">
           <i class="icon-download"></i>
            <strong>Ufficio Soci</strong> &mdash; Scarica tutti i fogli dei volontari che non hanno versato la quota in un archivio zip.
       </a>
       <?php } ?>
       <a href="?p=utente.mail.nuova&comquoteno" class="btn btn-block btn-success">
           <i class="icon-envelope"></i>
            <strong>Ufficio Soci</strong> &mdash; Invia mail di massa a tutti i Volontari.
       </a>
       <?php if ($t->siPuoDimettereTutti()) { ?>
       <a onClick="return confirm('Vuoi veramente chiudere le quote per anno corrente? questa operazione non è reversibile !');" href="?p=us.quote.chiudi" class="btn btn-block btn-danger">
           <i class="icon-off"></i>
            <strong>Ufficio Soci</strong> &mdash; Chiudi le quote per l'anno corrente
       </a>
       <?php } ?>
       <hr />
       </div>
       
       <table class="table table-striped table-bordered table-condensed" id="tabellaUtenti">
            <thead>
                <th>Cognome</th>
                <th>Nome</th>
                <th>Località</th>
                <th>Cellulare</th>
                <th>Azioni</th>
            </thead>
        <?php
        $elenco = $me->comitatiApp ([ APP_SOCI, APP_PRESIDENTE ]);
        foreach($elenco as $comitato) {
            $t = $comitato->quoteNo($anno , MEMBRO_ORDINARIO);
            $fiscali = true;
            if (!$comitato->cf() || !$comitato->piva()) {
                $fiscali = false;
            }
                ?>
            
            <tr class="success">
                <td colspan="5" class="grassetto">
                    <?php echo $comitato->nomeCompleto(); ?>
                    <span class="label label-warning">
                        <?php echo count($t); ?>
                    </span>
                    <a class="btn btn-success btn-small pull-right" href="?p=utente.mail.nuova&id=<?php echo $comitato->id; ?>&unitquoteno">
                           <i class="icon-envelope"></i> Invia mail
                    </a>
                    <a class="btn btn-small pull-right" 
                       href="?p=presidente.utenti.excel&quoteno&comitato=<?php echo $comitato->id; ?>"
                       data-attendere="Generazione...">
                            <i class="icon-download"></i> scarica come foglio excel
                    </a>
                </td>
            </tr>
            
            <?php
            foreach ( $t as $_v ) {
            ?>
                <tr>
                    <td><?php echo $_v->cognome; ?></td>
                    <td><?php echo $_v->nome; ?></td>
                    <td>
                        <span class="muted">
                            <?php echo $_v->CAPResidenza; ?>
                        </span>
                        <?php echo $_v->comuneResidenza; ?>,
                        <?php echo $_v->provinciaResidenza; ?>
                    </td>
                    
                    <td>
                        <span class="muted">+39</span>
                            <?php echo $_v->cellulare; ?>
                    </td>

                    <td>
                        <div class="btn-group">
                            <?php if($registraOk && $accettaPagamenti && $fiscali) { ?>
                            <a class="btn btn-small btn-info" href="?p=us.quote.nuova&id=<?php echo $_v->id; ?>" title="Paga quota">
                                <i class="icon-certificate"></i> Registra
                            </a>
                            <?php } ?>
                            <a class="btn btn-small btn-success" href="?p=utente.mail.nuova&id=<?php echo $_v->id; ?>" title="Invia Mail">
                                <i class="icon-envelope"></i>
                            </a>
                        </div>
                   </td>
                </tr>
                
               
       
        <?php }
        }
        ?>

        </table>
       
    </div>
    
</div>
