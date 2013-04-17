<?php

/*
 * ©2012 Croce Rossa Italiana
 */

paginaPrivata();

if ( !$me->email ) { redirect('nuovaAnagraficaContatti'); }
if ( !$me->password && $sessione->tipoRegistrazione = VOLONTARIO ) { redirect('nuovaAnagraficaAccesso'); }

foreach ( $me->comitatiPresidenzianti() as $comitato ) {
    if ( !$comitato->haPosizione() ) {
        redirect('presidente.wizard&forzato&id=' . $comitato->id);
    }
}
/* Noi siamo cattivi >:) */
// redirect('curriculum');

?>

<div class="row-fluid">
    
    <div class="span3"><?php menuVolontario(); ?></div>

    <div class="span9">
        
        <h2><span class="muted">Ciao, </span><?php if($me->presiede()){?><span class="muted">Presidente</span> <?php echo $me->nome;}else{echo $me->nome;} ?>.</h2>
        
        <?php if (isset($_GET['suppok'])) { ?>
        <div class="alert alert-success">
            <h4><i class="icon-ok-sign"></i> Richiesta supporto inviata</h4>
            <p>La tua richiesta di supporto è stata inviata con successo, a breve verrai contattato da un membro dello staff.</p>        
        </div> 
        <?php } ?>
        <?php if (isset($_GET['ok'])) { ?>
        <div class="alert alert-success">
            <i class="icon-ok"></i> <strong>Mail inviata</strong>.
            La tua mail è stata inviata con successo.
        </div> 
        <?php } ?>
        <?php if (!$me->wizard) { ?>
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
        
        
        <?php foreach ( $me->appartenenzePendenti() as $app ) { ?>
        <div class="alert alert-block">
            <h4><i class="icon-time"></i> In attesa di conferma</h4>
            <p>La tua appartenenza a <strong><?php echo $app->comitato()->nomeCompleto(); ?></strong> attende conferma.</p>
            <p>Successivamente riceverai una email di notifica e potrai partecipare ai servizi del comitato.</p>
            
        </div>
        <?php } ?>
        <?php 
        foreach ($me->inriserva() as $ris ){
            if($ris->fine >= time()){?>
        <div class="alert alert-block">
            <h4><i class="icon-pause"></i> In riserva</h4>
            <p>Sei nel ruolo di riserva fino al  <strong><?php echo date('d-m-Y', $ris->fine); ?></strong>.</p>
        </div>
        <?php }} ?>
            
        <!-- Per ora mostra sempre... -->
        <div class="alert alert-block alert-info">
            <h4><i class="icon-folder-open"></i> Hai già caricato i tuoi documenti?</h4>
            <p>Ricordati di caricare i tuoi documenti dalla sezione <strong>Documenti</strong>.</p>
            
        </div>
        
        
    </div>
</div>

