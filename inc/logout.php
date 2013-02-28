<?php

/*
 * ©2012 Croce Rossa Italiana
 */

$sessione->logout();
?>

<div class="alert alert-block alert-success">
    <h4>Logout effettuato</h4>
    <p>A presto.</p>
</div>

<a href='?p=home'>Torna alla home</a>.

<?php 
    header("Refresh: 2; URL=http://gaia.cricatania.it");
?>