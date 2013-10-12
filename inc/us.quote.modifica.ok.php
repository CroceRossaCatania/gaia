<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

$id = $_POST['id'];
$q = Quota::by('id', $id);
$r = $_POST['inputQuota'];

$time = DT::createFromFormat('d/m/Y', $_POST['inputData']);
$q->timestamp = $time->getTimestamp();
$q->tConferma = time();
$q->pConferma = $me;
if($r==QUOTA_PRIMO){
    $q->quota = QUOTA_PRIMO;
    $s = QUOTA_PRIMO;
    $i = "Versamento quota iscrizione";
    $q->causale = $i;
}elseif($r == QUOTA_RINNOVO){
    $q->quota = QUOTA_RINNOVO;
    $s = QUOTA_RINNOVO;
    $i = "Versamento quota di rinnovo annuale";
    $q->causale = $i;
}elseif($r ==QUOTA_ALTRO){
    $q->quota = $_POST['inputImporto'];
    $q->causale = $_POST['inputCausale'];
    $s = $_POST['inputImporto'];
    $i = $_POST['inputCausale'];
}

redirect('us.quoteNo&ok');