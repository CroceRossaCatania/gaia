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
$v = $est->volontario();
if ( $me != $v and !$v->modificabileDa($me) ) {
  redirect('errore.permessi&cattivo');
}

?>

<form action="?p=utente.estensione.termina.ok" method="POST">
    <input type="hidden" name="id" value="<?= $est->id; ?>" />
    <div class="modal fade automodal">
        <div class="modal-header">
          <h3><i class="icon-stop"></i> Termina Estensione</h3>
        </div>
        <div class="modal-body">

        <?php if ( $me == $v ) { ?>
           <p> Con questo modulo potrai terminare la tua estensione presso il <strong><?= $app->comitato()->nomeCompleto(); ?></strong> </p>
        <?php } else { ?>
           <p> Con questo modulo potrai terminare l'estensione di <strong><?= $v->nomeCompleto(); ?> presso il <strong><?= $app->comitato()->nomeCompleto(); ?></strong> </p>
        <?php } ?>

           <p> Inoltre verranno eseguite le seguenti azioni: </p>
           <ul>
               <li>
                Chiusura delle deleghe sul Comitato in estensione
               </li>
               <li>
                Chiusura delle attività di cui si &egrave; referente
               </li>
               <li>
                La gestione dei gruppi di lavoro passa al Presidente
               </li>
              <li>
                Chiusura delle appartenenze ai gruppi di lavoro a cui ci si &egrave; iscritti
              </li>
              <li>
                Chiusura delle reperibilità
              </li>
              <li>
                Chiusura di eventuali partecipazioni ad attività e turni per i quali &egrave; stata data disponibilità
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
