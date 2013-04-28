<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();
paginaModale();

$attivita = $_GET['id'];
$attivita = new Attivita($attivita);

?>

<div class="modal fade automodal">
        <div class="modal-header">
          <h3 class="text-success"><i class="icon-ok"></i> Attività creata con successo</h3>
        </div>
        <div class="modal-body">
          <p class="allinea-centro grassetto">«<?php echo $attivita->nome; ?>»</p>
          <hr />
          <h4>Cosa succede ora?</h4>
          <ul>
              <li>Abbiamo mandato una email a <?php echo $attivita->referente()->nomeCompleto(); ?> dicendogli
                che ora è il referente della attività;</li><br />
              <li><strong>Non appena il referente entrerà su Gaia, gli verrà chiesto di inserire ulteriori dettagli, come:</strong>
                  <ul>
                      <li><i class="icon-time"></i> Giorni e turni;</li>
                      <li><i class="icon-globe"></i> Locazione dell'attività;</li>
                      <li><i class="icon-pencil"></i> Informazioni per i volontari;</li>
                      <li><i class="icon-group"></i> A chi è aperta l'attività;</li>
                  </ul><br />
              
              </li>
              
              <li>Se preferisci, puoi <a href="?p=attivita.modifica&id=<?php echo $attivita->id; ?>">
                      inserire tu stesso i dettagli mancanti</a> dell'attività.</li>
          </ul>
          <p class="text-error">
             <i class="icon-info-sign"></i> Non appena verranno inseriti tutti
                  i dettagli riguardanti l'attività, questa comparirà sul calendario dei volontari.
                  Potranno così richiedere di partecipare attraverso Gaia.
          </p>
              
                  
          </ul>
          
        </div>
        <div class="modal-footer">
          <a href="?p=attivita" class="btn">Torna al calendario</a>
          <!-- <button type="submit" class="btn btn-primary">
              <i class="icon-asterisk"></i> Crea attività
          </button> -->
        </div>
</div>
    