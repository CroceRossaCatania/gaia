<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();
?>

<script type="text/javascript"><?php require './js/presidente.utenti.js'; ?></script>
<br/>
    <div class="control-group" align="right">
        <div class="controls">
            <div class="input-prepend">
                <span class="add-on"><i class="icon-search"></i></span>
                <input required id="cercaUtente" placeholder="Cerca utente..." class="span4" type="text">
            </div>
        </div>
    </div> 
<hr />
<table class="table table-striped table-bordered" id="tabellaUtenti">
    <thead>
        <th>#</th>
        <th>Nome</th>
        <th>Cognome</th>
        <th>Codice Fiscale</th>
        <th>Data di Nascita</th>
        <th>Luogo di Nascita</th>
        <th>Comitato</th>
        <th>Azione</th>
    </thead>
<?php
$comitati = [];
if( $me->presiede() ) {
    $k = $me->presidenziante();
    foreach ( $k as $j ) {
        $comitati[] = $j->comitato();
    }
} elseif ( $me->admin ) {
    $comitati = Comitato::elenco();
} else {
    die('Permesso negato.');
}

foreach($comitati as $comitato) {
    foreach ( $comitato->appartenenzePendenti() as $_t ) {
        $_v = $_t->volontario();   // Una volta per tutte
 ?>
    <tr>
        <td><?php echo $_t->id; ?></td>
        <td><?php echo $_v->nome; ?></td>
        <td><?php echo $_v->cognome; ?></td>
        <td><?php echo $_v->codiceFiscale; ?></td>
        <td><?php echo date('d-m-Y', $_v->dataNascita); ?></td> 
        <td><?php echo $_v->comuneNascita; ?></td>
        <td><?php echo $comitato->nome; ?></td>
        <td class="btn-group">
            <a class="btn btn-small" href="?p=admin.visualizzamodificaUtente&id=<?php echo $_v->id; ?>" title="Dettagli">
                            <i class="icon-eye-open"></i> Dettagli
                        </a>    
            <a class="btn btn-success btn-small" href="?p=presidente.appartenenzepending.ok&id=<?php echo $_t->id; ?>&si">
                <i class="icon-ok"></i>
                    Conferma
            </a>
            <a class="btn btn-danger btn-small" onClick="return confirm('Vuoi veramente negare appartenenza a questo utente ?');" href="?p=presidente.appartenenzepending.ok&id=<?php echo $_t->id; ?>&no">
                <i class="icon-ban-circle"></i>
                    Nega
            </a>
        </td>
       
    </tr>
    <?php }
    }
   ?>
</table>