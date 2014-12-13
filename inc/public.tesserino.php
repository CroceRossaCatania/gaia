<?php

/*
 * ©2014 Croce Rossa Italiana
 */

?>

<div class="row-fluid">
    <div class="span12 centrato">
            <h2><span class="muted">Croce Rossa.</span> Persone in prima persona.</h2>
        <hr />
    </div>
</div>

<div class="alert alert-block alert-info">
    <h4>
      <i class="icon-barcode"></i> Questa pagina ti permette di verificare la validità di un tesserino di un Socio della Croce Rossa Italiana
      
    </h4>
    <p>
      Ti preghiamo di inserire i dati che ti verranno richiesti per completare la procedura. 
      Tieni il <strong>tesserino</strong> che vuoi verificare a portata di mano!
    </p>
 </div>

 <div class="row-fluid">
    <div class="span6">
        <form class="form-horizontal" action="?p=public.tesserino.fatto" method="POST">
            <?php if (isset($_GET['num'])) { ?>
              <div class="alert alert-error">
                  <strong>Nessun numero di tessera inserito</strong>.<br />
                  Devi inserire un numero di tessera per poter effettuare la validazione
              </div>
            <?php } ?>
            <div class="control-group">
                <label class="control-label" for="inputNum">Numero Tessera</label>
                <div class="controls">
                    <input type="text" id="inputNum" name="inputNum" required autofocus />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputValida"> 
                </label>
                <div class="controls <?php if (isset($_GET['captcha'])) { ?>alert alert-error <?php } ?>">
                    <i class="icon-lock"></i> Per favore completa l'indovinello:<br /><br />
                    <p class="hidden-desktop"><i class="icon-tablet"></i> Stai usando un tablet o uno smartphone e non riesci a trascinare? 
                    Clicca sulla casella contenente la risposta corretta!</p>
                    <?php captcha_mostra(); ?>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-large btn-primary">
                        <i class="icon-ok"></i> Verifica </button>
                </div>
            </div>
        </form>
    </div>
    <div class="span6">
        <p>
            Il numero di tessera è riportato sul retro di ogni tesserino al di sotto del 
            <strong>Codice a Barre</strong>, inseriscilo nel campo corrispondente senza spazi.
        </p>
        <div class="row-fluid">
            <div class="span8 offset2"
                <div class="item active altoCento">
                    <img class="altoCentro" src="./img/tesserino/RetroAttivoEsempio.jpg" alt="esempio retro">
            </div>
        </div>
    </div>
</div>

