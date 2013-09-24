<?php


/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

set_time_limit(0);

$inizio = time();
?>
<h3><i class="icon-bookmark muted"></i> Fix comitati</h3>

<code><pre>Rimozione comitati con name null:
<?php
$reg = "Regionali";
$regionali = Regionale::regionaliNull();
$provinciali = Provinciale::provincialiNull();
$locali = Locale::localiNull();
$comitati = Comitato::comitatiNull();
$nRegionali = 0;
$nProvinciali = 0;
$nLocali = 0;
$nComitati = 0;
echo "Start manutenzione Comitati:<br/>";

foreach( $regionali as $r ){
	$r = new Regionale($r);
	echo $r->id,"<br/>";
	$r->cancella();
	$nRegionali++;
}

foreach( $provinciali as $p ){
	$p = new Provinciale($p);
	echo $p->id,"<br/>";
	$p->cancella();
	$nProvinciali++;
}

foreach( $locali as $l ){
	$l = new Locale($l);
	echo $l->id,"<br/>";
	$l->cancella();
	$nLocali++;
}

foreach( $comitati as $c ){
	$c = new Comitato($c);
	echo $c->id,"<br/>";
	$c->cancella();
	$nComitati++;
}
$fine = time();
$tot = $fine - $inizio;
?>
Ho rimosso:
- <strong><?= $nRegionali; ?></strong> Regionali<br/>
- <strong><?= $nProvinciali; ?></strong> Provinciali<br/>
- <strong><?= $nLocali; ?></strong> Locali<br/>
- <strong><?= $nComitati; ?></strong> Comitati<br/>
Ho impiegato: <strong><?= $tot; ?></strong> sec
</pre></code>