<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

$t = TitoloPersonale::pendenti();

?>
<script type="text/javascript"><?php require './js/admin.listaUtenti.js'; ?></script>
<br/>
    <div class="control-group" align="right">
        <div class="controls">
            <div class="input-prepend">
                <span class="add-on"><i class="icon-search"></i></span>
                <input data-t="<?php echo $t; ?>" required id="cercaUtente" placeholder="Cerca utente..." class="span4" type="text">
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
        <th>Titolo</th>
        <th>Dettagli</th>
        <th>Azione</th>
    </thead>
    <?php 
    $comitati= $me->comitatiDiCompetenza();
    foreach($comitati as $comitato){
             foreach ( $t as $_t ) {
                   $a=$_t->volontario()->id;
                   $a = Appartenenza::filtra([['volontario',$a],['comitato',$comitato]]);
                   if($a[0]!=''){
                ?>
    <tr>
        <td><?php echo $_t->id; ?></td>
        <td><?php echo $_t->volontario()->nome; ?></td>
        <td><?php echo $_t->volontario()->cognome; ?></td>
        <td><?php echo $_t->volontario()->codiceFiscale; ?></td>
        <td><strong><?php echo $_t->titolo()->nome; ?></strong></td>
        <td><small>
                                <i class="icon-calendar muted"></i>
                                <?php echo date('d-m-Y', $_t->inizio); ?>
                                
                                <?php if ( $_t->fine ) { ?>
                                    <br />
                                    <i class="icon-time muted"></i>
                                    <?php echo date('d-m-Y', $_t->fine); ?>
                                <?php } ?>
                                <?php if ( $_t->luogo ) { ?>
                                    <br />
                                    <i class="icon-road muted"></i>
                                    <?php echo $_t->luogo; ?>
                                 <?php } ?>
                                 <?php if ( $_t->codice ) { ?>
                                    <br />
                                    <i class="icon-barcode muted"></i>
                                    <?php echo $_t->codice; ?>
                                  <?php } ?>
                                    
                            </small></td>
        <td>    
        <a class="btn btn-success" href="?p=presidente.titolo.ok&id=<?php echo $_t->id; ?>&si">
                <i class="icon-ok"></i>
                    Conferma
            </a>
            <a class="btn btn-danger" href="?p=presidente.titolo.ok&id=<?php echo $_t->id; ?>&no">
                <i class="icon-ban-circle"></i>
                    Nega
            </a>
        </td>
        
    </tr>
    <?php }}} ?>
</table>