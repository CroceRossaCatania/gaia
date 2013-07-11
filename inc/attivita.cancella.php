<?php

/*
 * ©2013 Croce Rossa Italiana
 */

$a = new Attivita($_GET['id']);
paginaAttivita($a);

?>



<div class="modal fade automodal">
        <div class="modal-header">
          <h3>
              <i class="icon-warning-sign"></i>
              Elimina l'Attività
          </h3>
        </div>
        <div class="modal-body">
            <p class='allinea-centro'>Cancellazione dei dati relativi a:<br />
                «<big><?php echo $a->nome; ?></big>»</p>
          <hr />
          
          <p class="text-error">
              <i class="icon-warning-sign"></i> <strong>Attenzione</strong> &mdash;
              Eliminando l'attività, verranno rimossi completamente:
                <ul>
                    <li>Tutti i turni passati e futuri;</li>
                    <li>Le partecipazioni dei volontari, anche dai loro fogli di servizio;</li>
                    <li>Le autorizzazioni richieste, accettate e negate.</li>
                </ul>
                Una volta eliminata, non sarà possibile recuperare le informazioni.
              
          </p>
          <p>
              <strong><i class='icon-calendar'></i> Per eliminare un singolo turno</strong>,
              puoi usare la pagina di <a href='?p=attivita.turni&id=<?= $a->id; ?>'>gestione dei turni</a>.
          </p>
        </div>
        <div class="modal-footer">
          <a href="?p=attivita.scheda&id=<?php echo $a->id; ?>" class="btn">Annulla</a>
          <a href='?p=attivita.cancella.ok&id=<?php echo $a->id; ?>' class="btn btn-danger">
              <i class="icon-trash"></i> Elimina definitivamente
          </a>
        </div>
</div>