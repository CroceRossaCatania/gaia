<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPresidenziale();
caricaSelettore();


$comitati = $me->comitatiDiCompetenza();

if ( isset($_GET['id'] ) ) {
    $index = array_search(new Comitato($_GET['id']), $comitati);
} else {
    $index = "false";
}

?>
<script type="text/javascript">
var contenitoreIcone = {
    header: "ui-icon-circle-arrow-e",
    activeHeader: "ui-icon-circle-arrow-s"
};

$(document).ready(function() {
    $("#comitati").accordion({
              icons:        contenitoreIcone,
              heightStyle:  "content",
              active:       <?php echo $index; ?>,
              collapsible:  true
    });
});
</script>
<div class="row-fluid">
    <div class="span3">
        <?php menuVolontario(); ?>
    </div>
    <div class="span9">

        
        <div class="row-fluid">
            
            <div class="span9">
                <h2>Salve, presidente <?php echo $me->cognome; ?>.</h2>
            </div>
            
            <div class="span3 allinea-destra">
                <br />
                <a href="?p=utente.supporto">Aiuto <i class="icon-question-sign"></i></a>
            </div>
            
        </div>
                    
        <div class="row-fluid">
            
            <div class="span3">
                <div class="btn-group btn-group-vertical span12">
                    <a href="?p=presidente.utenti" class="btn btn-primary btn-block">
                        <i class="icon-list"></i>
                        Elenco volontari
                    </a>
                    <a href="?p=presidente.titoli.ricerca" class="btn btn-block">
                        <i class="icon-search"></i>
                        Ricerca per titolo
                    </a>
                </div>
            </div>
            
            <div class="span6 allinea-centro">
                <img src="http://upload.wikimedia.org/wikipedia/it/thumb/4/4a/Emblema_CRI.svg/75px-Emblema_CRI.svg.png" />
            </div>
            
            
            <div class="span3">
                
                <table class="table table-striped table-condensed">
                
                    <tr><td>Num. comitati</td><td><?php echo count($comitati); ?></td></tr>
                    <tr><td>Num. volontari</td><td><?php echo $me->numVolontariDiCompetenza(); ?></td></tr>
                    
                </table>
                
                
            </div>
            

            
        </div>
        
        <hr />
        
        <p class="text-success"><i class="icon-info-sign"></i> <strong>Unità territoriali</strong> &mdash;
            Cliccare sul nome di un'unità per modificarne <strong>delegati, obiettivi, responsabili, ecc.</strong>:</p>
        
        <div class="" id="comitati">
            
            <?php foreach ( $me->comitatiDiCompetenza() as $c ) { ?>
            <h3><strong><?php echo $c->nomeCompleto(); ?></strong></h3>
            <div class="">
                
                <?php if ( isset($_GET['ok']) && $c->id == $_GET['id'] ) { ?>
                <div class="alert alert-success">
                    <i class="icon-ok"></i> <strong>Modifiche salvate</strong> &mdash; Grazie.
                </div>
                <?php } ?>
                
                <form action="?p=presidente.dash.ok" method="POST">
                <input type="hidden" name="id" value="<?php echo $c->id; ?>" />
                
                <div class="row-fluid">
                    
                    <div class="row-fluid">
                    <div class="span6">
                        <h4 class="text-warning">Obiettivi strategici</h4>
                        <p class="text-info"><i class="icon-info-sign"></i> I delegati selezionati possono creare attività
                            nel comitato riguardanti il loro Obiettivo Strategico.</p>
                        <?php if (!$c->obiettivi()) { ?>
                        <p class="text-error">
                            <i class="icon-warning-sign"></i> <strong>Attenzione</strong> &mdash;
                            Ancora nessun delegato obiettivo scelto!
                        </p><hr />
                        <?php } ?>
                        
                        <?php foreach ( $conf['obiettivi'] as $num => $nome ) { ?>
                            <p><strong><?php echo $nome; ?></strong><br />
                            <?php
                            $o = $c->obiettivi($num);
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
                    
                    <div class="span6">
                        <h4 class="text-warning">Dettagli e contatti</h4>
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
                        <a class="btn" href="?p=presidente.wizard&id=<?php echo $c->id; ?>">
                            <i class="icon-pencil"></i> Modifica informazioni
                        </a>


                    </div>
                    </div>
                    
                    <hr />
                    
                    <div class="row-fluid">
                    <div class="span12">
                        <h3 class="text-error allinea-centro">Aree di intervento e Responsabili</h3>
                        <hr />
                        <p class="text-info"><i class="icon-info-sign"></i> 
                           Inserire le aree di intervento e selezionare i responsabili associati.<br />Essi saranno 
                           in grado di organizzare nuove attività su Gaia riguardanti la loro Area.
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

                        <button class="btn btn-block btn-large" name="nuovaArea" value="1">
                            <i class="icon-plus"></i> Aggiungi nuova area di interesse
                        </button>
                        
                        <hr />
                        
                        <h3 class="text-error allinea-centro">Referenti delle attività</h3>
                        
                        <p>
                            <a href="?p=attivita.gestione"><i class="icon-list"></i> Elenco delle attività e dei referenti</a>.
                        </p>
                        
                        <a href="?p=attivita.idea" class="btn btn-block btn-large">
                            <i class="icon-plus"></i> Crea un'attività e nomina un referente
                        </a>


                    </div>
                    </div>
                    
                    

                </div>
                

               
                
                
                </form>

            </div>
            <?php } ?>
            
        </div>
        
            


    </div>
</div>
            
