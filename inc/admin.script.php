<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

?>
<div class="row-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="span12 centrato">
                <h1><i class="icon-stackexchange"></i> Script</h1>
                <div class="alert alert-block alert-danger">
                    <h3><i class="icon-warning-sign"></i> Attenzione!!!</h3>
                    <p>Pagina contenente gli script di gaia</p>
                    <p>Prestare massima attenzione!!!</p>
                </div>        
            </div>
            <hr/>
        </div>
    </div>

    <div class="row-fluid">
        <div class="span6 centrato">
            <div class='alert alert-info'>
                <strong>Script per il pagamento delle quote associative</strong>
                <p>Questo script paga tutte le quote associative dell'anno corrente e assegno l'anno della quota sulla base della data di pagamento</p>
            </div>
            <a href="?p=admin.quotepaga" class="btn btn-large btn-info">
                <i class="icon-money"></i>
                Paga quote associative
            </a>
            <a href="?p=admin.quoteassegna" class="btn btn-large btn-info">
                <i class="icon-money"></i>
                Assegna anno alla quota
            </a>
            <hr />
            <div class="alert alert-danger">
                <strong>Script per manutenzione delle attività</strong>
                <p>Questo script elimina le attività con dati mancanti e fixa quelle senza referente</p>
            </div>
            <a href="?p=admin.attivita" class="btn btn-large btn-danger">
                <i class="icon-wrench"></i>
                Fix attività
            </a>
            <hr/>          
            <div class="alert alert-danger">
                <strong>Script per manutenzione aspiranti</strong>
                <p>Ricalcola il raggio minimo per ogni aspirante in database</p>
            </div>
            <a href="?p=admin.script.aspiranti" data-attendere="Lasciami fare." class="btn btn-large btn-danger">
                <i class="icon-wrench"></i>
                Fix aspiranti
            </a>
            <hr/>
            <div class="alert alert-warning">
                <strong>Script per cancellazione comitati </strong>
                <p>Questo script elimina i comitati che hanno come nome null</p>
            </div>
            <a href="?p=admin.fix.comitati" class="btn btn-large btn-warning">
                <i class="icon-bookmark"></i>
                Fix Comitati
            </a>
            <hr/>
            <div class="alert alert-warning">
                <strong>Script per fix estensioni gruppi </strong>
                <p>Questo script pone l'estensione dei gruppi di lavoro pari al livello della attività</p>
            </div>
            <a href="?p=admin.fix.gruppi" class="btn btn-large btn-success">
                <i class="icon-group"></i>
                Fix Gruppi
            </a>
            <hr/>
            <div class="alert alert-info">
                <strong>Fix Titoli </strong>
                <p>Questo script elimina i titoli doppioni correggendo anche i titoli personali</p>
            </div>
            <a href="?p=admin.fix.titoli" class="btn btn-large btn-info">
                <i class="icon-bookmark"></i>
                Fix Titoli
            </a>
        </div>
        <div class="span6 centrato">
            <div class="alert alert-success">
                <strong>Script per il popolamento del campo sesso</strong>
                <p>Questo script assegna il sesso, basandosi sul CF, agli utenti di gaia che hanno il campo sesso pari a null</p>
            </div>
            <a href="?p=admin.sesso" class="btn btn-large btn-success">
                <i class="icon-male"></i><i class="icon-female"></i>
                Sesso
            </a>
            <hr/>
            <div class="alert alert-warning">
                <strong>Script per reset dei consensi</strong>
                <p>Questo script resetta tutti i consensi sulla privacy</p>
            </div>
            <a href="?p=admin.consensi" class="btn btn-large btn-warning">
                <i class="icon-time"></i>
                Reset Consensi
            </a>
            <hr/>
            <div class="alert alert-success">
                <strong>Script per fix appartenenze negate</strong>
                <p>Questo script imposta lo stato appartenenza negata a tutte le appartenenze cons tato pendente e fine</p>
            </div>
            <a href="?p=admin.appartenenze" class="btn btn-large btn-info">
                <i class="icon-user"></i>
                Fix appartenenze
            </a>
            <a href="?p=admin.fix.veicoli" class="btn btn-large btn-info">
                <i class="icon-thumbs-down"></i>
                Fix spazi nei veicoli
            </a>
        </div>
    </div>
</div>
