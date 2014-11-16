<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);
?>

<div class="row-fluid">
    <div class="span3">
        <?php menuVolontario(); ?>
    </div>
    <div class="span9">
        <div class="row-fluid">
            <div class="span8">
                <h2>
                    <i class="icon-user muted"></i>
                    Importazioni Volontari e Ordinari
                </h2>
            </div>
            <div class="span12">
                Su Gaia puoi importare i volontari o i soci ordinari del tuo comitato in blocco, sono disponibili dei format
                in excel da compilare e spedire al supporto che provvederà all'importazione. 
                <ul>
                    <br/>
                    <li><a href="https://gaia.cri.it/upload/docs/import/csv_volontari.xls"><i class="icon-list"></i> Format Volontari</a></li> <p><strong>Il file è per i soli volontari</strong></p>
                    <li><a href="https://gaia.cri.it/upload/docs/import/csv_ordinari.xls"><i class="icon-list"></i> Format Ordinari</a></li> <p><strong>Il file è per i soli soci ordinari</strong></p>
                </ul>
                <br/>Ecco le <strong>regole</strong> da rispettare per gli import:
                <ul>
                    <li>data nascita formato: gg/mm/aaaa</li>
                    <li>luogo di nascita formato: città (provincia) [rispettare lo spazio tra città e provincia ad es: Catania (CT)]</li>
                    <li>provincia di residenza: formato abbreviato es. MT, PZ, etc. (indicare EE se paese straniero)</li>
                    <li>data ingresso in CRI formato: gg/mm/aaaa</li>
                    <li>appartenenza Nome unità territoriale (es: Ciampino)</li>
                    <li>email: inserire un solo indirizzo email (es: prova@example.com)</li>
                </ul>
                <br/><strong>I campi che devono essere necessariamente compilati sono:</strong>
                <ul>
                    <li>Nome</li>
                    <li>Cognome</li>
                    <li>Data di nascita</li>
                    <li>Luogo di nascita con annessa provincia</li>
                    <li>Codice fiscale</li>
                    <li>data ingresso in CRI</li>
                    <li>appartenenza  (nome unità territoriale)</li>
                </ul>
                <br/>
                <p>Per i volontari inseriti senza indicazione dell'indirizzo e-mail non verrà generato l'account e non potranno accedere direttamente al sito.</p>
                <p>Non è possibile censire più volontari con la medesima e-mail.</p>
                <p><strong>Attenzione non sarà possibile successivamente fare import parziale dei dati.</strong></p>
                <p>La prego di restituire il file così compilato all’indirizzo email supporto@gaia.cri.it e dalla casella di posta di comitato @cri.it</p>
                <br/> 
            </div>
        </div>
    </div>
</div>