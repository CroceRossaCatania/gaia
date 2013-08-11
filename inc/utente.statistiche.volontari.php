<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();
caricaSelettoreComitato();


?>


<div class="row-fluid">
    <div class="span3">
        <?php        menuVolontario(); ?>
    </div>
    <div class="span9">
        <h2><i class="icon-puzzle-piece"></i> Statistiche Volontari</h2>
        <div class="row-fluid">
        <form class="form-horizontal" action="?p=utente.statistiche.volontari.ok&id=<?php echo $me->id; ?>" method="POST">
            <div class="control-group">
                <label class="control-label" for="inputComitato">Scegli il comitato</label>
                <div class="controls">
                    <a class="btn btn-inverse" data-selettore-comitato="true" data-input="inputComitato">
                        Seleziona un comitato... <i class="icon-pencil"></i>
                    </a>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                  <button type="submit" class="btn btn-large btn-success">
                      <i class="icon-ok"></i>
                      Visualizza dati
                  </button>
              </div>
          </div>
      </div>


      <?php
      $comitato = $me->unComitato();
      $info = $comitato->informazioniVolontariJSON()
      ?>
      <div class="row-fluid">
        <div id="graficosx" class="span6"></div>   
        <div id="graficodx" class="span6"></div>
    </div>
    <div class="row-fluid">
        <div id="graficoanz" class="span12"></div>   
    </div>
    <script type="text/javascript">
        volontari(<?php echo($info); ?>)
    </script>            
</div>
</div>


