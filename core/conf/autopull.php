<?php
 
/*
 * ©2013 Croce Rossa Italiana
 */

/*
 * === INSTALLAZIONE DI GAIA ===
 * Questa è una configurazione di esempio per Gaia.
 * 1. Modificare "abilitato" a true o false per abilitare o disabilitare
 *    l'autopull, ovvero il pull tramite git del ramo impostato alla chiamata di autopull.php
 * 2. Scegliere il nome del ramo del quale effettuare il checkout
 */
 
/* Configurazione del servizio AUTOPULL */
$conf['autopull'] = [
    'abilitato'	=>	true,
    'ramo'	=>	'master',

    // Locazione dell'eseguibile di GIT nel sistema
    'bin'	=>	'/usr/bin/git',
    
    // Nome dell'origine
    'origin'    =>	'origin'
];