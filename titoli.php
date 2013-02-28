<pre><?php

require('./core.inc.php');

if (($handle = fopen("titoli.txt", "r")) !== FALSE) {
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
        echo "{$data[1]}\n";
        ob_flush();
    }
    fclose($handle);
}
