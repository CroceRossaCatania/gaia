        <form action="?p=formazione.corsi.crea.ok" method="POST">
            <input value="<?php echo @$a->id ?>" name="id" type="hidden">
            <div class="alert alert-block alert-success">
                <div class="row-fluid">
                    <h4><i class="icon-question-sign"></i> Dati del corso...</h4>
                </div>
                <hr>
                <div class="row-fluid">
                    <div class="span4">
                        <label for="organizzatore"><i class="icon-user-md"></i> Comitato organizzatore</label>
                    </div>
                    <div class="span8">
                        <select name="organizzatore">
                            <?php foreach ($comitati as $t) { ?>
                                <option value="<?php echo $t->id ?>"><?php echo $t->nome ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4">
                        <label for="tipologia"><i class="icon-certificate"></i> Tipologia</label>
                    </div>
                    <div class="span8">
                        <select name="certificato">
                            <?php foreach ($certificati as $t) { ?>
                                <option value="<?php echo $t->id ?>"><?php echo $t->nome ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4">
                        <label for="tipologia"><i class="icon-building"></i> Luogo</label>
                    </div>
                    <div class="span8">
                        <input id="luogo" class="span12" name="luogo" value="" type="text">
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4">
                        <label for="dataInizio"><i class="icon-calendar"></i> Data Di inizio</label>
                    </div>
                    <div class="span8">
                        <input id="dataInizio" class="span12 hasDatepicker" name="inizio" value="" type="text">
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4">
                        <label for="partecipanti"><i class="icon-calendar"></i> Numero Partecipanti</label>
                    </div>
                    <div class="span8">
                        <input id="partecipanti" class="span12 hasDatepicker" name="partecipanti" value="" type="text">
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4">
                        <label for="descrizione"><i class="icon-text"></i> Descrizione</label>
                    </div>
                    <div class="span8">
                        <textarea id="descrizione" class="span12" name="descrizione"></textarea>
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
