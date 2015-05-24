<?php

/*
 * ©2014 Croce Rossa Italiana
 */

$_titolo = "Calencario dei Corsi";
?>

<!--
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.3.1/fullcalendar.min.js"></script>
<link type="text/css" rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.3.1/fullcalendar.min.css" />
<link type="text/css" rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.3.1/fullcalendar.print.css" />
-->

<div class="row-fluid" style="margin-top: 50px;">
    
    <div class="span8">
        <div class="row-fluid">
            <div class="span12">
                <h2><i class="icon-calendar muted" id="icona-caricamento"></i>
                Calendario delle attività</h2>
                <hr />
            </div>
            <hr />
        </div>

        <div class="row-fluid">
            <div class="span12">
                <h4>Filtri</h4>

                <div>
                    <label for="type">Tipologia</label>
                    <select id="type" class="chosen-select" data-placeholder="Aggiungi un filtro..." style="width:350px;" multiple="true">
                        <option value="flt1">Filtro 1</option>
                        <option value="flt2">Filtro 2</option>
                        <option value="flt3">Filtro 3</option>
                        <option value="flt4">Filtro 4</option>
                        <option value="flt5">Filtro 5</option>
                    </select>
                </div>
                <br/> <br/>
                <div>
                    <label for="provincia">Provincia</label>
                    <select id="provincia" data-placeholder="Scegli una provincia..." required id="cercaProvicia" class="chosen-select" style="width: 350px;" multiple="true">
                        <option value=""></option>
                        <option value="United States">United States</option>
                        <option value="United Kingdom">United Kingdom</option>
                        <option value="Afghanistan">Afghanistan</option>
                        <option value="Aland Islands">Aland Islands</option>
                        <option value="Albania">Albania</option>
                        <option value="Algeria">Algeria</option>
                        <option value="American Samoa">American Samoa</option>
                        <option value="Andorra">Andorra</option>
                        <option value="Angola">Angola</option>
                        <option value="Anguilla">Anguilla</option>
                        <option value="Antarctica">Antarctica</option>
                        <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                        <option value="Argentina">Argentina</option>
                        <option value="Armenia">Armenia</option>
                        <option value="Aruba">Aruba</option>
                        <option value="Australia">Australia</option>
                        <option value="Austria">Austria</option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="row-fluid" id='calendario'></div>
    </div>
    
    

    <div class="span4" style="text-align: left">
  
        <h4>Se hai i permessi</h4>
        <nav>
            <a class="btn btn-danger" href="?p=formazione.corsi.crea">
                <i class="icon-plus-sign-alt icon-large"></i>&nbsp;
                Crea Corso
            </a>
        </nav>
        
        
        <ul>
            <li>
                Richieste Pendenti.<br/>
                viale 1<bR/>
            </li>
            <li>
                   I tuoi Corsi
                   <BR/>
                   corso 1<br/>
                   corso 2<br/>
                   piazza 3<br/>
            </li>
        </ul>
    </div>
</div>