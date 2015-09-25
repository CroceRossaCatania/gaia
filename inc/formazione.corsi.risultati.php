<?php
/*
 * ©2015 Croce Rossa Italiana
 */
paginaPrivata();

controllaParametri(['id'], 'admin.corsi.crea&err');

// try catch da usare per evitare stampa dell'errore e poter fare redirect 
$id = intval($_GET['id']);
try {
    $c = Corso::id($id);
    if (empty($c)) {
        throw new Exception('Manomissione');
    }
    $certificato = Certificato::by('id', intval($c->certificato));

} catch(Exception $e) {
    redirect('admin.corsi.crea&err');
}

/*
if (!$c->modificabile()) {
    redirect('formazione.corsi.riepilogo&id='.$id);
}
*/


$discenti = PartecipazioneCorso::filtra([
    ['corso', $c->id],
    ['ruolo', CORSO_RUOLO_DISCENTE],
    ['stato', PARTECIPAZIONE_ACCETTATA]
]);

$affiancamenti = PartecipazioneCorso::filtra([
    ['corso', $c->id],
    ['ruolo', CORSO_RUOLO_AFFIANCAMENTO],
    ['stato', PARTECIPAZIONE_ACCETTATA]
]);

$docenti = PartecipazioneCorso::filtra([
    ['corso', $c->id],
    ['ruolo', CORSO_RUOLO_DOCENTE],
    ['stato', PARTECIPAZIONE_ACCETTATA]
]);

caricaSelettoreDiscente();

$d = new DateTime('@' . $c->inizio);

?>

<div class="row-fluid">

    <div class="span8">
        <h2><i class="icon-plus-square icon-calendar muted"></i> Corso di formazione</h2>
        <form action="?p=formazione.corsi.risultati.ok" method="POST">
            <input type="hidden" name="id" value="<?php echo $id ?>" />
            <div class="alert alert-block alert-success">
                <div class="row-fluid">
                    <h4>Valutazioni per <?php echo $certificato->nome ?> del <?php echo $d->format('d/m/Y'); ?></h4>
                    <p><i class="icon-exclamation-triangle"></i><strong>Compilare con attenzione</strong>, una volta compilato il modulo, questi dati non saranno più modificabili</p>
                </div>
                <hr>
                <div class="row-fluid">
                    <h3>Discenti</h3>
                </div>
                <div class="row-fluid">
                    <div class="span3"><label>Nome</label></div>
                    <div class="span2"><label>Idoneità</label></div>
                    <div class="span2"><label>Affiancamenti</label></div>
                    <div class="span5"><label>Segnalazione</label></div>
                </div>
                <?php foreach ($discenti as $d) { 
                    ?>
                    <div class="row-fluid">
                        <div class="span3">
                            <label for="dataFine"><i class="icon-user"></i> <?php echo $d->volontario()->nome ?><br/><?php echo $d->volontario()->cognome ?></label>
                        </div>
                        <div class="span2">
                            <select name="discIdoneita[<?php echo $d->volontario()->id ?>]" class="input-block-level" required="true">
                                <option value="<?php echo CORSO_RISULTATO_NESSUNO ?>">...</option>
                                <option value="<?php echo CORSO_RISULTATO_NON_IDONEO ?>"><?php echo $conf['risultato'][CORSO_RISULTATO_NON_IDONEO] ?></option>
                                <option value="<?php echo CORSO_RISULTATO_IDONEO ?>"><?php echo $conf['risultato'][CORSO_RISULTATO_IDONEO] ?></option>
                            </select>
                        </div>
                        <div class="span2">
                            <select name="discAffiancamenti[<?php echo $d->volontario()->id ?>]" class="input-block-level" required="true">
                                <option value="0">Nessuno</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                        <div class="span5">
                            <select name="discSegnalazioni[<?php echo $d->volontario()->id ?>][]" class="chosen-select" multiple="" data-placeholder="Aggiungi segnalatori">
                                <option value=""></option>
                            <?php foreach ($docenti as $i) { 
                                $v = $i->volontario();
                                ?>
                                <option value="<?php echo $v->id?>"><?php echo $v->nomeCompleto() ?></option>
                            <?php } ?>
                            </select>
                        </div>
                    </div>
                    <?php
                } ?>
                <div class="row-fluid">
                    <h3>Affiancamenti</h3>
                </div>
                <div class="row-fluid">
                    <div class="span3"><label>Nome</label></div>
                    <div class="span2"><label>Idoneità</label></div>
                </div>
                <?php foreach ($affiancamenti as $a) { 
                    ?>
                    <div class="row-fluid">
                        <div class="span3">
                            <label for="dataFine"><i class="icon-user"></i> <?php echo $a->volontario()->nome ?><br/><?php echo $a->volontario()->cognome ?></label>
                        </div>
                        <div class="span2">
                            <select name="affIdoneita[<?php echo $a->volontario()->id ?>]" class="input-block-level" required="true">
                                <option value="<?php echo CORSO_RISULTATO_NESSUNO ?>">...</option>
                                <option value="<?php echo CORSO_RISULTATO_NON_IDONEO ?>"><?php echo $conf['risultato'][CORSO_RISULTATO_NON_IDONEO] ?></option>
                                <option value="<?php echo CORSO_RISULTATO_IDONEO ?>"><?php echo $conf['risultato'][CORSO_RISULTATO_IDONEO] ?></option>
                            </select>
                        </div>
                    </div>
                    <?php
                } ?>
                <div class="row-fluid">
                    <div class="span4 offset4">
                        <button type="submit" class="btn btn-success">
                            <i class="icon-ok"></i>
                            Procedi
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="span4">
        <h4 style="line-height:40px">Azioni</h4>
        <nav>
            <ul style="list-style-type: none">
                <li>
                    <a class="btn btn-danger" href="?p=utente.me">
                        <i class="icon-plus-sign-alt icon-large"></i>&nbsp;
                        Eliminare
                    </a>
                </li>
                <li>
                    <a class="btn btn-danger" href="?p=utente.me">
                        <i class="icon-plus-sign-alt icon-large"></i>&nbsp;
                        Convalidare
                    </a>
                </li>
                <li>
                    <a class="btn btn-danger" href="?p=utente.me">
                        <i class="icon-plus-sign-alt icon-large"></i>&nbsp;
                        richiedi iscrizione
                    </a>
                </li>
                <li>
                    <a class="btn btn-danger" href="?p=utente.me">
                        <i class="icon-plus-sign-alt icon-large"></i>&nbsp;
                        chiudi corso -> valutazione
                    </a>
                </li>
            </ul>
        </nav>

    </div>
</div>