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


echo "Prova di scrittura sul database...\n";
try {
    $c = new Comitato; $c->cancella();
} catch ( Exception $e ) {
    die("Errore: Impossibile scrivere sul database. È stato caricato il file /core/conf/gaia.sql?");
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
    $strc .= "- core/conf/{$cnfs}.conf.php\n";
}

echo "Creazione della prima API KEY...\n";
$k = new APIKey;
$k->chiave = 'bb2c08ff4da11f0b590a7ae884412e2bfd8ac28a';
$k->email  = 'noreply@gaia.cri.it';
$k->nome   = 'Client JS integrato';
$k->attiva = 1;
$k->giorno = 0;
$k->limite = 0;


echo "\n
        ================================================       
        =========[OK!] INSTALLAZIONE COMPLETATA ========
        ================================================

 [CONFIGURAZIONE] 
    Controllare i seguenti file di configurazione:
    {$strc} 
            
 [CRONJOB]
    Ricordarsi di puntare il un cronjob per eseguire
    ogni notte via HTTP il file cronjob.php.
    Es.: wget https://gaia.cri.it/cronjob.php";

/* Crea il file di lock, evita ultreriori installazioni */
file_put_contents('upload/setup/lock', time() );
?></pre>
