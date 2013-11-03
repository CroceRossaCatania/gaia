<?php

/*
 * ©2013 Croce Rossa Italiana
 */

if($_GET['pass']){ ?>

<h2><i class="icon-ok muted"></i> Hai una nuova email</h2>

<p>La nuova password ti è stata spedita per email.</p>
<?php }elseif($_GET['mail']){ ?>
<h2><i class="icon-ok muted"></i> Indirizzo email sostituito</h2>

<p>Ora puoi accedere utilizzando il tuo nuovo indirizzo email</p>
<?php } ?>
<a href="?p=login" class="btn btn-large"><i class="icon-key"></i> Accedi</a>