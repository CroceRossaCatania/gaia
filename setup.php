<pre><?php

/*
 * ©2012 Croce Rossa Italiana
 */

require('./core.inc.php');

/* Friendly death switch */
if ( 0 ) { die('Haha, no, ma friend'); }

echo "Database setup.\n\n";

foreach ($conf['database']['tables'] as $tabella) {
    $q = $db->prepare("
        DROP TABLE {$tabella['name']}");
    $r = (int) $q->execute();
    $e = $q->errorInfo()[2];
    echo "[Eliminazione\t{$tabella['name']}]:\t\t$r\t$e\n";
    $q = $db->prepare("
        CREATE TABLE {$tabella['name']} ({$tabella['fields']}) ENGINE=MyISAM");
    $r = (int) $q->execute();
    $e = $q->errorInfo()[2];
    echo "[Creazione\t{$tabella['name']}]:\t\t$r\t$e\n\n";
}

$comitati = "Comitato Locale di Acireale ~ Aci Bonaccorsi
Comitato Locale di Acireale ~ Aci San Antonio
Comitato Locale di Acireale ~ Acireale
Comitato Locale di Acireale ~ Santa Venerina
Comitato Locale Catania Hinterland ~ Aci Catena
Comitato Locale Catania Hinterland ~ Mascalucia
Comitato Locale Catania Hinterland ~ Tremestieri Etneo
Comitato Locale Catania Hinterland ~ Viagrande
Comitato Locale Jonico-Giarre ~ Fiumefreddo
Comitato Locale Jonico-Giarre ~ Giarre
Comitato Locale Jonico-Giarre ~ Piedimonte Etneo
Comitato Locale Jonico-Giarre ~ Riposto
Comitato Locale Jonico-Giarre ~ Sant'Alfio
Comitato Locale Calatino Sud-Simeto ~ Caltagirone
Comitato Locale Calatino Sud-Simeto ~ Grammichele
Comitato Locale Calatino Sud-Simeto ~ Licodia Eubea
Comitato Locale Calatino Sud-Simeto ~ Militello
Comitato Locale Calatino Sud-Simeto ~ Mineo
Comitato Locale Calatino Sud-Simeto ~ Mirabella Imbaccari
Comitato Locale Calatino Sud-Simeto ~ Scordia
Comitato Locale Calatino Sud-Simeto ~ Vizzini
Comitato Provinciale di Catania ~ Bronte
Comitato Provinciale di Catania ~ Biancavilla
Comitato Provinciale di Catania ~ Catania
Comitato Provinciale di Catania ~ Maletto
Comitato Provinciale di Catania ~ Paternò
Comitato Provinciale di Catania ~ Randazzo
Comitato Provinciale di Catania ~ Sant'Agata Li Battiati";
$comitati = explode("\n", $comitati);
foreach ( $comitati as $comitato ) {
    $c = new Comitato; $c->nome = $comitato;
}

?></pre>