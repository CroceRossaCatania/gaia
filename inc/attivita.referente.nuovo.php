<?php

/*
 * ©2013 Croce Rossa Italiana
 */

controllaParametri(array('id'));

$attivita = Attivita::id($_GET['id']);

paginaPrivata();
paginaAttivita($attivita);
caricaSelettore();
paginaModale();

$a = Attivita::id($attivita);



?>
<form action="?p=attivita.referente.nuovo.ok" method="POST">

<input type="hidden" name="id" value="<?= $attivita; ?>" />

<div class="modal fade automodal">
        <div class="modal-header">
          <h3><i class="icon-user"></i> Seleziona il referente</h3>
        </div>
        <div class="modal-body">
          <p><strong>Chi è il referente?</strong>
          <ul>
              <li>Punto di riferimento per i volontari che vogliono partecipare
                  all'attività;</li>
              <li>I suoi contatti verranno divulgati coi
                    volontari interessati all'attività;</li>
              <li>Generalmente è presente sul posto all'attività e/o
                conosce chi vi ci si reca.</li>
          </ul>
           <p class="text-info"><i class="icon-info-sign"></i> <strong>Nota bene</strong>: potrai anche successivamente decidere se delegare 
                al referente l'inserimento di tutti i dettagli dell'attività, compresi giorni e turni.</p>
           <p>&nbsp;</p>
          <p>
              <a data-selettore="true" 
                 data-input="inputReferente" 
                 data-autosubmit="true" 
                 data-comitati="<?php echo $a->comitato; ?>"
                 class="btn btn-inverse btn-block btn-large">
                  Seleziona un volontario... <i class="icon-pencil"></i>
              </a>
        </div>
</div>
    
</form>
