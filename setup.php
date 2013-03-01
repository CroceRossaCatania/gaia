<pre><?php

/*
 * ©2012 Croce Rossa Italiana
 * Script di installazione di Gaia
 */

require('./core.inc.php');

/* Controllo l'installazione di Gaia */
if ( file_exists('upload/setup/lock') ) { 
    die('Errore: Gaia è stato già installato.');
}

/* Controllo se la cartella è scrivibile */
if ( !is_writable('upload/setup/') ) { 
    die('Errore: Directory upload/setup non scrivibile. Rendere upload e tutte le sue sottocartelle scrivibili da php.');
}

/* Controllo se la cartella è scrivibile */
if ( !is_writable('upload/log/') ) { 
    die('Errore: Directory upload/log non scrivibile. Rendere upload e tutte le sue sottocartelle scrivibili da php.');
}

/* Controllo se la cartella è scrivibile II la vendetta */
if ( !is_writable('upload/') ) { 
    die('Errore: Directory upload/ non scrivibile. Rendere upload e tutte le sue sottocartelle scrivibili da php.');
}

echo "================ INSTALLAZIONE DI GAIA ==============\n\n";
echo "Creazione tabelle database...\n";

foreach ($conf['database']['tables'] as $tabella) {
    $q = $db->prepare("
        DROP TABLE {$tabella['name']}");
    $r = (int) $q->execute();
    $e = $q->errorInfo()[2];
    //echo "[Eliminazione\t{$tabella['name']}]:\t\t$r\t$e\n";
    $q = $db->prepare("
        CREATE TABLE {$tabella['name']} ({$tabella['fields']}) ENGINE=MyISAM");
    $r = (int) $q->execute();
    $e = $q->errorInfo()[2];
    echo "\tCreazione\t{$tabella['name']}:\t\t$r\t$e\n";
}

echo "Caricamento dei comitati sul database...\n";

$comitati = file_get_contents('upload/setup/comitati.txt');
$comitati = explode("\n", $comitati);
foreach ( $comitati as $comitato ) {
    $c = new Comitato; $c->nome = $comitato;
}


echo "Caricamento dei titoli sul database...\n";

if (($handle = fopen("upload/setup/titoli.txt", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 0, ";")) !== FALSE) {
        $num = count($data);
        $t = new Titolo();
        switch ( $data[2] ) {
        	case "competenza":
        		$t->tipo = TITOLO_PERSONALE;
        	break;
        	case "titolo cri":
        		$t->tipo = TITOLO_CRI;
        	break;
        	case "titolo di studio":
        		$t->tipo = TITOLO_STUDIO;
        	break;
        	case "patente civile":
                        $t->tipo = TITOLO_PATENTE_CIVILE;
                break;
                default:
        		$t->tipo = TITOLO_PATENTE_CRI;
        	break;
        }
        $t->nome = maiuscolo($data[1]);
        // echo "{$data[1]}\n";
        // ob_flush();
    }
    fclose($handle);
}

echo "Creazione delle cartelle per gli avatar...\n";
/* Crea le cartelle per gli avatar */
foreach ( $conf['avatar'] as $x => $y ) {
    @mkdir('upload/' . $x);
}

echo "\n
        ================================================       
        =========[OK!] INSTALLAZIONE COMPLETATA ========
        ================================================

 [SVILUPPATORI] 
    Per abilitare l'AUTOPULL via GitHub Web Hook
    ad 'autopull.php', creare un file vuoto in:
            /upload/setup/autopull
            
 [CRONJOB]
    Ricordarsi di puntare il un cronjob per eseguire
    ogni notte via HTTP il file cronjob.php.
    Es.: wget http://gaia.cricatania.it/cronjob.php";

/* Crea il file di lock, evita ultreriori installazioni */
file_put_contents('upload/setup/lock', time() );
?></pre>