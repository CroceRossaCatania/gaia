<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$id = intval(filter_input(INPUT_GET, "id"));
$md5 = filter_input(INPUT_GET, "md5");

$p = PartecipazioneCorso::id($id);

if ($p->md5 != $md5){
    header('HTTP/1.0 403 Forbidden');
    redirect("errore.403");
    exit(0);
}

$p->accetta($md5);