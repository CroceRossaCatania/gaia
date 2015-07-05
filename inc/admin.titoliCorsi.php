<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

?>
<?php if ( isset($_GET['new']) ) { ?>
<div class="alert alert-success">
    <i class="icon-save"></i> <strong>Titolo Corso aggiunto</strong>.
    Il corso è stato aggiunto con successo.
</div>
<?php } elseif ( isset($_GET['del']) )  { ?>
<div class="alert alert-block alert-error">
 <i class="icon-exclamation-sign"></i> <strong>Titolo Corso cancellato</strong>
 Il corso è stato cancellato con successo.
</div>
<?php }elseif ( isset($_GET['dup']) ) { ?>
<div class="alert alert-error">
    <i class="icon-warning-sign"></i> <strong>Titolo Corso presente</strong>.
    Il corso è già presente in elenco.
</div>
<?php } elseif ( isset($_GET['mod']) )  { ?>
<div class="alert alert-block alert-success">
 <i class="icon-edit"></i> <strong>Titolo Corso modificato</strong>
 Il titolo corso è stato modificato con successo.
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
            <i class="icon-graduation-cap muted"></i>
            Elenco Titoli Corsi
        </h2>
    </div>
    
    <div class="span4 allinea-destra">
        <div class="input-prepend">
            <span class="add-on"><i class="icon-search"></i></span>
            <input autofocus required id="cercaUtente" placeholder="Cerca Corso..." type="text">
        </div>
    </div>  
    <br/>  
    <div class="span4 allinea-destra">
        <a class="btn btn-success" href="?p=admin.titoloCorso.nuovo">
            <i class="icon-plus"></i> Aggiungi Titolo Corso
        </a>
    </div> 
</div>

<hr />

<div class="row-fluid">
 <div class="span12">
     <table class="table table-striped table-bordered table-condensed" id="tabellaUtenti">
        <thead>
            <th>Nome</th>
            <th>Azioni</th>
        </thead>
        <?php
        foreach(TitoloCorso::elenco('nome ASC') as $c){
            ?>
            <tr>
                <td><?php echo $c->nome; ?></td>
                <td>
                    <div class="btn-group">
                        <a  onClick="return confirm('Vuoi veramente cancellare questo titolo corso ?');" href="?p=admin.titoloCorso.cancella&id=<?php echo $c->id; ?>" title="Cancella Titolo Corso" class="btn btn-small btn-warning">
                            <i class="icon-trash"></i> Cancella
                        </a>
                        <a  href="?p=admin.titoloCorso.modifica&id=<?php echo $c->id; ?>" title="Modifica Titolo Corso" class="btn btn-small btn-info">
                            <i class="icon-edit"></i> Modifica
                        </a>
                    </div>
                </td>
            </tr>
        <?php } ?>
        </table>

    </div>
    
</div>


