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
                $date = $comitato->etaSessoComitatoToJSON()


            ?>

	        <div id="graficosx" class="span6"></div>   
			<div id="graficodx" class="span6"></div>
			<script type="text/javascript">
		       		volontari(<?php echo($date)?>)
		    </script> 
		</div>               
    </div>
</div>


