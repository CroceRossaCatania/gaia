<?php
/*
 * ©2013 Croce Rossa Italiana
 */
paginaSupporto();
?>
<?php if ( isset($_GET['new']) ) { ?>
<div class="alert alert-success">
    <i class="icon-save"></i> <strong>Titolo aggiunto</strong>.
    Il titolo è stato aggiunto con successo.
</div>
<?php } elseif ( isset($_GET['del']) )  { ?>
<div class="alert alert-block alert-error">
 <i class="icon-exclamation-sign"></i> <strong>Titolo cancellato</strong>
 Il titolo è stato cancellato con successo.
</div>
<?php }elseif ( isset($_GET['dup']) ) { ?>
<div class="alert alert-error">
    <i class="icon-warning-sign"></i> <strong>Titolo presente</strong>.
    Il titolo è già presente in elenco.
</div>
<?php } elseif ( isset($_GET['mod']) )  { ?>
<div class="alert alert-block alert-success">
 <i class="icon-edit"></i> <strong>Titolo modificato</strong>
 Il titolo è stato modificato con successo.
</div>
<?php } ?>
<?php if (isset($_GET['err'])) { ?>
<div class="alert alert-block alert-error">
    <h4><i class="icon-warning-sign"></i> <strong>Qualcosa non ha funzionato</strong>.</h4>
    <p>L'operazione che stavi tentando di eseguire non è andata a buon fine. Per favore riprova.</p>
</div> 
<?php } ?>
<script type="text/javascript"><?php require './assets/js/presidente.utenti.js'; ?></script>
<br/>
<div class="row-fluid">
    <div class="span8">
        <h2>
            <i class="icon-certificate muted"></i>
            Elenco Titoli
        </h2>
    </div>
    
    <div class="span4 allinea-destra">
        <div class="input-prepend">
            <span class="add-on"><i class="icon-search"></i></span>
            <input autofocus required id="cercaUtente" placeholder="Cerca Titolo..." type="text">
        </div>
    </div>  
    <br/>  
  
</div>

<hr />

<div class="row-fluid">
 <div class="span12">
     <table class="table table-striped table-bordered table-condensed" id="tabellaUtenti">
        <thead>
            <th>Nome</th>
            <th>Tipo</th>
            <th>Azioni</th>
        </thead>
        <?php
        foreach(Titolo::elenco('nome ASC') as $c){
            ?>
            <tr>
                <td><?php echo $c->nome; ?></td>
                <td><?php echo($conf['titoli'][$c->tipo][0]); ?></td>
              
            </tr>
            
            
            
            <?php }
            
            ?>
        </table>

    </div>
    
</div>
