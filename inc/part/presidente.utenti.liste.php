
<div class="row-fluid">
    <div class="span3 allinea-centro">
        <h3>
            <i class="icon-group icon-2x"></i><br />
            <?php echo $_lista_attiva; ?>
        </h3>
    </div>
            
    <div class="span3">
        <h4>Elenchi dei volontari</h4>
        <a href="?p=presidente.utenti">
            <i class="icon-list"></i>
            Volontari attivi
        </a> /
        <a href="?p=presidente.utenti.dimessi">
             dimessi
        </a><br />
        <a href="?p=presidente.utenti.riserve"
            data-attendere="Generazione lista...">
            <i class="icon-list"></i>
            Volontari in riserva
        </a><br />
        <a href="?p=presidente.utenti.giovani"
            data-attendere="Generazione lista...">
            <i class="icon-list"></i>
            Volontari giovani
        </a><br />
        <a href="?p=presidente.utenti.estesi"
            data-attendere="Generazione lista...">
            <i class="icon-list"></i>
            Volontari estesi
        </a> /
        <a href="?p=presidente.utenti.inestensione">
             in estensione
        </a><br />
        <a href="?p=presidente.soci">
            <i class="icon-list"></i>
            Elenco Soci
        </a><br />
        <a href="?p=presidente.soci.ordinari">
            <i class="icon-list"></i>
            Soci Ordinari
        </a> /
        <a href="?p=presidente.soci.ordinari.dimessi">
             dimessi
        </a><br />

    </div>     

    <div class="span3">
        <h4>Ufficio Soci</h4>
        <?php if ( $_link_excel ) { ?>
	        <a href="<?php echo $_link_excel; ?>" data-attendere="Generazione e compressione in corso...">
	            <i class="icon-download-alt"></i>
	            Scarica elenco <?php echo $_lista_attiva; ?> (ZIP)
	        </a><br />  
        <?php } ?>     
        <?php if ( $_link_email ) { ?>
	        <a href="<?php echo $_link_email; ?>">
	            <i class="icon-envelope"></i>
	            Email di massa a <?php echo $_lista_attiva; ?>
	        </a><br />
        <?php } ?>
        <a href="?p=us.elettorato">
            <i class="icon-cogs"></i>
            Genera elenchi elettorato
        </a>
    </div>
    
    <div class="span3">
        <h4>Presidente</h4>
        <a href="?p=presidente.dash">
            <i class="icon-rocket"></i>
            <strong>Pannello presidente</strong>
        </a><br />
        <a href="?p=utente.statistiche.volontari">
            <i class="icon-signal"></i>
            Statistiche
        </a><br />
    </div>    
</div>

<p>&nbsp;</p>