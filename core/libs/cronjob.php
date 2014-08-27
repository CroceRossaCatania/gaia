<?php

/*
 * (c)2014 Croce Rossa Italiana
 */
 
/*
 * Classe errore cronjob, con messaggio
 */
class CronjobException extends Exception {
	
}

/*
 * Esegue una funzione del cronjob, catcha eventuali errori
 * @param string 	Descrizione della funzione in esecuzione
 * @param callable 	Funzione che ritorna true oppure stringa aggiuntiva,
 *					La funzione deve lanciare una eccezione di tipo
 *					CronjobException in caso di errore.
 * @param &string   Output  
 * @param &bool     Parametro booleano, va tutto ok? 
 */
function cronjobEsegui(
    $descrizione    = "Esecuzione operazione periodica...",
    $funzione       = null,
    &$log,
    &$ok
) {
    if ( !is_callable($funzione) ) {
        $ok &= false;
        $log .= "[??] Routine '{$descrizione}' non valida\n";
        return false;
    }
    
    $start = microtime(true);
    
    $risultato = true;
    try {
        $output = call_user_func($funzione);    

    } catch ( Exception $e ) {
        $risultato = false;
        $output = $e->getMessage();
        
    }

    $end    = microtime(true);
    $tempo  = round($end - $start, 4);

    if ( $risultato ) {
        $log .= "[OK] Routine '{$descrizione}' eseguita ({$tempo}s)\n";
        if ( is_string($output) ) {
            $log .= "     >> '{$output}'\n";
        }
    } else {
        $log .= "[!!] Routine '{$descrizione}' ha fallito (dopo {$tempo}s)\n";
        $log .= "     >> Errore: '{$output}'";
    }
    
    $ok &= $risultato;
    return $risultato;
    
}