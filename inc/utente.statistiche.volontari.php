<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();


?>
       

<div class="row-fluid">
    <div class="span3">
        <?php        menuVolontario(); ?>
    </div>
    <div class="span9">
        <h2><i class="icon-puzzle-piece"></i> Statistiche Volontari</h2>
        <div class="row-fluid">
            <?php
                $comitato = $me->unComitato();
                $datesesso = $comitato->etaSessoComitato();
                $r = ['datesesso'=>$datesesso];

                $daticomitato = json_encode($r);


            ?>

	        <div id="graficosx" class="span6"></div>   
			<div id="graficodx" class="span6"></div>
			<script type="text/javascript">
		       		volontari(<?php echo($daticomitato); ?>)
		    </script> 
		</div>               
    </div>
</div>


