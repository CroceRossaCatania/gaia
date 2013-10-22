<?php

/*
 * ©2012 Croce Rossa Italiana
 */

paginaPrivata();

$id = $_GET['id'];
$a = Attivita::id($id);

?>

<hr />
<div class="row-fluid">
    
    <div class="span3">
        <?php menuVolontario(); ?>

    </div>

    <div class="span9">
        

        <div class="row-fluid">

        	<div class="btn-group">
	        	<a href="?p=attivita" class="btn btn-large">
	        		<i class="icon-reply"></i>
	        	</a>
	        	<a href="?p=attivita" class="btn btn-large btn-success">
	        		<i class="icon-ok"></i>
	        		Chiedi di partecipare
	        	</a>
        	</div>

			<hr />


        	<div class="btn-group">
	        	<a href="?p=attivita" class="btn btn-large">
	        		<i class="icon-reply"></i>
	        	</a>
	        	<a class="btn btn-large btn-success disabled">
	        		<i class="icon-ok"></i>
	        		Hai chiesto di partecipare
	        	</a>	
	        	<a href="?p=attivita" class="btn btn-large btn-warning">
	        		<i class="icon-remove"></i>
	        		Annulla
	        	</a>
        	</div>

			<hr />


        	<div class="btn-group">
	        	<a href="?p=attivita" class="btn btn-large">
	        		<i class="icon-reply"></i>
	        	</a>
	        	<a class="btn btn-large btn-success disabled">
	        		<i class="icon-ok"></i>
	        		Hai partecipato
	        	</a>	
	        	<a href="?p=attivita" class="btn btn-large btn-danger">
	        		<i class="icon-remove"></i>
	        		Non c'ero
	        	</a>
        	</div>
			<hr />

			<h3><?php echo $a->nome; ?></h3>
            <table class="table table-bordered table-striped">

            	

            	<tr>
            		<td class="muted">
            			<i class="icon-globe"></i>
            			Luogo
            		</td>
            		<td><?php echo $a->luogo; ?></td>
            	</tr>

            	<tr>
            		<td class="muted">
            			<i class="icon-home"></i>
            			Comitato
            		</td>
        			<td>
        				<i class="icon-sign-blank" style="color: #<?php echo $a->comitato()->colore(); ?>;"></i>
        				<?php echo $a->comitato()->nome; ?>
        			</td>
        		</tr>


            	<tr>
            		<td class="muted">
            			<i class="icon-user"></i>
            			Responsabile
            		</td>
        			<td>
        				<?php $r = $a->responsabile(); ?>
        				<?php echo $r->nomeCompleto(); ?><br />
        					<i class="icon-phone"></i> <span class="muted">+39</span> <?php echo $r->cell; ?><br />
        					<i class="icon-envelope"></i> <code><?php echo $r->email; ?></code>
        			</td>
        		</tr>



        		<?php if ( $a->descrizione ) { ?>
            	<tr>
        			<td colspan="2">

        				<pre><?php echo $a->descrizione; ?></pre>
        			</td>
        		</tr>
        		<?php } ?>

            	<tr>
            		<?php if ( $a->pubblica == ATTIVITA_PUBBLICA ) { ?>
            		<td class="muted">Partecipazione</td>
        			<td>
        				<i class="icon-unlock"></i>
        				Aperta a tutti i volontari di Croce Rossa Italiana.
        			</td>
        			<?php } else { ?>
        			<td class="muted">Partecipazione</td>
        			<td>
        				<i class="icon-lock"></i>
        				Aperta a tutti i membri del comitato.
        			</td>
        			<?php } ?>
        		</tr>

            	

            </table>
        </div>
        
    </div>
      
    
</div>

