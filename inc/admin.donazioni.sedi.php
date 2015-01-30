<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

?>
<?php if ( isset($_GET['new']) ) { ?>
<div class="alert alert-success">
    <i class="icon-save"></i> <strong>Sede aggiunta</strong>.
    La sede è stata aggiunta con successo.
</div>
<?php } elseif ( isset($_GET['del']) )  { ?>
<div class="alert alert-block alert-error">
 <i class="icon-exclamation-sign"></i> <strong>Sede cancellata</strong>
 La sede è stata cancellata con successo.
</div>
<?php }elseif ( isset($_GET['dup']) ) { ?>
<div class="alert alert-error">
    <i class="icon-warning-sign"></i> <strong>Sede presente</strong>.
    La sede è già presente in elenco.
</div>
<?php } elseif ( isset($_GET['mod']) )  { ?>
<div class="alert alert-block alert-success">
 <i class="icon-edit"></i> <strong>Sede modificata</strong>
 La sede è stata modificata con successo.
</div>
<?php } ?>
<?php if (isset($_GET['err'])) { ?>
<div class="alert alert-block alert-error">
    <h4><i class="icon-warning-sign"></i> <strong>Qualcosa non ha funzionato</strong>.</h4>
    <p>L'operazione che stavi tentando di eseguire non è andata a buon fine. Per favore riprova.</p>
</div> 
<?php } ?>
<br/>
<div class="row-fluid">
    <div class="span8">
        <h2>
            <i class="icon-certificate muted"></i>
            Elenco Donazioni sedi
        </h2>
    </div>
    
    <div class="span4 allinea-destra">
        <div class="input-prepend">
            <span class="add-on"><i class="icon-search"></i></span>
            <input autofocus required id="cercaUtente" placeholder="Cerca Donazione..." type="text">
        </div>
    </div>  
    <br/>  
    <div class="span4 allinea-destra">
        <a class="btn btn-success" href="?p=admin.donazione.sede.nuovo">
            <i class="icon-plus"></i> Aggiungi sede
        </a>
    </div> 
</div>

<hr />

<div class="row-fluid">
 <div class="span12">
     <table class="table table-striped table-bordered table-condensed" id="tabellaUtenti">
        <thead>
            <th>Nome</th>
            <th>Tipo</th>
            <th>Provincia</th>
            <th>Regione</th>
            <th>Azioni</th>
        </thead>
        <?php
        foreach(DonazioneSede::elenco('provincia ASC') as $c){
            ?>
            <tr>
                <td><?php echo $c->nome; ?></td>
                <td><?php echo($conf['donazioni'][$c->tipo][0]); ?></td>
                <td><?php echo $c->provincia; ?></td>
                <td><?php echo $c->regione; ?></td>
                <td>
                    <div class="btn-group">
                        <a  onClick="return confirm('Vuoi veramente cancellare questa sede ?');" href="?p=admin.donazione.sedi.cancella&id=<?php echo $c->id; ?>" title="Cancella sede" class="btn btn-small btn-warning">
                            <i class="icon-trash"></i> Cancella
                        </a>
                        <a  href="?p=admin.donazione.sedi.modifica&id=<?php echo $c->id; ?>" title="Modifica sede" class="btn btn-small btn-info">
                            <i class="icon-edit"></i> Modifica
                        </a>
                    </div>
                </td>
            </tr>
            
            
            
            <?php }
            
            ?>
        </table>

    </div>
    
</div>


