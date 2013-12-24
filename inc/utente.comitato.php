<?php

/*
 * ©2013 Croce Rossa Italiana
 */

if($me->appartenenzaValida()) {
  redirect('errore.permessi');
}

paginaPrivata();
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
      <ol>
        <li>
          <a class="btn btn-inverse btn-small" data-selettore-comitato="true" data-input="inputComitato">
          Seleziona un comitato di destinazione... <i class="icon-pencil"></i>
          </a><p></p>
        </li>
        <li>
          <input class="allinea-sinistra input-medium" placeholder="Data ingresso in CRI" type="text" name="dataIngresso" id="dataIngresso" required>
        </li>
            <p>&nbsp;</p>
            <p class="text-error"><i class="icon-warning-sign"></i> Attenzione questa operazione non è reversibile </p>
           </div>
        <div class="modal-footer">
          <a href="?p=public.nocomitato" class="btn btn-danger"><i class="icon-remove"></i> Il mio comitato non è in elenco</a>
         <button type="submit" class="btn btn-success">
              <i class="icon-save"></i> Seleziona
          </button>
        </div>
    </div>
</form>
