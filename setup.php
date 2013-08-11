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

/* Controllo se la cartella è scrivibile II la vendetta */
if ( !is_writable('upload/') ) { 
    die('Errore: Directory upload/ non scrivibile. Rendere upload e tutte le sue sottocartelle scrivibili da php.');
}

echo "================ INSTALLAZIONE DI GAIA ==============\n\n";

echo "Creazione directory upload/log...\n";
@mkdir('upload/log');


echo "Caricamento dei comitati sul database...\n";

$comitati = file_get_contents('upload/setup/comitati.txt');
$comitati = explode("\n", $comitati);
try {
    foreach ( $comitati as $comitato ) {
        $c = new Comitato; $c->nome = $comitato;
    }
} catch ( Exception $e ) {
    die("Errore: Impossibile scrivere sul database. È stato caricato il file /core/conf/gaia.sql?");
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
    @mkdir('upload/avatar/' . $x);
}

echo "Creazione delle cartelle per i documenti...\n";
/* Crea le cartelle per gli avatar */
@mkdir('upload/get');
@mkdir('upload/docs');
@mkdir('upload/docs/o');
@mkdir('upload/docs/t');

/* Copia i file di configurazione */
$cnf = ['database', 'smtp', 'autopull'];
$strc = "";
foreach ( $cnf as $cnfs ) {
    @copy("core/conf/{$cnfs}.conf.php.sample", "core/conf/{$cnfs}.conf.php");
    $strc .= "- core/conf/{$cnfs}.conf.php\n";
}

echo "\n
        ================================================       
        =========[OK!] INSTALLAZIONE COMPLETATA ========
        ================================================

 [CONFIGURAZIONE] 
    Modificare i seguenti file di configurazione:
    {$strc} 
            
 [CRONJOB]
    Ricordarsi di puntare il un cronjob per eseguire
    ogni notte via HTTP il file cronjob.php.
    Es.: wget https://www.gaiacri.it/cronjob.php";

/* Crea il file di lock, evita ultreriori installazioni */
file_put_contents('upload/setup/lock', time() );
?></pre>