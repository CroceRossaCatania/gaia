<?php

/*
 * ©2013 Croce Rossa Italiana
 */
paginaPresidenziale();
?>
    <br/>
<div class="row-fluid">
    <div class="span8">
        <h2>
            <i class="icon-time muted"></i>
            Elenco attività odierne
        </h2>
    </div>
    
    <div class="span4 allinea-destra">
        <div class="input-prepend">
            <span class="add-on"><i class="icon-search"></i></span>
            <input autofocus required id="cercaUtente" placeholder="Cerca Volontari e Attività..." type="text">
        </div>
    </div>    
</div>
    
<hr />
    
<div class="row-fluid">
   <div class="span12">
      
       <table class="table table-striped table-bordered table-condensed" id="tabellaUtenti">
            <thead>
                <th>Turno</th>
                <th>Inizio</th>
                <th>Fine</th>
            </thead>
        <?php
        $i = time();
        $f = time()+86400;
        $comitati = $me->comitatiDiCompetenza();
        $elenco = Attivita::elenco();
        foreach($comitati as $comitato){
            foreach($elenco as $attivita) {
                if($attivita->comitato == $comitato){
                    $turni = Turno::filtra([['attivita', $attivita]]);
                    foreach($turni as $turno){
                        if ($turno->inizio>= $i && $turno->fine <= $f) {
                            if($x==0){ ?> 
                                <tr class="primary">
                                    <td colspan="4" class="grassetto">
                                    <?php echo $attivita->nome; ?>
                                    </td>
                                </tr>
                                <?php 
                                $x++;
                                } ?>
                            <tr class="info">
                                   <td><?php echo $turno->nome; ?></td>
                                   <td><?php echo date('d-m-Y H:i', $turno->inizio); ?></td>
                                   <td><?php echo date('d-m-Y H:i', $turno->fine); ?></td>
                            </tr>
                            <?php
                            $partecipanti = $turno->partecipazioniStato(AUT_OK);
                            foreach ($partecipanti as $partecipante){ ?>
                                <tr>
                                   <td><?php echo $partecipante->volontario()->nomeCompleto(); ?></td>
                                   <td><?php if ($partecipante->volontario()->cellulareServizio){ echo $partecipante->volontario()->cellulareServizio; }else{ echo $partecipante->volontario()->cellulare; } ?></td>
                                   <td class="btn-group">
                                        <a class="btn btn-small btn-success" href="?p=#" title="Monta">
                                            <i class="icon-arrow-up"></i> Monta
                                        </a>
                                        <a class="btn btn-small btn-danger" href="?p=#" title="Smonta">
                                            <i class="icon-arrow-down"></i> Smonta
                                        </a>
                                   </td>
                                </tr>
                    
                            
        <?php }}}}}}?>

        
        </table>

    </div>
    
</div>
