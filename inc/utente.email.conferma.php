<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();
paginaModale();
$sessione->email = minuscolo($_POST['inputEmail']);
$sessione->emailServizio = minuscolo($_POST['inputemailServizio']);
?>

<form action="?p=utente.email.ok" method="POST">
    <div class="modal fade automodal">
        <div class="modal-header">
          <h3><i class="icon-envelope"></i> Cambia indirizzo email</h3>
        </div>
        <div class="modal-body">
           <p> Ti chiediamo di inserire la tua password per cambiare il tuo indirizzo email </p>
            <div class="row-fluid">
              <div class="span4 allinea-centro">
                <label class="control-label" for="inputPassword">Password </label>
              </div>  
              <div class="span7">
                  <span class="add-on"><i class="icon-key"></i></span>
                  <input type="password" id="inputPassword" name="inputPassword" required pattern=".{6,15}" />
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <a href="?p=utente.email" class="btn">Annulla</a>
         <button type="submit" class="btn btn-success">
              <i class="icon-save"></i> Salva cambiamenti
          </button>
        </div>
    </div>
</form>
