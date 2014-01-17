<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

$tesseramenti = Tesseramento::elenco();



if ( isset($_GET['anno']) ) { ?>
<div class="alert alert-error">
    <i class="icon-warning-sign"></i> <strong>Tesseramento già attivo per l'anno in corso</strong>.<br />
    Non è possibile attivare più tesseramenti per l'anno in corso.
</div>
<?php } elseif ( isset($_GET['haquote']) ) { ?>
<div class="alert alert-error">
    <i class="icon-warning-sign"></i> <strong>Tesseramento con quote pagate</strong>.<br />
    Non è possibile cancellare un tesseramento con quote pagate.
</div>
<?php } ?>

<form action="?p=admin.tesseramento.ok" method="POST">

        <div class="pull-right btn-group">
                <a href="?p=admin.tesseramento.apri" class="btn btn-large btn-warning"
                        data-conferma="Generare davvero una nuova chiave?">
                        <i class="icon-plus"></i>
                        Attiva nuovo tesseramento
                </a>
                <button type="submit" class="btn btn-large btn-success">
                        <i class="icon-save"></i>
                        Salva modifiche
                </button>
        </div>

        <h2>Tesseramenti</h2>

        <table class="table table-bordered">

                <thead>
                        <th>Anno</th>
                        <th>Data apertuta</th>
                        <th>Data chiusura</th>
                        <th>Stato</th>
                        <th>Attivo</th>
                        <th>Ordinario</th>
                        <th>Benemerito</th>
                        <th>Azioni</th>
                </thead>

                <tbody>
                <?php foreach ( $tesseramenti as $t ) { ?>

                        <tr>
                                <td>
                                        <input type="hidden" name="tesseramento[]" value="<?php echo $t->id; ?>" />
                                        <?php echo $t->anno; ?>
                                </td>
                                <td>
                                        <input class="dti grassetto input-medium" 
                                        required type="text" 
                                        name="<?php echo $t->id; ?>_inizio" 
                                        value="<?php if($t->inizio) echo $t->inizio()->format('d/m/Y'); else echo date('d/m/Y'); ?>"
                                         />
                                </td>
                                <td>
                                        <input class="dtf grassetto input-medium" 
                                        required type="text" 
                                        name="<?php echo $t->id; ?>_fine" 
                                        value="<?php if($t->fine) echo $t->fine()->format('d/m/Y'); else echo date('d/m/Y'); ?>"
                                         />
                                </td>
                                <td>
                                        <select class="input-small" name="<?php echo $t->id; ?>_stato" required>
                                        <?php
                                        foreach ( $conf['tesseramento'] as $numero => $stato ) { ?>
                                                <option value="<?php echo $numero; ?>" <?php if ( $numero == $t->stato ) { ?>selected<?php } ?>><?php echo $stato; ?></option>
                                        <?php } ?>
                                        </select>  
                                </td>
                                <td>
                                        € <input class="input-mini" type="text" 
                                        name="<?php echo $t->id; ?>_attivo"
                                        />
                                </td>
                                <td>
                                        € <input class="input-mini" type="text" 
                                        name="<?php echo $t->id; ?>_ordinario"
                                        />
                                </td>
                                <td>
                                        € <input class="input-mini" type="text" 
                                        name="<?php echo $t->id; ?>_benemerito"
                                        />
                                </td>
                                <td>
                                        <a class="btn btn-danger"
                                        href="?p=admin.tesseramento.cancella&id=<?php echo $t->id; ?>"
                                        data-conferma="CANCELLARE DEFINITIVAMENTE?">
                                                <i class="icon-trash"></i>
                                        </a>

                                </td>
                        </tr>

                <?php } ?>
                </tbody>
        </table>


</form>
<hr />

<p>
        <ul>
                <li>Un tesseramento <strong>chiuso</strong> non può più essere modificato</li>
                <li>Prima della <strong>data apertura </strong> non possono essere registrate quote sull'anno</li>
                <li>Prima della <strong>data chiusura </strong> non può essere fatta la chiusura del tesseramento di un comitato</li>
        </ul>
</p>

