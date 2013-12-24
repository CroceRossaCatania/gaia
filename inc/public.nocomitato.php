<?php

/*
 * ©2013 Croce Rossa Italiana
 */

if($_GET['rege']){
	/* Invia la mail */
	$m = new Email('registrazioneVolontario', 'Benvenuto su Gaia');
	$m->a = $sessione->utente();
	$m->_NOME       = $sessione->utente()->nome;
	$m->_PASSWORD   = $sessione->password;
	$m->invia();
}

?>

<div class="row-fluid">
    <div class="span12">
        <h2><i class="icon-sitemap"></i> Il mio Comitato non è su Gaia</h2>
        <hr />
        <p>Per attivare Gaia nel vostro Comitato basta far inviare una e-mail, dall'indirizzo di posta elettronica istituzionale, dal vostro Presidente a <a href="mailto:supporto@gaiacri.it"></a> indicando la vostra "struttura” (che sarà inserita su Gaia), cioè a quale Comitato Regionale e Comitato Provinciale fate capo, e se vi siano unità territoriali; ad esempio:</p>
        <ul>
        	<li>Comitato Regionale __________</li>
        	<ul>
        		<li>Comitato Provinciale __________</li>
             <ul>
                <li>Comitato Locale __________</li>
                <ul>
                   <li>Unità Territoriale 1</li>
                   <li>Unità Territoriale 2</li>
                   <li>...</li>
               </ul>
           </ul>
       </ul>
   </ul>
   <p>Basterà che il vostro Presidente si iscriva al portale e, non appena avvenuto, procederemo con l'attivazione dell'account “presidente” (che gli permetterà di usufruire di tutte le funzionalità di Gaia a nome del vostro Comitato).</p>
   <p>La richiesta deve essere fatta dal Presidente.</p>
</div>
</div>
<div class="row-fluid">
    <div class="span12">
        <a href="index.php" class="btn"><i class="icon-home"></i>Accedi al portale</a>
    </div>
</div>

