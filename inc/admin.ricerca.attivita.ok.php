<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(array('input'), 'admin.ricerca.attivita&err');

$attivita = Attivita::by('id', $_POST['input']);

if($attivita){

	redirect('attivita.scheda&id='.$attivita);

}

if(!$attivita){

	$attivita = Attivita::filtra([['nome', "%{$_POST['input']}%", OP_LIKE]]);

}

if(!$attivita){

	redirect('admin.ricerca.utenti&no');

}

?>
<div class="row-fluid">
	<div class="span12">
    	<div class="row-fluid">
        	<h2>
                <i class="icon-calendar muted"></i>
                Attività 
        	</h2>
        </div>
		<div class="row-fluid">
		    <div class="span12">
		        <table class="table table-striped table-bordered table-condensed" id="tabellaUtenti">
		            <thead>
		                <th>Nome</th>
		                <th>Comitato</th>
		                <th>Referente</th>
		                <th>Azioni</th>
		            </thead>
		            <?php foreach ( $attivita as $at ) { ?>
		                <tr>
		                    <td><?= $at->nome; ?></td>
		                    <td><?= $at->comitato()->nomeCompleto(); ?></td>
		                    <td><a href="?p=presidente.utente.visualizza&id=<?= $at->referente(); ?>"><?= $at->referente()->nomeCompleto(); ?></a></td>
		                    <td>
		                        <div class="btn-group">
		                            <a class="btn btn-small" href="?p=attivita.scheda&id=<?= $at->id; ?>" title="Dettagli">
		                                <i class="icon-eye-open"></i> Dettagli
		                            </a>
		                        </div>
		                    </td>
		                </tr>
		            <?php } ?>
		        </table>
		    </div>
		</div>
	</div>
</div>