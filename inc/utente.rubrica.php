<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

?>

<script type="text/javascript"><?php require './assets/js/presidente.utenti.js'; ?></script>
<div class="row-fluid">
    <div class="span3">
        <?php menuVolontario(); ?>
    </div>
    
    <div class="span9">
        <div class="row-fluid">
            <div class="span4">
                <h3>
                    <i class="icon-book muted"></i>
                    Rubrica Volontari
                </h3>
            </div>

            <div class="span4 centrato">
                <div class="btn-group btn-group-vertical span12">
                    <a href="?p=utente.rubricaReferenti" class="btn btn-info btn-block">
                        <i class="icon-book"></i>
                        Rubrica Referenti
                    </a>
                    <a href="?p=utente.rubrica" class="btn btn-primary btn-block">
                        <i class="icon-book"></i>
                        Rubrica Volontari
                    </a>
                </div>
            </div>

            <div class="span4 allinea-destra">
                <div class="input-prepend">
                    <span class="add-on"><i class="icon-search"></i></span>
                    <input autofocus required id="cercaUtente" placeholder="Cerca Volontario..." type="text">
                </div>
            </div>
        </div>
        <hr />
        <div class="row-fluid">
            <div class="span12">
                <div class="alert alert-info">
                Per visualizzare il numero di telefono dei Volontari in rubrica premi su <i class="icon-phone"></i> ,
                mentre per visualizzare l'email premi su <i class="icon-envelope"></i> .
                </div>
            </div>
        </div>

        <table class="table table-striped table-bordered" id="tabellaUtenti">
            <thead>
                <th>Foto</th>
                <th>Nome</th>
                <th>Cognome</th>
                <th>Unità</th>
                <th>Telefono</th>
                <th>Email</th>
            </thead>
            <?php 
            $comitato = $me->unComitato();
            $volontari = $comitato->locale()->tuttiVolontari();

            foreach ( $volontari as $_v ) {
                    if($_v->privacy()->contatti($me)) {
                        $id = $_v->id;
                    ?>
                    <tr>
                        <td><img src="<?php echo $_v->avatar()->img(10); ?>" class="img-polaroid" /></td>
                        <td><?php echo $_v->nome; ?></td>
                        <td><?php echo $_v->cognome; ?></td>
                        <td><?php echo $_v->unComitato()->nome; ?></td>
                        <td>
                            <span data-nascondi="" data-icona="icon-phone"><?php echo $_v->cellulare(); ?></span>
                        </td>
                        <td>
                            <span data-nascondi="" data-icona="icon-envelope"><?php echo $_v->email(); ?></span>
                        </td>
                    </tr>
                    <?php }
            }
            ?>
        </table>
    </div>
</div>