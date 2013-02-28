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
    <div class="control-group" align="right">
        <div class="controls">
            <div class="input-prepend">
                <span class="add-on"><i class="icon-search"></i></span>
                <input autofocus data-t="<?php echo $t; ?>" required id="cercaUtente" placeholder="Cerca utente..." class="span4" type="text">
            </div>
        </div>
    </div>    

<div class="row-fluid">
   <div class="span12">
       <table class="table table-striped table-bordered table-condensed" id="tabellaUtenti">
            <thead>
                <th>#</th>
                <th>Nome</th>
                <th>Cognome</th>
                <th>Email</th>
                <th>Cell</th>
                <th>Località</th>
                <th>Azioni</th>
            </thead>
        <?php
        if( $me->presiede() ){
            foreach($me->presidenziante() as $appartenenza){
                $c=$appartenenza->comitato()->id;
                $t = Appartenenza::filtra([['comitato',$c]]);
                ?>
            
            <tr class="success"><td colspan="7" class="grassetto"><?php echo $t[0]->comitato()->nome; ?> <span class="label label-warning"><?php echo count($t); ?></label></td></tr>
            
            <?php
          foreach ( $t as $_t ) {
           $_v = $_t->volontario();   // Una volta per tutte           
           $s=$_t->stato;
           if($s!= 4){?>
                <tr>
                <td><?php echo $_v->id; ?></td>
                <td><?php echo $_v->nome; ?></td>
                <td><?php echo $_v->cognome; ?></td>
                <td><code><?php echo $_v->email; ?></td>
                <td><span class="muted">+39</span> <?php echo $_v->cellulare; ?></td>
                <td><?php echo $x->CAPResidenza; ?> <?php echo $_v->comuneResidenza; ?>, <?php echo $_v->provinciaResidenza; ?></td>
                <td>
                <div class="btn-group">
                    <a class="btn btn-small" href="?p=admin.visualizzamodificaUtente&id=<?php echo $_v->id; ?>" title="Dettagli">
                        <i class="icon-eye-open"></i>
                    </a>            
                    <a  onClick="return confirm('Vuoi veramente cancellare questo utente ?');" href="?p=cancellaUtente&id=<?php echo $_v->id; ?>" title="Cancella Utente" class="btn btn-small btn-danger">
                        <i class="icon-trash"></i>
                    </a>
               </div>
               </td>
            </tr>
                
        
        <?php }}}}elseif($me->admin()){ 
            foreach ( Persona::elenco('timestamp DESC') as $x ) { ?>
            <tr>
                <td><?php echo $x->id; ?></td>
                <td><?php echo $x->nome; ?></td>
                <td><?php echo $x->cognome; ?></td>
                <td><code><?php echo $x->email; ?></td>
                <td><span class="muted">+39</span> <?php echo $x->cellulare; ?></td>
                <td><?php echo $x->CAPResidenza; ?> <?php echo $x->comuneResidenza; ?>, <?php echo $x->provinciaResidenza; ?></td>
                <td class="btn-group">
                    <div class="btn-group">
                <div class="btn-group">
                    <a class="btn" href="?p=admin.visualizzamodificaUtente&id=<?php echo $x->id; ?>" title="Dettagli">
                        <i class="icon-eye-open"></i>
                    </a>            
                    <a  onClick="return confirm('Vuoi veramente cancellare questo utente ?');" href="?p=cancellaUtente&id=<?php echo $x->id; ?>" title="Cancella Utente" class="btn btn-danger">
                        <i class="icon-trash"></i>
                    </a>
               </div>
               <div class="btn-group">
               <a class="btn" href="?p=admin.newPresidente&id=<?php echo $x->id; ?>" title="Nomina Presidente">
                        <i class="icon-star"></i>
               </a> 
               <a class="btn" href="?p=admin.admin&id=<?php echo $x->id; ?>" title="Nomina Admin">
                        <i class="icon-user"></i>
               </a> 
               </div>
                    </div>
               </td>
            </tr>
               
       
        <?php }} ?>

        
        </table>

    </div>
    
</div>
