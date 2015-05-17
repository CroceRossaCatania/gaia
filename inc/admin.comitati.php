<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

?>

<?php if ( isset($_GET['new']) ) { ?>
<div class="alert alert-success">
    <i class="icon-save"></i> <strong>Comitato aggiunto</strong>.
    Il Comitato è stato aggiunto con successo.
</div>
<?php } elseif ( isset($_GET['del']) )  { ?>
<div class="alert alert-block alert-error">
 <i class="icon-exclamation-sign"></i> <strong>Comitato cancellato</strong>
 Il Comitato è stato cancellato con successo.
</div>
<?php }elseif ( isset($_GET['dup']) ) { ?>
<div class="alert alert-error">
    <i class="icon-warning-sign"></i> <strong>Comitato presente</strong>.
    Il Comitato è già presente in elenco.
</div>
<?php }elseif ( isset($_GET['figli']) ) { ?>
<div class="alert alert-error">
    <i class="icon-warning-sign"></i> <strong>Comitati correlati</strong>.
    Attenzione il Comitato che si vuole cancellare ha dei comitati sottostanti, rimuoverli e riprovare.
</div>
<?php }elseif ( isset($_GET['evol']) ) { ?>
    <div class="alert alert-error">
        <i class="icon-warning-sign"></i> <strong>Volontari correlati</strong>.
        Attenzione il Comitato che si vuole cancellare ha dei Volontari appartenenti ad esso, rimuoverli e riprovare.
    </div>
<?php }elseif ( isset($_GET['quota']) ) { ?>
    <div class="alert alert-error">
        <i class="icon-warning-sign"></i> <strong>Quote correlate</strong>.
        Attenzione il Comitato che si vuole cancellare ha delle quote correlate, rimuoverle e riprovare.
    </div>
<?php } elseif ( isset($_GET['spostato']) ) { ?>
        <div class="alert alert-success">
            <i class="icon-save"></i> <strong>Comitato spostato con successo</strong>.
            Il Comitato è stato spostato con successo, l'albero è stato bruciato
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

<?php

function pulsanteAttivo($geopolitica) { 
    if ( $geopolitica->attivo ) {
        ?>
        <i class="icon-check text-success"></i> Attivo 
        (<a href="?p=admin.comitati.attivazione&oid=<?= $geopolitica->oid(); ?>" data-conferma="DISATTIVAZIONE: Questa operazione verr&agrave; effettuata sul comitato e tutti i figli.">Disattiva</a>)
        <?php 
    } else {
        ?>
        <i class="icon-check-empty text-warning"></i> Disattivo
        (<a href="?p=admin.comitati.attivazione&oid=<?= $geopolitica->oid(); ?>" data-conferma="ATTIVAZIONE: Questa operazione verr&agrave; effettuata sul comitato e tutti i figli.">Disattiva</a>)
        <?php
    }


} 

?>

<div class="row-fluid">
    <div class="span8">
        <h2>
            <i class="icon-bookmark muted"></i>
            Elenco Comitati
        </h2>
    </div>
    
    <div class="span4 allinea-destra">
        <div class="input-prepend">
            <span class="add-on"><i class="icon-search"></i></span>
            <input autofocus required id="cercaUtente" placeholder="Cerca Comitato..." type="text">
        </div>
    </div>  
</div> 
<hr />
<div class="row-fluid">
 <div class="span12">
     <table class="table table-striped table-bordered table-condensed" id="tabellaUtenti">
        <thead>
            <th>Nome</th>
            <th>Azioni</th>
            <th>Attivo?</th>
        </thead>
        <?php
        foreach ( Nazionale::elenco() as $nazionale ){
            ?>
            <tr>
                <td colspan="5"><strong><?php echo $nazionale->nome; ?></strong></td>
                <td>
                    <div class="ex-btngroup">
                        <a class="ex-btnmini" href="?p=presidente.comitato&oid=<?php echo $nazionale->oid(); ?>" title="Dettagli">
                            <i class="icon-eye-open"></i> Dettagli
                        </a>
                        <a class="ex-btnmini btn-success" href="?p=admin.comitato.nuovo&id=<?php echo $nazionale->id; ?>&t=regi" title="Nuovo">
                            <i class="icon-plus"></i> Nuovo
                        </a>
                    </div>
                </td>
                <td><?php pulsanteAttivo($nazionale); ?></td>
            </tr>
            <?php foreach ( $nazionale->regionali() as $regionale ) { ?>
            <tr class="success">
                <td></td>
                <td colspan="4" border-left="none"><?php echo $regionale->nome; ?></td>
                <td>
                    <div class="ex-btngroup">
                        <a class="ex-btnmini" href="?p=presidente.comitato&oid=<?php echo $regionale->oid(); ?>" title="Dettagli">
                            <i class="icon-eye-open"></i> Dettagli
                        </a>    
                        <a class="ex-btnmini btn-info" href="?p=admin.comitato.modifica&oid=<?php echo $regionale->oid(); ?>" title="Modifica">
                            <i class="icon-edit"></i> Modifica
                        </a>
                        <a class="ex-btnmini btn-success" href="?p=admin.comitato.nuovo&id=<?php echo $regionale->id; ?>&t=pro" title="Nuovo">
                            <i class="icon-plus"></i> Nuovo
                        </a>
                        <a  onClick="return confirm('Vuoi veramente cancellare questo comitato ? Assicurati che non vi siano comitati o volontari correlati a questo!!!');" href="?p=admin.comitato.cancella&oid=<?php echo $regionale->oid(); ?>" title="Cancella Regionale" class="ex-btnmini btn-danger">
                            <i class="icon-trash"></i> Cancella
                        </a>
                    </div>
                </td>
                <td><?php pulsanteAttivo($regionale); ?></td>
            </tr>
            <?php foreach ( $regionale->provinciali() as $provinciale ) { ?>
            <tr class="error">
                <td></td><td></td>
                <td colspan="3"><?php echo $provinciale->nome; ?></td>
                <td>
                    <div class="ex-btngroup">
                        <a class="ex-btnmini" href="?p=presidente.comitato&oid=<?php echo $provinciale->oid(); ?>" title="Dettagli">
                            <i class="icon-eye-open"></i> Dettagli
                        </a>  
                        <a class="ex-btnmini btn-info" href="?p=admin.comitato.modifica&oid=<?php echo $provinciale->oid(); ?>" title="Modifica">
                            <i class="icon-edit"></i> Modifica
                        </a>
						<a class="ex-btnmini btn-warning" href="?p=admin.comitato.sposta&oid=<?php echo $provinciale->oid(); ?>" title="Sposta">
                            <i class="icon-arrow-right"></i> Sposta
                        </a>
                        <a class="ex-btnmini btn-success" href="?p=admin.comitato.nuovo&id=<?php echo $provinciale->id; ?>&t=loc" title="Nuovo">
                            <i class="icon-plus"></i> Nuovo
                        </a> 
                        <a  onClick="return confirm('Vuoi veramente cancellare questo comitato ? Assicurati che non vi siano comitati o volontari correlati a questo!!!');" href="?p=admin.comitato.cancella&oid=<?php echo $provinciale->oid(); ?>" title="Cancella Provinciale" class="ex-btnmini btn-danger">
                            <i class="icon-trash"></i> Cancella
                        </a>
                    </div>
                </td>
                <td><?php pulsanteAttivo($provinciale); ?></td>
            </tr>
            <?php foreach ( $provinciale->locali() as $locale ) { ?>
            <tr class="alert">
                <td></td><td></td><td></td>
                <td colspan="2">
                    <?php echo $locale->nome; ?>

                    <?php if ( !$locale->principale() ) { ?>
                    &nbsp; &nbsp; <span class="text-error">
                    <i class="icon-warning-sign"></i>
                    Nessuna unita' principale selezionata!
                </span>
                <?php } ?>

            </td>
            <td>
                <div class="ex-btngroup">
                    <a class="ex-btnmini" href="?p=presidente.comitato&oid=<?php echo $locale->oid(); ?>" title="Dettagli">
                        <i class="icon-eye-open"></i> Dettagli
                    </a>     
                    <a class="ex-btnmini btn-info" href="?p=admin.comitato.modifica&oid=<?php echo $locale->oid(); ?>" title="Modifica">
                        <i class="icon-edit"></i> Modifica
                    </a>
					<a class="ex-btnmini btn-warning" href="?p=admin.comitato.sposta&oid=<?php echo $locale->oid(); ?>" title="Sposta">
                        <i class="icon-arrow-right"></i> Sposta
                    </a>
                    <a class="ex-btnmini btn-success" href="?p=admin.comitato.nuovo&id=<?php echo $locale->id; ?>&t=com" title="Nuovo">
                        <i class="icon-plus"></i> Nuovo
                    </a> 
                    <a  onClick="return confirm('Vuoi veramente cancellare questo comitato ? Assicurati che non vi siano comitati o volontari correlati a questo!!!');" href="?p=admin.comitato.cancella&oid=<?php echo $locale->oid(); ?>" title="Cancella Locale" class="ex-btnmini btn-danger">
                        <i class="icon-trash"></i> Cancella
                    </a>
                </div>
            </td>
            <td><?php pulsanteAttivo($locale); ?></td>
        </tr>
        <?php foreach ( $locale->comitati() as $comitato ) { ?>
        <tr class="info">
            <td></td><td></td><td></td><td></td>
            <td colspan="1">
                
                <?php if ( $comitato->principale ) { ?>
                <i class="icon-star text-error"></i>
                <?php } else { ?>
                <a href="?p=admin.comitato.principale&id=<?php echo $comitato; ?>">
                    <i class="icon-star-empty"></i>
                </a>
                <?php } ?>

                <?php echo $comitato->nome; ?>

            </td>
            <td>
                <div class="ex-btngroup">
                    <a class="ex-btnmini" href="?p=presidente.comitato&oid=<?php echo $comitato->oid(); ?>" title="Dettagli">
                        <i class="icon-eye-open"></i> Dettagli
                    </a>      
                    <a class="ex-btnmini btn-info" href="?p=admin.comitato.modifica&oid=<?php echo $comitato->oid(); ?>" title="Modifica">
                        <i class="icon-edit"></i> Modifica
                    </a>
 					<a class="ex-btnmini btn-warning" href="?p=admin.comitato.sposta&oid=<?php echo $comitato->oid(); ?>" title="Sposta">
                    	<i class="icon-arrow-right"></i> Sposta
                    </a>
                    <a  onClick="return confirm('Vuoi veramente cancellare questo comitato ? Assicurati che non vi siano comitati o volontari correlati a questo!!!');" href="?p=admin.comitato.cancella&oid=<?php echo $comitato->oid(); ?>" title="Cancella Comitato" class="ex-btnmini btn-danger">
                        <i class="icon-trash"></i> Cancella
                    </a>
                </div>
            </td>
            <td><?php pulsanteAttivo($comitato); ?></td>
        </tr>
        <?php }}}}}
        
        ?>
    </table>

</div>

</div>


