<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

?>
<script type="text/javascript"><?php require './js/presidente.utenti.js'; ?></script>
<div class="row-fluid">
    <div class="span3">
        <?php        menuVolontario(); ?>
    </div>
    
    <div class="span9">
        <div class="row-fluid">
            <div class="span4">
                <h3>
                    <i class="icon-book muted"></i>
                    Rubrica Referenti
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
                <th>Incarico</th>
                <th>Telefono</th>
                <th>Email</th>
            </thead>
            <?php 
            $ccompetenza = $me->comitatiDiCompetenza();
            $comitati = $me->comitati();
            $locale = $me->unComitato()->locale();
            array_push($comitati, $locale);
            if ($ccompetenza)
                $comitati = array_merge($comitati, $ccompetenza);
            $comitati = array_unique($comitati);

            $delegati = [];

            foreach ( $comitati as $comitato ) {
                $delegati = array_merge($delegati, $comitato->volontariDelegati());
            }
            $delegati = array_unique($delegati);
            foreach ( $delegati as $delegato ) { 

                $_v = Volontario::id($delegato);
                $d = $_v->delegazioni();
                ?>
                <tr>
                    <td><img src="<?php echo $_v->avatar()->img(10); ?>" class="img-polaroid" /></td>
                    <td><?php echo $_v->nome; ?></td>
                    <td><?php echo $_v->cognome; ?></td>
                    <td>
                        <?php 
                        $presidente = false;
                        foreach ($d as $_d) {
                        
                        switch ( $_d->applicazione ) { 
                            case APP_PRESIDENTE:
                            if (!$presidente) {
                            ?>
                            <strong>Presidente</strong>
                            (<?php echo $_d->comitato()->nomeCompleto(); ?>)
                            <br>
                            <?php $presidente = true;}
                            break;
                            case APP_ATTIVITA:
                            ?>
                            <strong>Referente</strong>
                            <?php echo $conf['app_attivita'][$_d->dominio]; ?>
                            (<?php echo $_d->comitato()->nomeCompleto(); ?>)
                            <br>
                            <?php
                            break;
                            case APP_OBIETTIVO:
                            ?>
                            <strong>Delegato</strong>
                            <?php echo $conf['obiettivi'][$_d->dominio]; ?>
                            (<?php echo $_d->comitato()->nomeCompleto(); ?>)
                            <br>
                            <?php
                            break;
                            case APP_SOCI:
                            ?>
                            <strong>Delegato</strong> Ufficio Soci
                            (<?php echo $_d->comitato()->nomeCompleto(); ?>)
                            <br>
                            <?php
                            break;
                            case APP_CO:
                            ?>
                            <strong>Delegato</strong> Centrale Operativa
                            (<?php echo $_d->comitato()->nomeCompleto(); ?>)
                            <br>
                            <?php
                            break;

                        }} ?>
                    </td>
                    <td>
                        <span data-nascondi="" data-icona="icon-phone"><?php echo $_v->cellulare(); ?></span>
                    </td>
                    <td>
                        <span data-nascondi="" data-icona="icon-envelope"><?php echo $_v->email(); ?></span>
                    </td>
                </tr>
                <?php 

                

            }

            


            ?>
        </table>
    </div>
</div>