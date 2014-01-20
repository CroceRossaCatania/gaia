<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);

?>
<script type="text/javascript"><?php require './js/presidente.utenti.js'; ?></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.9/angular.min.js"></script>
<?php if ( isset($_GET['ok']) ) { ?>
        <div class="alert alert-success">
            <i class="icon-save"></i> <strong>Quota registrata</strong>.
            La quota è stata registrata.
        </div>
<?php }elseif ( isset($_GET['no']) ) { ?>
        <div class="alert alert-success">
            <i class="icon-remove"></i> <strong>Quote annuali chiuse</strong>.
            Anno chiuso.
        </div>
<?php } 

    if (!isset($_POST['anno'])) {
        $anno = date('Y', time());
    } else {
        $anno = $_POST['anno'];
    } ?>

    <br/>
<div class="row-fluid">
    <div class="span4 allinea-sinistra">
        <h2>
            <i class="icon-group muted"></i>
            Quote Pagate
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
        <form action="?p=us.quoteSi.ordinari" method="POST">
        <div class="form-search">
            <span class="add-on"><i class="icon-calendar"></i></span>
            <input class="input-medium" autocomplete="off" name="anno" type="number" min="1990" max="<?php echo date('Y'); ?>" step="1" value="<?php echo $anno; ?>">
            <button class="btn btn-info" type="submit" ><i class="icon-search"></i>
            </button>
        </div>
        </form>
    </div>    
</div>
    
<hr />

<div ng-app>
<div class="row-fluid">
    <div class="span3 allinea-centro">

        <div class="well">
            <i class="icon-certificate"></i> Ad oggi sono state pagate<br />
            <span class="quote_contatore"> {{quote}}</span>
            <br />
            <span class="aspiranti_descrizione">QUOTE</span>
        </div>
    </div>


    <div class="span6 allinea-centro">
        <div class="well">
            <i class="icon-money"></i> Attualmente sono stati raccolti<br />
            <span class="quote_contatore"> {{incasso}} €</span>
            <br />
            <span class="aspiranti_descrizione">DAL TESSERAMENTO</span>
        </div>
    </div>

    <div class="span3 allinea-centro">
        <div class="well">
            <i class="icon-thumbs-up-alt"></i> Attualmente sono presenti<br />
            <span class="quote_contatore"> {{benemeriti}}</span>
            <br />
            <span class="aspiranti_descrizione">BENEMERITI</span>
        </div>
    </div>
</div>



<div class="row-fluid">
   <div class="span12">
       <table class="table table-striped table-bordered table-condensed" id="tabellaUtenti">
            <thead>
                <th>Quota</th>
                <th>Cognome</th>
                <th>Nome</th>
                <th>Codice Fiscale</th>
                <th>Importo</th>
                <th>Data Pagamento</th>
                <th>Azioni</th>
            </thead>
        <?php
        $elenco = $me->comitatiApp ([ APP_SOCI, APP_PRESIDENTE ]);
        $totale = 0;
        $n = 0;
        $ben = 0;
        $t = Tesseramento::by('anno', $anno);
        $aperto = false;
        if ($t && $t->aperto()) {
            $aperto = true;
        }
        foreach($elenco as $comitato) {
            $t = $comitato->quoteSi($anno, MEMBRO_ORDINARIO);
                ?>
            
            <tr class="success">
                <td colspan="7" class="grassetto">
                    <?php echo $comitato->nomeCompleto(); ?>
                    <span class="label label-warning">
                        <?php echo count($t); ?>
                    </span>
                    <a class="btn btn-small pull-right" 
                       href="?p=presidente.utenti.excel&comitato=<?php echo $comitato->id; ?>&quotesi"
                       data-attendere="Generazione...">
                            <i class="icon-download"></i> scarica come foglio excel
                    </a>
                </td>
            </tr>
            
            <?php
            foreach ( $t as $_v ) {
                $n++;
            ?>
                <tr>
                    <td><?php
                            $q = $_v->quota($anno);
                            echo $q->progressivo();
                        ?>
                    </td>
                    <td><?php echo $_v->cognome; ?></td>
                    <td><?php echo $_v->nome; ?></td>
                    <td><?php echo $_v->codiceFiscale; ?></td>
                    
                    <td>
                        <?php 
                            $totale += (float) $q->quota;
                            if ($q->benemerita()) { 
                                $ben++;
                                echo('€ ' . soldi($q->quota)); ?>
                                <i class="icon-thumbs-up-alt"></i> Benemerito
                            <?php    } else { 
                                echo('€ ' . soldi($q->quota));
                             }?>
                    </td>
                    <td><?php echo $q->data()->inTesto(false); ?></td>

                    <td>
                        <div class="btn-group">
                        <a class="btn btn-small btn-info" href="?p=us.quote.visualizza&id=<?php echo $_v->id; ?>" title="Visualizza ricevute">
                            <i class="icon-paperclip"></i> Ricevute
                        </a>
                        <?php if ($aperto || $me->admin()) { ?>
                        <a class="btn btn-small btn-warning" onClick="return confirm('Vuoi veramente annullare questa quota ?');" 
                            href="?p=us.quote.annulla.ok&id=<?php echo $q->id; ?>" title="Annulla quota">
                            <i class="icon-remove"></i> Annulla
                        </a>
                        <?php } if ($me->admin()) {?>
                            <a  onClick="return confirm('Vuoi veramente cancellare questa quota ?');" href="?p=admin.quota.cancella&id=<?php echo $q->id; ?>" title="Cancella Quota" class="btn btn-small btn-danger">
                                <i class="icon-trash"></i>
                            </a>
                        <?php } ?>
                        </div>
                   </td>
                </tr>
        <?php }
        }
        ?>

        </table>
        <input type="hidden" ng-model="quote" ng-init="quote= '<?php echo $n; ?>'">
        <input type="hidden" ng-model="benemeriti" ng-init="benemeriti= '<?php echo $ben; ?>'">
        <input type="hidden" ng-model="incasso" ng-init="incasso= '<?php echo soldi($totale); ?>'">
    </div>
    
</div>
</div>

