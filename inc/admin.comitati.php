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
<?php } ?>
<script type="text/javascript"><?php require './js/presidente.utenti.js'; ?></script>
    <br/>
    
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
            </thead>
        <?php
       foreach ( Nazionale::elenco() as $nazionale ){
                ?>
                  <tr>
                    <td colspan="5"><strong><?php echo $nazionale->nome; ?></strong></td>
                    <td class="btn-group">
                        <a class="btn btn-small" href="?p=presidente.wizard&id=<?php echo $c->id; ?>" title="Dettagli">
                            <i class="icon-eye-open"></i> Dettagli
                        </a>
                        <a  onClick="return confirm('Vuoi veramente cancellare questo comitato ?');" href="?p=admin.comitato.cancella&id=<?php echo $nazionale->id; ?>&naz" title="Cancella Comitato" class="btn btn-small btn-warning">
                            <i class="icon-trash"></i> Cancella
                        </a>
                        <a class="btn btn-small btn-success" href="?p=admin.comitato.nuovo&id=<?php echo $nazionale->id; ?>&t=regi" title="Nuovo">
                            <i class="icon-plus"></i> Nuovo
                        </a>  
                   </td>
                </tr>
                <?php foreach ( $nazionale->regionali() as $regionale ) { ?>
                <tr class="success">
                    <td></td>
                    <td colspan="4" border-left="none"><?php echo $regionale->nome; ?></td>
                        <td class="btn-group">
                            <a class="btn btn-small" href="?p=presidente.wizard&id=<?php echo $c->id; ?>" title="Dettagli">
                                <i class="icon-eye-open"></i> Dettagli
                            </a>            
                            <a  onClick="return confirm('Vuoi veramente cancellare questo comitato ?');" href="?p=admin.comitato.cancella&id=<?php echo $regionale->id; ?>&regi" title="Cancella Comitato" class="btn btn-small btn-warning">
                                <i class="icon-trash"></i> Cancella
                            </a>
                            <a class="btn btn-small btn-success" href="?p=admin.comitato.nuovo&id=<?php echo $regionale->id; ?>&t=pro" title="Nuovo">
                                <i class="icon-plus"></i> Nuovo
                            </a> 
                        </td>
                </tr>
                <?php foreach ( $regionale->provinciali() as $provinciale ) { ?>
                <tr class="error">
                    <td></td><td></td>
                    <td colspan="3"><?php echo $provinciale->nome; ?></td>
                        <td class="btn-group">
                            <a class="btn btn-small" href="?p=presidente.wizard&id=<?php echo $c->id; ?>" title="Dettagli">
                                <i class="icon-eye-open"></i> Dettagli
                            </a>            
                            <a  onClick="return confirm('Vuoi veramente cancellare questo comitato ?');" href="?p=admin.comitato.cancella&id=<?php echo $provinciale->id; ?>&pro" title="Cancella Comitato" class="btn btn-small btn-warning">
                                <i class="icon-trash"></i> Cancella
                            </a>
                            <a class="btn btn-small btn-success" href="?p=admin.comitato.nuovo&id=<?php echo $provinciale->id; ?>&t=loc" title="Nuovo">
                                <i class="icon-plus"></i> Nuovo
                            </a> 
                       </td>
                </tr>
                <?php foreach ( $provinciale->locali() as $locale ) { ?>
                <tr class="alert">
                    <td></td><td></td><td></td>
                    <td colspan="2"><?php echo $locale->nome; ?></td>
                        <td class="btn-group">
                            <a class="btn btn-small" href="?p=presidente.wizard&id=<?php echo $c->id; ?>" title="Dettagli">
                                <i class="icon-eye-open"></i> Dettagli
                            </a>            
                            <a  onClick="return confirm('Vuoi veramente cancellare questo comitato ?');" href="?p=admin.comitato.cancella&id=<?php echo $locale->id; ?>&loc" title="Cancella Comitato" class="btn btn-small btn-warning">
                                <i class="icon-trash"></i> Cancella
                            </a>
                            <a class="btn btn-small btn-success" href="?p=admin.comitato.nuovo&id=<?php echo $locale->id; ?>&t=com" title="Nuovo">
                                <i class="icon-plus"></i> Nuovo
                            </a> 
                       </td>
                </tr>
                <?php foreach ( $locale->comitati() as $comitato ) { ?>
                <tr class="info">
                    <td></td><td></td><td></td><td></td>
                    <td colspan="1"><?php echo $comitato->nome; ?></td>
                        <td class="btn-group">
                            <a class="btn btn-small" href="?p=presidente.wizard&id=<?php echo $c->id; ?>" title="Dettagli">
                                <i class="icon-eye-open"></i> Dettagli
                            </a>            
                            <a  onClick="return confirm('Vuoi veramente cancellare questo comitato ?');" href="?p=admin.comitato.cancella&id=<?php echo $comitato->id; ?>&com" title="Cancella Comitato" class="btn btn-small btn-warning">
                                <i class="icon-trash"></i> Cancella
                            </a>
                       </td>
                </tr>
        <?php }}}}}
        
        ?>
        </table>

    </div>
    
</div>


