<?php

/*
* ©2013 Croce Rossa Italiana
*/

caricaSelettoreComitato();

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
            <label class="control-label" for="inputAnno">Anno di ingresso</label>
            <div class="controls">
                <select required name="inputAnno" class="span6">
                <?php for ( $i = date('Y'); $i >= 1900; $i-- ) { ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php } ?>
                </select>
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