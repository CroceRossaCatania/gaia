<?php

/*
* ©2013 Croce Rossa Italiana
*/

paginaPresidenziale();

$v = $_GET['id'];
$v = Volontario::by('id', $v);
?>
<script type="text/javascript"><?php require './js/presidente.utenti.js'; ?></script>
<br/>
<div class="row-fluid">
	<div class="span5 allinea-sinistra">
		<h2>
			<i class="icon-group muted"></i>
			Storico Gruppi
		</h2>
		<p>Volontario: <strong><?= $v->nomeCompleto(); ?></strong></p>
	</div>
	<div class="span3">
		<div class="btn-group btn-group-vertical span12">
			<a href="?p=presidente.supervisione.nogruppo" class="btn btn-block">
				<i class="icon-reply"></i>
				Torna indietro
			</a>
		</div>
	</div>
	<div class="span4 allinea-destra">
		<div class="input-prepend">
			<span class="add-on"><i class="icon-search"></i></span>
			<input autofocus required id="cercaUtente" placeholder="Cerca Gruppo..." type="text">
		</div>
	</div>
</div>
<hr />
<div class="row-fluid">
	<table class="table table-bordered table-striped">
        <thead>
            <th>Stato</th>
            <th>Nome</th>
            <th>Comitato</th>
            <th>Inizio</th>
            <th>Fine</th>
        </thead>
                
        <?php foreach ( $v->mieiGruppi() as $app ) { ?>
            <tr<?php if ($app->attuale()) { ?> class="success"<?php } ?>>
                <td>
                    <?php if ($app->attuale()) { ?>
                        Attuale
                    <?php } else { ?>
                        Passato
                    <?php } ?>
                </td>
                
                <td>
                    <strong><?php echo $app->gruppo()->nome; ?></strong>
                </td>
                
                <td>
                    <strong><?php echo $app->comitato()->nomeCompleto(); ?></strong>
                </td>
                
                <td>
                    <i class="icon-calendar muted"></i>
                    <?php echo $app->inizio()->inTesto(false); ?>
                </td>
                
                <td>
                    <?php if ($app->fine) { ?>
                        <i class="icon-time muted"></i>
                        <?php echo $app->fine()->inTesto(false); ?>
                    <?php } else { ?>
                        <i class="icon-question-sign muted"></i>
                        Indeterminato
                    <?php } ?>
                </td>                
            </tr>
                <?php } ?>
            
    </table>
</div>