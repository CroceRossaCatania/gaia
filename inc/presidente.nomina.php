<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPresidenziale();

?>

<div class="row-fluid">
    
    <div class="span3">
        <?php menuVolontario(); ?>

    </div>

    <div class="span9">
        
        
        <div class="row-fluid">
            
            <div class="span7">
                <h2>
                    <i class="icon-briefcase"></i> Referenti e delegati
                </h2>

                <p>Ciao, presidente <?php echo $me->nomeCompleto(); ?>.</p>
                <p>Da questa pagina puoi <strong>nominare delegati, referenti e responsabili</strong>.</p>
            </div>
            
            <div class="span5 well centrato">
                
                <p>Azioni rapide:</p>
                
                <a href="#" class="btn btn-large btn-block btn-info">
                    <i class="icon-list"></i>
                    Elenco di tutti gli incarici
                </a>
                
                <a href="#" class="btn btn-block btn-danger">
                    <i class="icon-remove"></i>
                    Revoca una nomina
                </a>
                
            </div>
        </div>
        
        
        <hr />
        
        <h2 class="centrato"><i>Effettua una nuova nomina...</i></h2>
        
        <hr />
        
        <div class="row-fluid">
            
            <div class="span5">
                <p>Esempio esplicativo:</p>
                <img src="./img/esempio-delegati.png" class="img-polaroid" />
                
            </div>
            
            <div class="span7">

                <h3>Delegato obiettivo strategico</h3>
                <p>Il delegato dell'obiettivo strategico può:</p>
                <ol>
                    <li>Creare attività per il proprio obiettivo;</li>
                    <li>Leccare le orecchie di Stefano Principato;</li>
                </ol>
                <a href="#" class="btn btn-block btn-primary">
                    <i class="icon-certificate"></i>
                    Nomina delegato obiettivo strategico
                </a>
            
                <hr />
                
                <h3>Responsabile <span class="muted">opzionale</span></h3>
                <p>Un responsabile può:</p>
                <ol>
                    <li>Creare attività;</li>
                    <li>Leccare le orecchie di Stefano Principato;</li>
                </ol>
                <a href="#" class="btn btn-block btn-info">
                    <i class="icon-plus"></i>
                    Nomina un responsabile
                </a>
                
                <hr />
                
                <h3>Referente</h3>
                <p>Un responsabile può:</p>
                <ol>
                    <li>Creare attività;</li>
                    <li>Leccare le orecchie di Stefano Principato;</li>
                </ol>
                <a href="#" class="btn btn-block btn-primary">
                    <i class="icon-plus"></i>
                    Nomina un referente attività
                </a>
            </div>
            
            
        </div>
        
        
    </div>
      
    
</div>

