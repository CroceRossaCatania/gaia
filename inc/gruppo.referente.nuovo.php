<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPresidenziale();
caricaSelettore();
paginaModale();

controllaParametri(array('id'), 'gruppi.dash&err');

$gruppo = $_GET['id'];
$gruppo = Gruppo::id($gruppo);

proteggiClasse($gruppo, $me);

?>
<form action="?p=gruppo.referente.nuovo.ok" method="POST">

<input type="hidden" name="id" value="<?= $gruppo->id; ?>" />

<div class="modal fade automodal">
        <div class="modal-header">
          <h3><i class="icon-user"></i> Seleziona il referente</h3>
        </div>
        <div class="modal-body">
          <p><strong>Chi è il referente di un gruppo?</strong>
          <ul>
              <li>Punto di riferimento per i volontari del gruppo stesso;</li>
              <li>Coordina il gruppo per svolgere le attività continuative in maniera efficace e efficente;</li>
          </ul>
          <p>
              <a data-selettore="true" 
                 data-input="inputReferente" 
                 data-autosubmit="true" 
                 data-comitati="<?php echo $gruppo->comitato; ?>"
                 class="btn btn-inverse btn-block btn-large">
                  Seleziona un volontario... <i class="icon-pencil"></i>
              </a>
        </div>
</div>
    
</form>
