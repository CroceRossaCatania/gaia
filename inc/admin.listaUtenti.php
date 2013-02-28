<?php

/*
 * ©2012 Croce Rossa Italiana
 */

?>
<?php if ( isset($_GET['ok']) ) { ?>
        <div class="alert alert-success">
            <i class="icon-save"></i> <strong>Utente eliminato</strong>.
            L'utente è stato eliminato con successo.
        </div>
<?php } elseif ( isset($_GET['e']) )  { ?>
        <div class="alert alert-block alert-error">
            <h4><i class="icon-exclamation-sign"></i> Impossibile eliminare l'utente</h4>
            <p>Contatta l'amministratore</p>
        </div>
<?php } ?>
    <br/>
<div class="row-fluid">
    <div class="span8">
        <h2>
            <i class="icon-group muted"></i>
            Elenco volontari
        </h2>
    </div>
    
    <div class="span4 allinea-destra">
        <div class="input-prepend">
            <span class="add-on"><i class="icon-search"></i></span>
            <input autofocus required id="cercaUtente" placeholder="Cerca utente..." type="text">
        </div>
    </div>    
</div>
    
<hr />
    
<div class="row-fluid">
   <div class="span12">
       <table class="table table-striped table-bordered table-condensed" id="tabellaUtenti">
            <thead>
                <th>Nome</th>
                <th>Cognome</th>
                <th>Località</th>
                <th>Cellulare</th>
                <th>Azioni</th>
            </thead>
        <?php
        if( $me->presiede() ) {
            $app = $me->presidenziante();
            $elenco = [];
            foreach ($app as $_app) {
                $elenco[] = $_app->comitato();
            }
            $elenco = array_unique($elenco);
        } elseif ( $me->admin ) {
            $elenco = Comitato::elenco('nome ASC');
        }
        
        foreach($elenco as $comitato) {
            $t = Appartenenza::filtra([['comitato', $comitato->id]]);
                ?>
            
            <tr class="success">
                <td colspan="7" class="grassetto">
                    <?php echo $comitato->nome; ?>
                    <span class="label label-warning">
                        <?php echo count($t); ?>
                    </label>
                </td>
            </tr>
            
            <?php
            foreach ( $t as $_t ) {
                $_v = $_t->volontario();   // Una volta per tutte 
                $s = $_t->stato;
            ?>
                <tr>
                    <td><?php echo $_v->nome; ?></td>
                    <td><?php echo $_v->cognome; ?></td>
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

                    <td class="btn-group">
                        <a class="btn btn-small" href="?p=admin.visualizzamodificaUtente&id=<?php echo $_v->id; ?>" title="Dettagli">
                            <i class="icon-eye-open"></i> Dettagli
                        </a>            
                        <a  onClick="return confirm('Vuoi veramente cancellare questo utente ?');" href="?p=cancellaUtente&id=<?php echo $_v->id; ?>" title="Cancella Utente" class="btn btn-small btn-warning">
                            <i class="icon-trash"></i> Cancella
                        </a>

                        <?php if ($me->admin) { ?>
                            <a class="btn btn-small btn-primary" href="?p=admin.newPresidente&id=<?php echo $x->id; ?>" title="Nomina Presidente">
                                <i class="icon-star"></i>
                            </a> 
                            <a class="btn btn-small btn-danger" href="?p=admin.admin&id=<?php echo $x->id; ?>" title="Nomina Admin">
                                <i class="icon-magic"></i>
                            </a>
                        <?php } ?>
                   </td>
                </tr>
                
               
       
        <?php }
        }
        ?>

        
        </table>

    </div>
    
</div>
