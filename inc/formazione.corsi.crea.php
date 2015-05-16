<?php

/*
 * ©2014 Croce Rossa Italiana
 */

$_titolo = "Calencario dei Corsi";

?>
<style>
/* Dello stile veloce...*/
#calendar {
        max-width: 900px;
        margin: 0 auto;
}
</style>
<link href='/assets/css/fullcalendar.min.2.3.1.css' rel='stylesheet' />
<link href='/assets/css/fullcalendar.print.css' rel='stylesheet' media='print' />
<script src='/assets/js/libs/moment.min.js'></script>
<script src='/assets/js/fullcalendar.min.2.3.1.js'></script>
<script src='/assets/js/lang/it.js'></script>

<div class="row-fluid">
    
    <div class="span8">
       
        <form>
            <article>
                <h1 class="pagetitle">Scheda corso BLSD cat. A BARI </h1>
                <div id="contentbody">

                    in versione form
                    <div class="calendarevent">
                        <p class="eventlist"><strong>Sede:</strong><input type="text" value="BARI" /></p>										
                        <p class="eventlist"><strong>Provincia:</strong>BA</p>										
                        <p class="eventlist"><strong>Data inizio:</strong> 01 maggio 2015</p>										
                        <p class="eventlist"><strong>Data fine:</strong> 01 maggio 2015</p>										
                        <p class="eventlist"><strong>Direttore:</strong>EUGENIO PADALINO</p>																				<p class="eventlist">&nbsp;</p>
                        <p class="eventlist"><strong>Per informazioni</strong></p>
                        <p class="eventlist"><strong>Telefono:</strong>3937314505</p>																															<p class="eventlist"><strong>Corso aperto al pubblico:</strong> sì																				</p></div>
                    <h2>istruttori</h2>
                    <ul>
                        <li>VITO MASTRODONATO</li>
                    </ul>
                    <div class="info-corso">Calendario dei corsi organizzati dalla <strong>Rete Formativa IRC</strong>. La scheda di ogni corso riporta i riferimenti dell'organizzatore locale (se assenti il corso non è aperto al pubblico) da contattare per tutte le informazioni.</div>
                    <a href="?p=formazione.corsi.crea.ok" type="submit">crea</a>
            </article>
        </form>
        <hr/>
        
        <section>
            <h4>Iscritti</h4>
            <table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nome</th>
                        <th>Cognome</th>
                        <th>Email</th>
                        <th>Stato</th>
                        <th>Azioni</th>
                    </tr>
                </thead>
                <tbody>
                     <tr>
                        <td>Id</td>
                        <td>Donald</td>
                        <td>Duck</td>
                        <td>d.duck@email.com</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Id</td>
                        <td>Daisy</td>
                        <td>Duck</td>
                        <td>da.duck@email.com</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Id</td>
                        <td>Michele</td>
                        <td>Mouse</td>
                        <td>m.mouse@email.com</td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            
            invita
            <input type="" />
            
       </section>
        
    </div>
    
    <div class="span4">
         <h4>Se hai i permessi</h4>
        <nav>
            permessi corso: pubblico | privato
            
            <a class="btn btn-danger" href="?p=utente.me">
                <i class="icon-plus-sign-alt icon-large"></i>&nbsp;
                Eliminare il corso --> annulla
            </a>
            <br/>
            <a class="btn btn-danger" href="?p=utente.me">
                <i class="icon-plus-sign-alt icon-large"></i>&nbsp;
                Convalidare
            </a>
            <br/>
            <a class="btn btn-danger" href="?p=utente.me">
                <i class="icon-plus-sign-alt icon-large"></i>&nbsp;
                richiedi iscrizione
            </a>
            <br/>
            <a class="btn btn-danger" href="?p=utente.me">
                <i class="icon-plus-sign-alt icon-large"></i>&nbsp;
                chiudi corso -> valutazione
            </a>
        </nav>
        
    </div>
        
</div>