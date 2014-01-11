<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();
paginaModale();

controllaParametri(array('id'));
$id = $_GET['id'];
$corsoBase = CorsoBase::id($id);

paginaCorsoBase($corsoBase);

?>

<div class="modal fade automodal">
  <div class="modal-header">
    <h3 class="text-success"><i class="icon-ok"></i> Corso Base creato con successo</h3>
  </div>
  <div class="modal-body">
    <p class="allinea-centro grassetto">«<?php echo $corsoBase->nome(); ?>»</p>
    <hr />
    <h4>Cosa succede ora?</h4>
    <ul>
      <li>Abbiamo mandato una email a <?php echo $corsoBase->direttore()->nomeCompleto(); ?> dicendogli
        che ora è il direttore del corso base;</li><br />
        <li><strong>Non appena il direttore entrerà su Gaia, gli verrà chiesto di inserire ulteriori dettagli, come:</strong>
          <ul>
            <li><i class="icon-time"></i> Lezioni;</li>
            <li><i class="icon-globe"></i> Luogo di svolgimento del corso;</li>
            <li><i class="icon-pencil"></i> Informazioni per gli aspiranti volontari.</li>
          </ul><br />
          
        </li>
        
        <li>Se preferisci, puoi <a href="?p=formazione.corsibase.modifica&id=<?php echo $attivita->id; ?>">
          inserire tu stesso i dettagli mancanti</a> del corso.</li>
        </ul>
        
       
       
     </ul>
     
   </div>
   <div class="modal-footer">
    <a href="?p=formazione.corsibase" class="btn">Torna ai corsi</a>
          <!-- <button type="submit" class="btn btn-primary">
              <i class="icon-asterisk"></i> Crea attività
            </button> -->
          </div>
        </div>
        