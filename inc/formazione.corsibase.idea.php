<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();
paginaModale();
paginaPresidenziale();

if (!isset($_GET['c'])) {
    redirect('formazione.corsibase.comitato');
}
$c = $_GET['c'];
$c = GeoPolitica::daOid($c);

proteggiClasse($c, $me);

?>
<form action="?p=formazione.corsibase.idea.ok" method="POST">

    <input type="hidden" name="comitato" value="<?php echo $c->oid(); ?>" />

    <div class="modal fade automodal">
        <div class="modal-header">
          <h3>Nuovo Corso Base</h3>
      </div>
      <div class="modal-body">
        <div class="alert alert-info">
          <i class="icon-pencil"></i> <strong>Alcuni campi sono obbligatori</strong>.
          <p>I campi contrassegnati dall'asterisco (*) sono obbligatori. </p>
        </div>
        <p><strong>Organizzatore</strong><br />
            <?php echo $c->nomeCompleto(); ?></p>
        <hr />
        <p>
          <strong>Informazioni</strong><br />
        </p>
        <div class="row-fluid">            
                <div class="span4 centrato">
                    <label class="control-label" for="inputDataInizio">Data inizio * </label>
                </div>
                <div class="span8">
                    <input type="text" name="inputDataInizio" id="inputDataInizio" required />
                </div>
            </div>
          
      </div>
      <div class="modal-footer">
          <a href="?p=formazione.corsibase" class="btn">Annulla</a>
          <button type="submit" class="btn btn-primary">
              <i class="icon-asterisk"></i> Crea Corso Base
          </button>
      </div>
  </div>
  
</form>
