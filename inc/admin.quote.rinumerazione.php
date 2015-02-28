<?php

/**
 * (c)2015 Croce Rossa Italiana
 */

paginaAdmin();

set_time_limit(0);

/**
 * Questo script rinumera le quote per l'anno attuale 
 */

?>
<pre>

<?php

$anno  = 2015;
$quote = Quota::filtra([['anno', $anno]], 'progressivo ASC');
echo "Trovate " . count($quote) . " quote.\n";

echo "Azzero... ";
$q = "UPDATE quote SET progressivo = 0 WHERE anno = {$anno}";
$q = $db->prepare($q);
$q->execute();
echo "OK\n\n";

flush();

echo "Rinumerazione ";
foreach ( $quote as $_q ) {

	$_q->assegnaProgressivo(true);
	echo ".";
	flush();

}

echo " OK\n";
?></pre>