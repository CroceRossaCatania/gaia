<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

$f = $_GET['id'];
$t = Utente::by('id',$f);
?>
<div class="row-fluid">
    <div class="span3">
        <?php        menuVolontario(); ?>
    </div>
    <div class="span9">
        <h2><i class="icon-envelope muted"></i> Invio Mail</h3>
        <div class="alert alert-block alert-info">
            <h4><i class="icon-question-sign"></i> Pronto a mandare la mail ?</h4>
            <p>Modulo per l'invio mail agli utenti di Gaia</p>
        </div>
         <div class="alert alert-block alert-error">
                    <h4><i class="icon-warning-sign"></i> Dedicaci due minuti prima di invia questa email</h4>
                    <p>Ti ricordiamo che l'invio di email attraverso GAIA è consentito <b>esclusivamente</b> per comunicazioni di servizio (attività, assemblee, etc.).</p>        
                    <p>Non è consentito inviare email di massa per altri scopi <b>(es. auguri di Natale, etc)</b> l'uso improprio comporterà la disabilitazione di questa funzione. </p>
        </div>
        <?php if (isset($_GET['mass'])) { ?><form class="form-horizontal" action="?p=utente.mail.nuova.ok&mass&t=<?php echo $_GET['t']; ?>" method="POST">
        <?php }elseif (isset($_GET['com'])) { ?><form class="form-horizontal" action="?p=utente.mail.nuova.ok&com" method="POST">
        <?php }elseif (isset($_GET['unit'])) { ?><form class="form-horizontal" action="?p=utente.mail.nuova.ok&id=<?php echo $f; ?>&unit" method="POST">
        <?php }elseif (isset($_GET['comgio'])) { ?><form class="form-horizontal" action="?p=utente.mail.nuova.ok&comgio" method="POST">
        <?php }elseif (isset($_GET['unitgio'])) { ?><form class="form-horizontal" action="?p=utente.mail.nuova.ok&id=<?php echo $f; ?>&unitgio" method="POST">
        <?php }elseif (isset($_GET['comquoteno'])) { ?><form class="form-horizontal" action="?p=utente.mail.nuova.ok&comquoteno" method="POST">
        <?php }elseif (isset($_GET['comquotenoordinari'])) { ?><form class="form-horizontal" action="?p=utente.mail.nuova.ok&comquotenoordinari" method="POST">
        <?php }elseif (isset($_GET['unitquoteno'])) { ?><form class="form-horizontal" action="?p=utente.mail.nuova.ok&unitquoteno&id=<?php echo $f; ?>" method="POST">
        <?php }elseif (isset($_GET['unitquotenoordinari'])) { ?><form class="form-horizontal" action="?p=utente.mail.nuova.ok&unitquotenoordinari&id=<?php echo $f; ?>" method="POST">
        <?php }elseif (isset($_GET['comeleatt'])) { ?><form class="form-horizontal" action="?p=utente.mail.nuova.ok&comeleatt&time=<?php echo $_GET['time']; ?>" method="POST">   
        <?php }elseif (isset($_GET['uniteleatt'])) { ?><form class="form-horizontal" action="?p=utente.mail.nuova.ok&uniteleatt&time=<?php echo $_GET['time']; ?>&id=<?php echo $f; ?>" method="POST">
        <?php }elseif (isset($_GET['unitelepass'])) { ?><form class="form-horizontal" action="?p=utente.mail.nuova.ok&unitelepass&time=<?php echo $_GET['time']; ?>&id=<?php echo $f; ?>" method="POST">
        <?php }elseif (isset($_GET['gruppo'])) { ?><form class="form-horizontal" action="?p=utente.mail.nuova.ok&gruppo&id=<?php echo $f; ?>" method="POST">
        <?php }elseif (isset($_GET['estesi'])) { ?><form class="form-horizontal" action="?p=utente.mail.nuova.ok&estesi&id=<?php echo $f; ?>" method="POST">
        <?php }elseif (isset($_GET['estensione'])) { ?><form class="form-horizontal" action="?p=utente.mail.nuova.ok&estensione&id=<?php echo $f; ?>" method="POST">
        <?php }elseif (isset($_GET['riserva'])) { ?><form class="form-horizontal" action="?p=utente.mail.nuova.ok&riserva&id=<?php echo $f; ?>" method="POST">
        <?php }elseif (isset($_GET['zeroturnicom'])) { ?><form class="form-horizontal" action="?p=utente.mail.nuova.ok&zeroturnicom&time=<?php echo $_GET['time']; ?>" method="POST">
        <?php }elseif (isset($_GET['zeroturniunit'])) { ?><form class="form-horizontal" action="?p=utente.mail.nuova.ok&zeroturniunit&id=<?php echo $_GET['id']; ?>&time=<?php echo $_GET['time']; ?>" method="POST">
        <?php }elseif (isset($_GET['ordinariunit'])) { ?><form class="form-horizontal" action="?p=utente.mail.nuova.ok&ordinariunit&id=<?php echo $f; ?>" method="POST">
        <?php }elseif (isset($_GET['ordinaricom'])) { ?><form class="form-horizontal" action="?p=utente.mail.nuova.ok&ordinaricom" method="POST">
        <?php }elseif (isset($_GET['ordinaridimessiunit'])) { ?><form class="form-horizontal" action="?p=utente.mail.nuova.ok&ordinaridimessiunit&id=<?php echo $f; ?>" method="POST">
        <?php }elseif (isset($_GET['ordinaridimessicom'])) { ?><form class="form-horizontal" action="?p=utente.mail.nuova.ok&ordinaridimessicom" method="POST">
        <?php }else{ ?> <form class="form-horizontal" action="?p=utente.mail.nuova.ok" method="POST"><?php } ?>

 <?php if (isset($_GET['mass']) 
            || isset($_GET['com']) 
            || isset($_GET['unit']) 
            || isset($_GET['comgio']) 
            || isset($_GET['unitgio'])
            || isset($_GET['comquoteno'])
            || isset($_GET['comquotenoordinari'])
            || isset($_GET['comquotesi'])
            || isset($_GET['unitquoteno'])
            || isset($_GET['unitquotenoordinari'])
            || isset($_GET['unitquotesi'])
            || isset($_GET['comeleatt'])
            || isset($_GET['uniteleatt'])
            || isset($_GET['unitelepass'])
            || isset($_GET['gruppo'])
            || isset($_GET['estesi'])
            || isset($_GET['estensione'])
            || isset($_GET['riserva']) 
            || isset($_GET['zeroturnicom']) 
            || isset($_GET['zeroturniunit'])
            || isset($_GET['ordinaricom'])) { 
            ?>
            <div class="control-group">
              <label class="control-label" for="inputV">Destinatari</label>
              <div class="controls">
                <input type="text" class="span5" name="inputV" id="inputV" readonly value="Destinatari Multipli">
              </div>
            </div>
           <?php }else{ ?>     
            <div class="control-group">
              <label class="control-label" for="inputV">Destinatario</label>
              <div class="controls">
                <input type="text" class="span5" name="inputV" id="inputV" readonly value="<?php echo $t->nome, " "; echo $t->cognome; ?>">
              </div>
            </div>
            <input type="hidden" name="inputDestinatario" id="inputDestinatario" value="<?php echo $t->id; ?>">
          <?php } ?>      
            <div class="control-group">
              <label class="control-label" for="inputOggetto">Oggetto</label>
              <div class="controls">
                <input type="text" class="span6" name="inputOggetto" id="inputOggetto" placeholder="Inserire qui l'oggetto della mail" required>
              </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="inputTesto">Testo</label>
            <div class="controls">
              <textarea rows="10" class="input-xlarge conEditor" type="text" id="inputTesto" name="inputTesto" placeholder="Inserisci il testo della tua mail qui..."></textarea>
            </div>
          </div>
            <div class="form-actions">
                <button onclick="$('#b1').toggle(1000); $('#a1').toggle(1000);" id="b1" type="submit" class="btn btn-success btn-large">
                    <i class="icon-envelope"></i>
                    Invia mail
                </button>
                <div id="a1" class="alert alert-block alert-success nascosto">
                    <h4><i class="icon-warning-sign"></i> <strong>Attendere...</strong>.</h4>
                </div>
            </div>
          </form>

    </div>
</div>
