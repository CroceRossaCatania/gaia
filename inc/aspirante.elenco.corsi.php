<?php

paginaPrivata();

if ( $me->stato != ASPIRANTE )
	redirect('utente.me');

// Se non ho ancora registrato il mio essere aspirante
if ( !($a = Aspirante::daVolontario($me)) )
	redirect('aspirante.registra');

?>
<div class="row-fluid">
    <div class="span3">
        <?php menuAspirante(); ?>
    </div>
    <div class="span9">

		<h2><i class="icon-list"></i> Elenco dei Corsi Base a cui puoi partecipare</h2>
		<?php if(isset($_GET['err'])) { ?>
			<div class="alert alert-block alert-error">
            <h4><i class="icon-warning-sign"></i> <strong>Qualcosa non ha funzionato</strong>.</h4>
            <p>L'operazione che stavi tentando di eseguire non è andata a buon fine. Per favore riprova.</p>
        	</div> 

		<?php } ?>


	    <div class="row-fluid">
			<div class="span12">

                <table class="table table-striped table-bordered">

                    <thead>
                        <th> 
                            Organizzatore
                        </th>
                        <th>
                            Data e luogo
                        </th>
                        <th>
                            Stato
                        </th>

                        <th>
                            Azione
                        </th>
                    </thead>

                    <?php foreach ( $a->corsiBase() as $corso ) { ?>

                    <tr>

                    	<td style="width: 20%;">
                            <?php echo $corso->organizzatore()->nomeCompleto(); ?>
                        </td>
                        <td style="width: 45%;">
                            <strong>
                                <a href="?p=formazione.corsibase.scheda&id=<?php echo $corso->id; ?>">
                                    <?php echo $corso->nome(); ?>
                                </a>
                            </strong><br />
                            Sede:
                            <?php echo $corso->luogo; ?>
                            <br />
                            Data inizio:
                            <?php echo $corso->inizio()->inTesto(false); ?>
                            <br />
                            <?php if ( $corso->direttore ) { ?>
                            Direttore:
                            <?php echo $corso->direttore()->nomeCompleto(); ?>
                            <?php } else { ?>
                            <i class="icon-warning-sign"></i> Nessun referente
                            <?php } ?>
                        </td>
                
                        <td style="width: 15%;">
                            <?php echo($conf['corso_stato'][$corso->stato]); ?>
                            <?php if($corso->futuro()) echo("e non ancora iniziato"); ?>
                        </td>
                        
                        <td style="width: 20%;">
                            <?php // da sistemare
                            ?>
                            <a href="?p=utente.email.nuova&id=<?php echo $corso->id; ?>">
                                <i class="icon-edit"></i> Manda email al referente
                            </a>
                            <br />
                            <a href="?p=formazione.corsibase.scheda&id=<?php echo $corso->id; ?>">
                                <strong><i class="icon-plus"></i> Maggiori info e preiscrizione</strong>
                            </a>        
                        </td>
                        
                    </tr>

                    <?php } ?>

                </table>
            </div>
        </div>
    </div>
</div>
