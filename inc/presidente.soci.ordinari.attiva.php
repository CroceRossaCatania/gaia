<?php

paginaApp([APP_SOCI , APP_PRESIDENTE ]);
paginaPrivata();
paginaModale();
controllaParametri(['id'], 'presidente.soci.ordinari&err');

$u = Utente::id($_GET['id']);

proteggiDatiSensibili($u, [APP_SOCI , APP_PRESIDENTE]);

if(!$u->modificabileDa($me)) {
    redirect('errore.permessi&cattivo');
}

$data = $u->appartenenzaAttuale()->inizio();

?>

<form action="?p=presidente.soci.ordinari.attiva.ok" method="POST">
    <input type='hidden' name='id' value='<?= $u; ?>'>
    <div class="modal fade automodal">
        <div class="modal-header">
            <h3>Attiva il Socio Ordinario <?= $u->nomeCompleto(); ?></h3>
        </div>
        <div class="modal-body">
            <div class="row-fluid">
                <div class="alert alert-info">
                Stai modificando lo stato di un <strong>Socio Ordinario</strong> in <strong>Socio Attivo</strong>, ricorda che questo passaggio può avvenire
                solo a seguito del superamento di un <strong>Corso Base per Volontari CRI</strong>.
                <br />
                Per completare questa procedura ti basterà inserire di seguito la data corretta del passaggio.
                <br />
                Una volta attivato il Volontario potrà utilizzare Gaia per tutte le funzionalità previste.
            </div>


            <div class="row-fluid">            
                <div class="span4 centrato">
                    <label class="control-label" for="inputData" >Data passaggio </label>
                </div>
                <div class="span8">
                    <input type="text" name="inputData" id="inputData" required data-min="<?= $data->format('d/m/Y'); ?>" />
                </div>
            </div>    

            <p>Attenzione, questa operazione non è facilmente reversibile!</p>            

            </div>
        </div>
        <div class="modal-footer">
            <a href="?p=presidente.soci.ordinari" class="btn">Chiudi</a>
            <button type="submit" class="btn btn-success" >
                <i class="icon-star"></i> Attiva
            </button>
        </div>
    </div>
</form>
