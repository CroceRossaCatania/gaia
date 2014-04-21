<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);

menuElenchiVolontari(
    "Elenco Corpo Militare",       // Nome elenco
    "?p=admin.utenti.excel&cm",   // Link scarica elenco
    false                        // Link email elenco
);

?>
  
<div class="row-fluid">
   <div class="span12">
        <div class="nascosto" id="azioniElenco">
            <div class="btn-group">
                <a class="btn btn-small" href="?p=presidente.utente.visualizza&id={id}" title="Dettagli" target="_new">
                    <i class="icon-eye-open"></i> Dettagli
                </a>
                <a class="btn btn-small btn-success" href="?p=utente.mail.nuova&id={id}" title="Invia Mail" target="_new">
                    <i class="icon-envelope"></i>
                </a>
            </div>
        </div>
        <table
        data-volontari="elenco"
        data-perpagina="30"
        data-azioni="#azioniElenco"
        data-militare="true"
        <?php if(!$me->admin) echo("data-comitati=\"{$me->delegazioneAttuale()->comitato()->oid()}\""); ?>
        />
        </table>
    </div>
</div>
