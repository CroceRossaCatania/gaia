<?php

/*
 * ©2012 Croce Rossa Italiana
 */

paginaPrivata();

if ( !$me->email ) { redirect('nuovaAnagraficaContatti'); }
if ( !$me->password && $sessione->tipoRegistrazione = VOLONTARIO ) { redirect('nuovaAnagraficaAccesso'); }

foreach ( $me->comitatiPresidenzianti() as $comitato ) {
    if ( !$comitato->haPosizione() ) {
        redirect('presidente.wizard&forzato&oid=' . $comitato->oid());
    }
}
/* Noi siamo cattivi >:) */
// redirect('curriculum');

$attenzione = false;

$rf = $me->attivitaReferenziateDaCompletare();
if ($rf) {
    $attenzione = true;
    $attivita = $rf[0];
    ?>

<div class="modal fade automodal">
        <div class="modal-header">
          <h3 class="text-error"><i class="icon-warning-sign"></i> Attività da completare</h3>
        </div>
        <div class="modal-body">
          <p><?php echo $me->nome; ?>, sei stato selezionato come referente per l'attività:</p>
          <hr />
          <p class="allinea-centro">
              <strong><?php echo $attivita->nome; ?></strong>
              <br />
              <?php echo $attivita->area()->nomeCompleto(); ?><br />
              <span class="muted">
              <?php echo $attivita->comitato()->nomeCompleto(); ?>
              </span>
          </p>
          <hr />
          <h4>Completa i dettagli dell'attività</h4>
          <p>Devi inserire le seguenti informazioni:</strong>
                  <ul>
                      <li><i class="icon-time"></i> Giorni e turni;</li>
                      <li><i class="icon-globe"></i> Locazione dell'attività;</li>
                      <li><i class="icon-pencil"></i> Informazioni per i volontari;</li>
                      <li><i class="icon-group"></i> A chi è aperta l'attività;</li>
                  </ul><br />
           </p>
          <p class="text-error">
             <i class="icon-info-sign"></i> Non appena verranno inseriti tutti
                  i dettagli riguardanti l'attività, questa comparirà sul calendario dei volontari.
                  Potranno così richiedere di partecipare attraverso Gaia.
          </p>
              
                  
          </ul>
          
        </div>
        <div class="modal-footer">
          <a href="?p=attivita.gestione" class="btn">Non ora</a>
          <a href="?p=attivita.modifica&id=<?php echo $attivita->id; ?>" class="btn btn-primary">
              <i class="icon-asterisk"></i> Vai all'attività
          </a>
        </div>
</div>
    


<?php
}
?>

<div class="row-fluid">
    
    <div class="span3"><?php menuVolontario(); ?></div>

    <div class="span9">
        
        <h2><span class="muted">Ciao, </span><?php if($me->presiede()){?><span class="muted">Presidente</span> <?php echo $me->nome;}else{echo $me->nome;} ?>.</h2>
        
        <?php if (isset($_GET['suppok'])) { $attenzione = true; ?>
        <div class="alert alert-success">
            <h4><i class="icon-ok-sign"></i> Richiesta supporto inviata</h4>
            <p>La tua richiesta di supporto è stata inviata con successo, a breve verrai contattato da un membro dello staff.</p>        
        </div> 
        <?php } ?>
        <?php if (isset($_GET['ok'])) { $attenzione = true;  ?>
        <div class="alert alert-success">
            <i class="icon-ok"></i> <strong>Mail inviata</strong>.
            La tua mail è stata inviata con successo.
        </div> 
        <?php } ?>
        <?php if (isset($_GET['mass'])) { $attenzione = true;  ?>
        <div class="alert alert-success">
            <i class="icon-ok"></i> <strong>Mail inviate</strong>.
            Mail di massa inviata con successo.
        </div> 
        <?php } ?>
        <?php if (!$me->wizard) { $attenzione = true;  ?>
        <div class="alert alert-block alert-error">
            <h4><i class="icon-warning-sign"></i> Completa il tuo profilo</h4>
            <p>Inserisci titoli, patenti, certificazioni e competenze dalla sezione curriculum.</p>        
            <p><a href="?p=utente.titoli&t=0" class="btn btn-large"><i class="icon-ok"></i> Clicca qui per iniziare</a></p>
        </div> 
        <?php } else { ?>
        <div class="alert alert-block alert-success">
            <div class="row-fluid">
                <span class="span7">
                    <h4><i class="icon-ok"></i> Grande, hai finito!</h4>
                    <p>Quando vorrai modificare qualcosa, clicca sul pulsante per ricominciare la procedura di Modifica curriculum.</p> 
                </span>
                <span class="span5">
                    <a href="?p=utente.titoli&t=0" class="btn btn-large">
                        <i class="icon-refresh"></i>
                        Ricominciamo
                    </a>
                </span>
            </div>
        </div>
        <?php } ?>
        
        
        <?php foreach ( $me->appartenenzePendenti() as $app ) { $attenzione = true;  ?>
        <div class="alert alert-block">
            <h4><i class="icon-time"></i> In attesa di conferma</h4>
            <p>La tua appartenenza a <strong><?php echo $app->comitato()->nomeCompleto(); ?></strong> attende conferma.</p>
            <p>Successivamente riceverai una email di notifica e potrai partecipare ai servizi del comitato.</p>
            
        </div>
        <?php } ?>
        <?php 
            $h=0;
            foreach ( $patenti =  TitoloPersonale::scadenzame($me)  as $patente ) { 
                if($h!=1){  ?>
        <div class="alert alert-error">
            <h4><i class="icon-warning-sign"></i> Patente in scadenza</h4>
            <p>La tua <strong>PATENTE CRI</strong> scadrà il <strong><?php echo date('d-m-Y', $patente->fine); ?></strong></p>
        </div>
        <?php $h=1;
               }
           } ?>
        <?php 
        foreach ($me->inriserva() as $ris ){ 
            if($ris->fine >= time()){?>
        <div class="alert alert-block">
            <h4><i class="icon-pause"></i> In riserva</h4>
            <p>Sei nel ruolo di riserva fino al  <strong><?php echo date('d-m-Y', $ris->fine); ?></strong>.</p>
        </div>
        <?php }} ?>
        <?php if ($me->unComitato()->gruppi()) { 
                        if (!$me->mieiGruppi()){
                        ?>
                       <div class="alert alert-danger">
                           <div class="row-fluid">
                                <span class="span7">
                                     <h4><i class="icon-group"></i> Non sei iscritto a nessun gruppo!</h4>
                                         <p>Il tuo Comitato ha attivato i gruppi di lavoro, sei pregato di regolarizzare l'iscrizione ad un gruppo.</p>
                                </span>
                                <span class="span5">
                                    <a href="?p=utente.gruppo" class="btn btn-large">
                                        <i class="icon-group"></i>
                                            Iscriviti ora!
                                    </a>
                                </span>
                            </div>
                       </div>
        <?php }
                      } ?>
            
        <!-- Per ora mostra sempre... -->
        <div class="alert alert-block alert-info">
            <h4><i class="icon-folder-open"></i> Hai già caricato i tuoi documenti?</h4>
            <p>Ricordati di caricare i tuoi documenti dalla sezione <strong>Documenti</strong>.</p>
            
        </div>
        
        
    </div>
</div>

<?php
if ( !$attenzione && $me->comitatiDiCompetenza() ) {
    redirect('presidente.dash');
}
?>