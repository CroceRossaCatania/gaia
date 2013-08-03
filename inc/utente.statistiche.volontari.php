<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();


?>
<script type="text/javascript"><?php require './js/utente.statistiche.volontari.js'; ?></script>

<div class="row-fluid">
    <div class="span3">
        <?php        menuVolontario(); ?>
    </div>
    <div class="span9">
        <h2><i class="icon-puzzle-piece"></i> Statistiche Volontari</h3>
        <div id="grafico">
	        <script type="text/javascript">
	            simplegraph()
	        </script>
        </div>

       
        
        
        
    </div>

</div>
