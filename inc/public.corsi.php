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


<div class="row-fluid">
    
    
    <div class="span9">
         <h4>Filtri</h4>
        <ul>
            <li>
                <input type="checkbox" value="sss">&nbsp;Cat 1
            </li>
            <li>
                <input type="checkbox" value="sss">&nbsp;Cat 2
            </li>
            <li>
                <input type="checkbox" value="sss">&nbsp;Dog 3
            </li>
        </ul>
         
         
        <div class="row-fluid">
            <span class="span3">
                <label for="cercaTitolo">
                    <span style="font-size: larger;">
                        <i class="icon-search"></i>
                        <strong>Aggiungi</strong>
                    </span>
                </label>

            </span>
            <span class="span9">
                <input type="text" autofocus data-t="<?php echo $t; ?>" required id="cercaProvicia" placeholder="Cerca provincia" class="span12" />
            </span>
        </div>
         
         
         <hr/>
        
        <div id='calendario'></div>
    </div>
    
    <div class="span3" style="text-align: left">
  
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