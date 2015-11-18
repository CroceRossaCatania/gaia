<?php
/*
 * ©2014 Croce Rossa Italiana
 */

$_titolo = "Nuova Giornata di Corsi";
?>

<br/><br/>
<div class="row-fluid">
    <h2><i class="icon-plus-square icon-calendar muted"></i> Nuova Giornata Corso</h2>
    <form action="?p=formazione.corsi.giornataCorso.nuovo.ok" method="POST">

        <div class="span8">
            <div class="row-fluid">
                <div class="span4">
                    <label for="sequenziale"><i class="icon-building"></i> Sequenziale</label>: 
                </div>
                <div class="span8">
                    <input id="sequenziale" class="span12" name="sequenziale" value="<?php echo @$c->sequenziale ?>" type="text">
                </div>
            </div>
            <div class="row-fluid">
                <div class="span4">
                    <label for="titolo"><i class="icon-building"></i> Titolo</label>
                </div>
                <div class="span8">
                    <input id="titolo" class="span12" name="titolo" value="<?php echo @$c->titolo ?>" type="text">
                </div>
            </div>
            <div class="row-fluid">
                <div class="span4">
                    <label for="tipologia"><i class="icon-building"></i> Luogo</label>
                </div>
                <div class="span8">
                    <input id="luogo" class="span12" name="luogo" value="<?php echo @$c->luogo ?>" type="text">
                </div>
            </div>
            <div class="row-fluid">
                <div class="span4">
                    <label for="dataInizio"><i class="icon-calendar"></i> Data Di inizio</label>
                </div>
                <div class="span8">
                    <input id="dataInizio" class="span12 hasDatepicker" name="inizio" value="<?php echo ($c) ? (new DT('@' . $c->inizio))->format('d/m/Y H:i') : '' ?>" type="text">
                </div>
            </div>
            <div class="row-fluid">
                <div class="span4">
                    <label for="note"><i class="icon-calendar"></i> Note</label>
                </div>
                <div class="span8">
                    <textarea id="note" name="note">

                    </textarea>
                </div>
            </div>

            <div class="row-fluid">
                <div class="span4 offset4">
                    <button type="submit" class="btn btn-success">
                        <i class="icon-ok"></i>
                        Crea il corso
                    </button>
                </div>
            </div>
        </div>

    </form>

    <div class="span4">

    </div>

</div>