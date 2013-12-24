<?php
  /*
   * ©2013 Croce Rossa Italiana
   */

  paginaPrivata();



  controllaParametri(array('inputComitato'), 'utente.statistiche.volontari');
  $c = $_POST['inputComitato'];
  $comitato = Comitato::id($c);
  $info = $comitato->informazioniVolontariJSON();
  ?>

  <div class="row-fluid">
    <div class="span3">
      <?php        menuVolontario(); ?>
    </div>
    <div class="span9">

      <div class="row-fluid">
        <h2><i class="icon-puzzle-piece"></i> Dati relativi al <?php echo $comitato->nomeCompleto() ?></h2>
      </div>
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




