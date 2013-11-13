<?php

/*
 * ©2013 Croce Rossa Italiana
 */
?>
<div class="row-fluid">
    <div class="span12">
    <?php
    if(isset($_GET['sca'])){ ?>
        <div class="alert alert-block alert-error">
          <h4><i class="icon-exclamation-sign"></i> Richiesta scaduta o non effettuata</h4>
          <p>La richiesta di sostituzione della email è scaduta o non è mai stata effettuata, compila i campi qui sotto per effettuarne una nuova</p>
        </div>

    <?php }elseif(isset($_GET['gia'])) { ?>

        <div class="alert alert-block alert-error">
          <h4><i class="icon-exclamation-sign"></i> Richiesta già effettuata</h4>
          <p>La richiesta di sostituzione della email è stata già effettuata controlla la tua email</p>
        </div>
        
    <?php }elseif(isset($_GET['pass'])){ ?>

        <h2><i class="icon-ok muted"></i> Hai una nuova email</h2>
        <p>La nuova password ti è stata spedita per email.</p>

    <?php } ?>
    </div>
</div>