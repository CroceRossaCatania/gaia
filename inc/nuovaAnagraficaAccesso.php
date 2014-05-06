<?php

/*
* ©2013 Croce Rossa Italiana
*/

caricaSelettoreComitato();
paginaPrivata();
if ($sessione->utente()->unComitato(SOGLIA_APPARTENENZE)) {
    redirect('errore.permessi&cattivo');
} elseif ($sessione->utente()->ordinario()) {
    redirect('utente.me');
}

?>

<hr />
<?php if ( isset($_GET['esistente'] ) ) { ?>
    <div class="alert alert-success">
    <h4>Stai completando la tua registrazione</h4>
    <p>La tua anagrafica è già presente sul nostro database. Ultima la registrazione.</p>
    </div>
<?php } ?>


<div class="row-fluid">
    <div class="span4">
        <h2>
            <i class="icon-group"></i>
            Comitato
        </h2>
        <p>Seleziona il comitato del quale fai parte.</p>
        <p>Seleziona la data di ingresso. È necessario inserire almeno l'anno. </p>
        <p>La tua iscrizione verrà confermata da un vertice del tuo comitato.</p>
    </div>
    <div class="span8">
    <?php if (isset($_GET['c'])) { ?>
        <div class="alert alert-block alert-error">
            <h4>Seleziona il tuo comitato di appartenenza</h4>
            <p>Clicca sul pulsante e seleziona la tua unità di appartenenza.</p>
            <p>Verrà chiesta conferma al Presidente del comitato.</p>
        </div>
    <?php } ?>
    <?php if (isset($_GET['data'])) { ?>
        <div class="alert alert-block alert-error">
            <h4>Data di ingresso in Croce Rossa errata</h4>
            <p>La data di inggresso in Croce Rossa che hai inserito non è corretta.</p>
            <p>Il formato corretto della data di ingresso è gg/mm/aaaa.</p>
        </div>
      <?php } ?>
      <?php if (isset($_GET['err'])) { ?>
          <div class="alert alert-block alert-error">
              <h4><i class="icon-warning-sign"></i> <strong>Qualcosa non ha funzionato</strong>.</h4>
              <p>L'operazione che stavi tentando di eseguire non è andata a buon fine. Per favore riprova.</p>
          </div> 
      <?php } ?>
    <form id="moduloRegistrazione" class="form-horizontal" action="?p=nuovaAnagraficaAccesso.ok" method="POST">
        <div class="control-group">
            <label class="control-label" for="inputComitato">Comitato</label>
            <div class="controls">

                <a class="btn btn-primary" data-selettore-comitato="true" data-input="inputComitato">
                    <i class="icon-warning-sign"></i> Seleziona il comitato...
                </a>

            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="inputDataIngresso">Data ingresso</label>
            <div class="controls">
              <input value="<?php echo $sessione->inizio; ?>" class="input-small" type="text" id="inputDataIngresso" name="inputDataIngresso" required />
            </div>
        </div>

        <hr />
        <div class="control-group btn-group">
            <a href="?p=public.nocomitato&rege" class="btn btn-large btn-danger">
                <i class="icon-remove"></i>
                Il mio Comitato non è in lista
            </a>
            <button type="submit" class="btn btn-large btn-success">
                <i class="icon-ok"></i>
                Completa registrazione
            </button>
        </div>
    </form>

    </div>
</div>