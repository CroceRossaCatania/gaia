<?php

/*
 * ©2012 Croce Rossa Italiana
 */

paginaPrivata();

if ( !$me->email ) { redirect('nuovaAnagraficaContatti'); }
if ( !$me->password && $sessione->tipoRegistrazione = VOLONTARIO ) { redirect('nuovaAnagraficaAccesso'); }

/* Noi siamo cattivi >:) */
// redirect('curriculum');

?>

<hr />
<div class="row-fluid">
    
    <div class="span3"><?php menuVolontario(); ?></div>

    <div class="span9">
        
        <h2><span class="muted">Ciao, </span><?php if($me->presiede()){?><span class="muted">Presidente</span> <?php echo $me->nome;}else{echo $me->nome;} ?>.</h2>
        
        <?php if (!$me->wizard) { ?>
        <div class="alert alert-block alert-error">
            <h4><i class="icon-warning-sign"></i> Completa il tuo profilo</h4>
            <p>Inserisci titoli, patenti, certificazioni e competenze dalla sezione curriculum.</p>        
            <p><a href="?p=titoli&t=0" class="btn btn-large"><i class="icon-ok"></i> Clicca qui per iniziare</a></p>
        </div> 
        <?php } else { ?>
        <div class="alert alert-block alert-success">
            <div class="row-fluid">
                <span class="span7">
                    <h4><i class="icon-ok"></i> Grande, hai finito!</h4>
                    <p>Quando vorrai modificare qualcosa, clicca sul pulsante per ricominciare la procedura di Modifica curriculum.</p> 
                </span>
                <span class="span5">
                    <a href="?p=titoli&t=0" class="btn btn-large">
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
            <p>La tua appartenenza a <strong><?php echo $app->comitato()->nome; ?></strong> attende conferma.</p>
            <p>Successivamente riceverai una email di notifica e potrai partecipare ai servizi del comitato.</p>
            
        </div>
        <?php } ?>
        
    
    </div>
    
    
    
    <!-- Rimosso in seguito a discussione email... [[[
        <div class="span9">
           <div class="row-fluid">
               
               <h4>Clicca sul riquadro per inserire le relative voci richieste</h4>
                <div class="row-fluid centrato">
                    <div onclick="window.location='?p=titoli&t=2';" style="cursor: pointer;" class="span6 alert alert-block alert-info">
                        <h4><i class="icon-ambulance"></i> Patenti CRI</h4>
                        <p>Patenti di Croce Rossa.</p>
                        <p>Es.: <code>Patente CRI1</code>, <code>Patente CRI2</code>.</p>
                   </div>
                    <div onclick="window.location='?p=titoli&t=0';" style="cursor: pointer;" class="span6 alert alert-block alert-warning">
                        <h4><i class="icon-magic"></i> Competenze personali</h4>
                        <p>Per cosa sei portato? In cosa sei bravo?<br />Competenze professionali od hobbistiche.</p>
                        <p>Es.: <code>Informatica</code>, <code>Cucina</code>, <code>Pedagogia</code>.</p>
                    </div>
                </div>
                <div class="row-fluid centrato">

                    <div onclick="window.location='?p=titoli&t=3';" style="cursor: pointer;" class="span6 alert alert-block alert-error">
                        <h4><i class="icon-beaker"></i> Titoli di studio</h4>
                        <p>Diplomi, lauree e corsi che hai fatto.</p>
                        <p>Es.: <code>Liceo Scientifico</code>, <code>Laurea in Legge</code>.</p>
                    </div>

                    <div onclick="window.location='?p=titoli&4';" style="cursor: pointer;" class="span6 alert alert-block alert-success">
                        <h4><i class="icon-plus-sign-alt"></i> Titoli CRI</h4>
                        <p>I titoli che hai ottenuto in Croce Rossa.</p>
                        <p>Es.: <code>Corso Base BEPS</code>, <code>PSTI</code>.</p>
                    </div>
                </div>
            </div>


            
        </div>
    
        ]]] -->
      
    
</div>

