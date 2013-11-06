<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();
caricaSelettore();
caricaSelettoreComitato();
paginaModale();

?>

<form action="?p=utente.comitato.ok" method="POST">
    <div class="modal fade automodal">
        <div class="modal-header">
          <h3><i class="icon-sitemap"></i> Seleziona Comitato</h3>
        </div>
        <div class="modal-body">
           <p> Con questo modulo potrai selezionare il tuo Comitato di appartenenza</p>
            <a class="btn btn-inverse btn-small" data-selettore-comitato="true" data-input="inputComitato">
            Seleziona un comitato di destinazione... <i class="icon-pencil"></i>
            </a>
            <p>&nbsp;</p>
            <p class="text-error"><i class="icon-warning-sign"></i> Attenzione questa operazione non è reversibile </p>
           </div>
        <div class="modal-footer">
          <a href="?p=utente.me" class="btn btn-danger">Il mio comitato non è in elenco</a>
         <button type="submit" class="btn btn-success">
              <i class="icon-save"></i> Seleziona
          </button>
        </div>
    </div>
</form>
