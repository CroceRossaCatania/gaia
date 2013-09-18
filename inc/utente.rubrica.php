<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

?>

<script type="text/javascript"><?php require './js/presidente.utenti.js'; ?></script>
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
                    <input autofocus required id="cercaUtente" placeholder="Cerca Referente..." type="text">
                </div>
            </div>
        </div>
        <hr />
        <table class="table table-striped table-bordered" id="tabellaUtenti">
            <thead>
                <th>Foto</th>
                <th>Nome</th>
                <th>Cognome</th>
                <th>Cellulare Servizio</th>
                <th>Comitato</th>
                <th>Azione</th>
            </thead>
            <?php 
            $comitato = $me->unComitato();
            $volontari = $comitato->membriRubrica();

            foreach ( $volontari as $volontario ) {
                    $_v = new Volontario($volontario);
                    ?>
                    <tr>
                        <td><img src="<?php echo $_v->avatar()->img(10); ?>" class="img-polaroid" /></td>
                        <td><?php echo $_v->nome; ?></td>
                        <td><?php echo $_v->cognome; ?></td>
                        <td><?php echo $_v->cellulare(); ?></td>
                        <td><?php echo $comitato->nomeCompleto(); ?></td>
                        <td>
                            <a class="btn btn-success" href="?p=utente.mail.nuova&id=<?php echo $_v->id; ?>">
                                <i class="icon-envelope"></i>
                            </a>
                        </td>
                    </tr>
                    <?php 
            }
            ?>
        </table>
    </div>
</div>