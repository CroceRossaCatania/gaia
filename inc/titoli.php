<?php

/*
 * ©2012 Croce Rossa Italiana
 */

if (isset($_GET['t'])) {
    $t = (int) $_GET['t'];
} else {
    $t = 0;
}
$titoli = $conf['titoli'][$t];

paginaPrivata();
 
?>
<hr />
<div class="row-fluid">
    <div class="span3">
        <?php        menuVolontario(); ?>
    </div>
    <div class="span9">
        

        <?php if ( $t == 0 ) { ?>
        <h2><i class="icon-magic muted"></i> Competenze personali</h2>
        <div class="alert alert-block alert-warning ">
            <div class="row-fluid">
                <span class="span7">
                    <h4>In cosa sei bravo?</h4>
                    <p>Inserisci le tue competenze professionali.</p>
                    <p>Es.: <code>Informatico</code>, <code>Fotografo</code>, <code>Elettricista</code>.</p>
                </span>
                <span class="span5">
                    <p>Quando hai finito, clicca su</p>
                    <a href="?p=titoli&t=1" class="btn btn-large">
                        Vai al passo successivo <i class="icon-chevron-right"></i>
                    </a>
                </span>
            </div>
        </div>
        <?php } elseif ($t == 1) { ?>
        <h2><i class="icon-fighter-jet muted"></i> Patenti civili</h2>
        <div class="alert alert-block alert-info ">
            <div class="row-fluid">
            <span class="span7">
                <h4>Quali Patenti civili hai conseguito ?</h4>
                <p>Inserisci le tue patenti Civili, inizia la ricerca digitando Patente e selezionando dall'elenco sottostante le tue Patenti Civili.</p>
                <p>Es.: <code>Patente Civile Cat.A1</code>, <code>Patente Civile Cat.B</code>.</p>
            </span>
            <span class="span5">
                <p>Quando hai finito, clicca su</p>
                <a href="?p=titoli&t=2" class="btn btn-large">
                    Vai al passo successivo <i class="icon-chevron-right"></i>
                </a>
            </span>    
            </div>
        </div>
        <?php } elseif ($t == 2) { ?>
        <h2><i class="icon-ambulance muted"></i> Patenti di Croce Rossa</h2>
        <div class="alert alert-block alert-info">
            <div class="row-fluid">
                <span class="span7">
                    <h4>Quali Patenti CRI hai conseguito ?</h4>
                    <p>Inserisci le tue patenti CRI, inizia la ricerca digitando Patente e selezionando dall'elenco sottostante le tue Patenti CRI.</p>
                    <p>Es.: <code>Patente CRI 1</code>, <code>Patente CRI 2</code>.</p>
                </span>
                <span class="span5">
                    <p>Quando hai finito, clicca su</p>
                    <a href="?p=titoli&t=3" class="btn btn-large">
                        Vai al passo successivo <i class="icon-chevron-right"></i>
                    </a>
                </span>   
            </div>
        </div>
        <?php } elseif ($t == 3) { ?>
        <h2><i class="icon-beaker muted"></i> Titoli di Studio</h2>
        <div class="alert alert-block alert-error">
            <div class="row-fluid">
                <span class="span7">
                    <h4>Quali titoli di studio hai conseguito ?</h4>
                    <p>Inserisci i tuoi titoli di studio</p>
                    <p>Es.: <code>Diploma Liceo Scientifico</code>, <code>Laurea Medicina</code>.</p>
                </span>
                <span class="span5">
                    <p>Quando hai finito, clicca su</p>
                    <a href="?p=titoli&t=4" class="btn btn-large">
                        Vai al passo successivo <i class="icon-chevron-right"></i>
                    </a>
                </span>   
            </div>
            
        </div>
        <?php } else { ?>
        <h2><i class="icon-plus-sign-alt muted"></i> Titoli CRI</h2>
        <div class="alert alert-block alert-success">
            <div class="row-fluid">
                <span class="span7">
                    <h4>Quali titoli CRI hai conseguito ?</h4>
                    <p>I titoli che hai ottenuto in Croce Rossa.</p>
                    <p>Es.: <code>Corso Base BEPS</code>, <code>PSTI</code>, <code>Istruttore BLSD</code>.</p>
                </span>
                <span class="span5">
                    <p>Questo era l'ultimo passo</p>
                    <a href="?p=finisciWizard" class="btn btn-large">
                        Torna al Benvenuto <i class="icon-reply"></i>
                    </a>
                </span>  
            </div>
            
        </div>
        <?php } ?>

        <?php if ( isset($_GET['gia'] ) ) { ?>
        <div class="alert alert-error">
            <i class="icon-warning-sign"></i>
            <strong>Errore</strong> &mdash; Non puoi inserire lo stesso titolo o qualifica due volte.
        </div>
        <?php } ?>
        
        <div id="step1">
            

            <div class="alert alert-block alert-success" <?php if ($titoli[2]) { ?>data-richiediDate<?php } ?>>
                <!--<div class="row-fluid">
                    <h4>Aggiungi</h4>
                </div>-->
                <div class="row-fluid">
                    <span class="span3">
                        <label for="cercaTitolo">
                            <span style="font-size: larger;">
                                <i class="icon-search"></i>
                                <strong>Aggiungi</strong>
                            </span>
                        </label>

                    </span>
                    <span class="span9">
                        <input type="text" autofocus data-t="<?php echo $t; ?>" required id="cercaTitolo" placeholder="Cerca un titolo..." class="span12" />
                    </span>
                </div>

            </div>

            <table class="table table-striped table-condensed table-bordered" id="risultatiRicerca" style="display: none;">
                <thead>
                    <th>Nome risultato</th>
                    <th>Aggiungi</th>
                </thead>
                <tbody>

                </tbody>
            </table>
            
          </div>
        
        <div id="step2" style="display: none;">
            <form action='?p=aggiungiTitolo' method="POST">
            <input type="hidden" name="idTitolo" id="idTitolo" />
            <div class="alert alert-block alert-success">
                <div class="row-fluid">
                    <h4><i class="icon-question-sign"></i> Quando hai ottenuto...</h4>
                </div>
                <hr />
                <div class="row-fluid">
                    <div class="span4 centrato">
                        <label for="dataInizio"><i class="icon-calendar"></i> Ottenimento</label>
                    </div>
                    <div class="span8">
                        <input id="dataInizio" class="span12" name="dataInizio" type="text" <?php if ($titoli[3]) { ?>required<?php } ?> value="" />
                    </div>
                </div>
                <?php if ( $t != TITOLO_STUDIO ) { ?>
                <div class="row-fluid">
                    <div class="span4 centrato">
                        <label for="dataFine"><i class="icon-time"></i> Scadenza</label>
                    </div>
                    <div class="span8">
                        <input id="dataFine" class="span12" name="dataFine" type="text" <?php if ($titoli[3]) { ?>required<?php } ?> value="" />
                    </div>
                </div>
                <?php } ?>
                <?php if ( $t == TITOLO_CRI ) { ?>
                <div class="row-fluid">
                    <div class="span4 centrato">
                        <label for="luogo"><i class="icon-road"></i> Luogo</label>
                    </div>
                    <div class="span8">
                        <input id="luogo" class="span12" name="luogo" type="text" required value="" />
                    </div>
                </div>
                <div class="row-fluid">
                <div class="span4 centrato">
                        <label for="codice"><i class="icon-barcode"></i> Codice</label>
                    </div>
                    <div class="span8">
                        <input id="codice" class="span12" name="codice" type="text" value="" />
                    </div>
                </div>
                 <?php } ?>
                <?php if ( $t == 2 ) { ?>
                <div class="row-fluid">
                <div class="span4 centrato">
                        <label for="codice"><i class="icon-barcode"></i> N. Patente</label>
                    </div>
                    <div class="span8">
                        <input id="codice" class="span12" name="codice" type="text" value="" />
                    </div>
                </div>
                <?php } ?>
                <div class="row-fluid">
                    <div class="span4 offset8">
                        <button type="submit" class="btn btn-success">
                            <i class="icon-plus"></i>
                                Aggiungi il titolo
                        </button>
                    </div>
                </div>
                
            </div>
            
        </div>
        
    
            <div class="row-fluid">
            
            <div class="span12">
                <?php $ttt = $me->titoliTipo($t); ?>
                <h3><i class="icon-list muted"></i> Nel mio curriculum <span class="muted"><?php echo count($ttt); ?> inseriti</span></h3>
                <table class="table table-striped">
                    <?php foreach ( $ttt as $titolo ) { ?>
                    <tr <?php if (!$titolo->tConferma) { ?>class="warning"<?php } ?>>
                        <td><strong><?php echo $titolo->titolo()->nome; ?></strong></td>
                        <td><?php echo $conf['titoli'][$titolo->titolo()->tipo][0]; ?></td>
                        <?php if ($titolo->tConferma) { ?>
                            <td>
                                <abbr title="<?php echo date('d-m-Y H:i', $titolo->tConferma); ?>">
                                    <i class="icon-ok"></i> Confermato
                                </abbr>
                            </td>    
                        <?php } else { ?>
                            <td><i class="icon-time"></i> Pendente</td>
                        <?php } ?>
                        <td><small>
                            <?php if ( $titolo->inizio ) { ?>
                            
                                <i class="icon-calendar muted"></i>
                                <?php echo date('d-m-Y', $titolo->inizio); ?>
                                <?php } ?>
                                
                                <?php if ( $titolo->fine ) { ?>
                                    <br />
                                    <i class="icon-time muted"></i>
                                    <?php echo date('d-m-Y', $titolo->fine); ?>
                                <?php } ?>
                                <?php if ( $titolo->luogo ) { ?>
                                    <br />
                                    <i class="icon-road muted"></i>
                                    <?php echo $titolo->luogo; ?>
                                 <?php } ?>
                                 <?php if ( $titolo->codice ) { ?>
                                    <br />
                                    <i class="icon-barcode muted"></i>
                                    <?php echo $titolo->codice; ?>
                                  <?php } ?>
                                    
                            </small></td>
                            
                            
                            <td><a  href="?p=cancellaTitolo&id=<?php echo $titolo->id; ?>" title="Cancella il titolo" class="btn btn-small btn-warning">
                                <i class="icon-trash"></i>
                            </a></td>
                    </tr>
                    <?php } ?>
                    
                </table>

            </div>
        </div>
    
    </div>
</div>
