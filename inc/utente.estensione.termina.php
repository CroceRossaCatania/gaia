<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();
paginaModale();

controllaParametri(array('id'));

$id = $_GET['id'];
$app = Appartenenza::id($id);
$est = Estensione::by('appartenenza', $app);
?>

<form action="?p=utente.estensione.termina.ok" method="POST">
    <input type="hidden" name="id" value="<?= $est->id; ?>" />
    <div class="modal fade automodal">
        <div class="modal-header">
          <h3><i class="icon-stop"></i> Termina Estensione</h3>
        </div>
        <div class="modal-body">
           <p> Con questo modulo potrai terminare la tua estensione presso il <strong><?= $app->comitato()->nomeCompleto(); ?></strong> </p>
           <p> Inoltre verranno eseguite le seguenti azioni: </p>
           <ul>
               <li>
                Chiusura delle deleghe sul Comitato in estensione
               </li>
               <li>
                Chiusura delle attività di cui sei referente
               </li>
               <li>
                La gestione dei gruppi di lavoro passa al Presidente
               </li>
              <li>
                Chiusura delle appartenenze ai gruppi di lavoro a cui ti sei iscritto
              </li>
              <li>
                Chiusura delle reperibilità
              </li>
              <li>
                Chiusura di eventuali partecipazioni ad attività e turni per i quali hai dato disponibilità
              </li>
           </ul>
           <p class="text-error"><i class="icon-warning-sign"></i> Attenzione questa operazione non è reversibile </p>
           <p>&nbsp;</p>
        </div>
        <div class="modal-footer">
          <a href="?p=utente.storico" class="btn">Annulla</a>
         <button type="submit" class="btn btn-primary">
              <i class="icon-stop"></i> Termina Estensione
          </button>
        </div>
    </div>
</form>
