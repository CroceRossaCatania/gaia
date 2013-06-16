<?php

/*
 * ©2013 Croce Rossa Italiana
 */


$c = $_GET['oid'];
$c = GeoPolitica::daOid($c);

paginaApp([APP_PRESIDENTE]);
caricaSelettore();

if ( isset($_GET['back']) && !($_GET['back']==="")) {
    
    (int) $back = $_GET['back'];
} else {
    $back = 'false';
}
?>

<script type="text/javascript">
var contenitoreIcone = {
    header: "ui-icon-circle-arrow-e",
    activeHeader: "ui-icon-circle-arrow-s"
};

$(document).ready(function() {
    $("#parti").accordion({
              icons:        contenitoreIcone,
              heightStyle:  "content",
              active:       <?php echo $back; ?>,
              collapsible:  true
    });
});
</script>

<a href="?p=presidente.dash" class="btn btn-large">
    <i class="icon-reply"></i> Torna all'elenco dei comitati
</a>

<h2>
    <i class="icon-cogs"></i>
    <strong>
        <?php echo $c->nomeCompleto(); ?>
    </strong>
</h2>

<div class="">

    <?php if ( isset($_GET['ok']) && $c->id == $_GET['id'] ) { ?>
    <div class="alert alert-success">
        <i class="icon-ok"></i> <strong>Modifiche salvate</strong> &mdash; Grazie.
    </div>
    <?php } ?>

    <form action="?p=presidente.comitato.ok" method="POST">
        
    <input type="hidden" name="oid" value="<?php echo $c->oid(); ?>" />

    <div class="row-fluid" id="parti">

        <h3>Obiettivi strategici</h3>
        <div class="row-fluid">
            <p class="text-info"><i class="icon-info-sign"></i> I delegati selezionati possono creare attività
                nel comitato riguardanti il loro Obiettivo Strategico.</p>
            <?php if (!$c->obiettivi()) { ?>
            <p class="text-error">
                <i class="icon-warning-sign"></i> <strong>Attenzione</strong> &mdash;
                Ancora nessun delegato obiettivo scelto!
            </p><hr />
            <?php } ?>

            <?php
            $nOb = 0;
            foreach ( $conf['obiettivi'] as $num => $nome ) { ?>
                <p><strong><?php echo $nome; ?></strong><br />
                <?php
                $o = $c->obiettivi($num);
                $nOb += count($o);
                if ($o) {
                    $o = $o[0];
                ?>
                <a data-autosubmit="true" data-selettore="true" data-input="<?php echo $num; ?>" class="btn btn-small">
                    <?php echo $o->nomeCompleto(); ?> <i class="icon-pencil"></i> 
                </a> 
                <?php } else { ?>
                <a data-autosubmit="true" data-selettore="true" data-input="<?php echo $num; ?>" class="btn btn-small">
                    Seleziona volontario... <i class="icon-pencil"></i>
                </a>
                <?php } ?>
                </p>

            <?php } ?>

        </div>

        <h3>Dettagli e contatti</h3>
        <div class="row-fluid">
            <p class="text-info"><i class="icon-info-sign"></i> Queste informazioni sono rese pubbliche.</p>
            <p>
                <strong>Indirizzo</strong><br />
                <?php echo $c->formattato; ?>
            </p>
            <p>
                <strong>Telefono</strong><br />
                <?php echo $c->telefono; ?>
            </p>    
            <?php if ( $c->fax ) { ?>
                <p>
                    <strong>Fax</strong><br />
                    <?php echo $c->fax; ?>
                </p>
            <?php } ?>
            <p>
                <strong>Email</strong><br />
                <code><?php echo $c->email; ?></code>
            </p>
            <a class="btn" href="?p=presidente.wizard&oid=<?php echo $c->oid(); ?>">
                <i class="icon-pencil"></i> Modifica informazioni
            </a>


        </div>

        <!-- VALIDO SOLO PER LE UNITA' TERRITORIALI -->
        <?php if ( $c instanceOf Comitato ) { ?>

            <h3>Aree di intervento e Responsabili</h3>
            <div class="row-fluid">
                <p class="text-info"><i class="icon-info-sign"></i> 
                   Inserire le aree di intervento e selezionare i responsabili associati.<br />Essi saranno 
                   in grado di <strong>organizzare nuove attività su Gaia</strong> riguardanti la loro Area.
                </p>

                <?php if ( $c->aree() ) { ?>
                <table class="table table-striped">

                    <thead>
                        <th>Obiettivo</th>
                        <th>Area</th>
                        <th>Volontario</th>
                    </thead>

                    <?php foreach ( $c->aree() as $area ) { ?>
                    <tr>
                        <td>
                            <select class="alCambioSalva" name="<?php echo $area->id; ?>_inputObiettivo">
                                <?php foreach ( $conf['obiettivi'] as $x => $y ) { ?>
                                <option value="<?php echo $x; ?>" <?php if ( $area->obiettivo == $x ) { ?>selected="selected"<?php } ?>><?php echo $y; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <input class="alCambioSalva" type="text" required name="<?php echo $area->id; ?>_inputNome" value="<?php echo $area->nome; ?>" />
                            <i class="icon-save icon-large text-warning"></i>
                        </td>
                        <td>
                            <a data-selettore="true" data-autosubmit="true" data-input="<?php echo $area->id; ?>_inputResponsabile" class="btn btn-block">
                                <?php echo $area->responsabile()->nomeCompleto(); ?> <i class="icon-pencil"></i>
                            </a>
                        </td>

                    </tr>
                    <?php } ?>


                </table>
                <?php } else { ?>
                    <p class="text-error"><i class="icon-warning-sign"></i> <strong>Attenzione</strong> &mdash;
                        È necessario creare almeno un responsabile per poter creare attività.
                    </p>
                <?php } ?>

                <hr />

                <?php if ( $nOb ) { ?>
                <button class="btn btn-block btn-large" name="nuovaArea" value="1">
                    <i class="icon-plus"></i> Aggiungi nuova area di interesse
                </button>
                <?php } else { ?>
                <div class="alert alert-error">
                    <i class="icon-warning-sign"></i> <strong>Nessun delegato obiettivo</strong> &mdash;
                    Prima di nominare un responsabile di un'Area, nomina almeno un delegato obiettivo qui sopra.
                </div>
                <button disabled class="btn btn-block btn-large disabled" name="nuovaArea" value="1">
                    <i class="icon-plus"></i> Aggiungi nuova area di interesse
                </button>

                <?php } ?>


            </div>
            
            <h3>Referenti e Attività</h3>
            <div class="row-fluid">
                
                <div class="span6">
                    <a href="?p=attivita.gestione" class="btn btn-large btn-block">
                        <i class="icon-list"></i>
                        Elenco delle attività e dei referenti
                    </a>
                </div>
                
                <div class="span6">
                    <a href="?p=attivita.idea" class="btn btn-block btn-large btn-primary">
                        <i class="icon-plus"></i>
                        Crea un'attività e nomina un referente
                    </a>
                </div>


            </div>

        <?php } ?>
        
    </div>

    </form>

</div>
