<?php

/**
 * (c)2014 Croce Rossa Italiana
 */


set_time_limit(0); 

paginaAdmin();

/* Script per la separazione della tabella patenti da quella titoli 
mantentendo titoliPersonali per la gestione */

$patentiCri = Titolo::filtra([['tipo', TITOLO_PATENTE_CRI]]);
$patentiCivili = Titolo::filtra([['tipo', TITOLO_PATENTE_CIVILE]]);
$patenti = array_merge($patentiCri, $patentiCivili);
$patenti = array_unique($patenti);
$tit = 0;
$pat = 0;
foreach ( $patenti as $patente ) {
	$idAtt = $patente;
	echo $patente->nome;
	$idNew = new Patenti();
	$idNew->nome = $patente->nome;
	$idNew->tipo = $patente->tipo;
	$titoli = TitoloPersonale::filtra([['titolo', $idAtt]]);
	foreach ( $titoli as $titolo ){
		$titolo->titolo = $idNew;
		$tit++;
	}
	$idAtt->cancella();
	$pat++;
}

echo "Ho aggiornato ", $tit;
echo "<br/> Ho cancellato ", $pat;
