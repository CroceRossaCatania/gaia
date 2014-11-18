<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

$q = $db->prepare("SELECT * FROM veicoli");

$q->execute();

$veicoli = $q->fetchAll(PDO::FETCH_ASSOC);

$i = 0;
foreach ($veicoli as $veicolo){
	$veicolo['targa'] = str_replace(' ', '', $veicolo['targa']);
	$a = $db->prepare("UPDATE veicoli SET targa=:targa WHERE id=:id");
	$a->bindParam(":targa", $veicolo['targa']);
	$a->bindParam(":id", $veicolo['id']);
	$a->execute();
	$i++;
}


