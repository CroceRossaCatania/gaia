<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
$oid = $_POST['oid'];
$g = GeoPolitica::daOid($oid);
$comitati = $me->comitatiDiCompetenza();
$prov = $g->provinciali();
$cLoc=0;
$unit=0;
$numVol=0;
$a=0;
foreach ( $prov as $_prov ){
    $locali = $_prov->locali();
    foreach ( $locali as $locale ){
        $cLoc++;
        $unit = $locale->comitati();
        foreach ( $unit as $_unit ){
            $cUnit++;
            $volUnit = $_unit->membriAttuali();
            foreach ( $volUnit as $_volUnit ){
                $numVol++;
            }
        }
    }
}
?>

<h3><i class="icon-copy muted"></i> Report attivazioni su gaia</h3>

    <p>Questo è un report autogenerato da Gaia che permette di avere informazioni relative ai dati caricati sul sistema.</p><br/>
    <Ul>
        <h3><li>Dati generali su gaia</li></h3>
        <p>Attualmente su Gaia sono presenti <strong><?php echo $me->numVolontariDiCompetenza(); ?></strong> volontari, in <strong><?php echo count($comitati); ?></strong> unità territoriali.</p><br/>
        
        <h3><li>Dati inerenti il <?php echo $g->nomeCompleto(); ?></li></h3>
            <p>Il <?php echo $g->nomeCompleto(); ?> ha attualmente su Gaia <strong><?php echo $numVol; ?></strong> volontari iscritti, sono presenti:</p>
            <ul>
                <li><?php echo count($prov); ?> Comitati Provinciali</li>
                <li><?php echo $cLoc; ?> Comitati Locali</li>
                <li><?php echo $cUnit; ?> Unità territoriali</li><br/>
            </ul>
        <p>Verranno ora riportati i dati relativi ad ogni Comitato Provinciale</p>
        <ul>
            <?php   foreach($prov as $_prov){ ?>
                <?php   $locali = $_prov->locali();
                        foreach ( $locali as $locale ){ ?>
                            <ul>
                                <h5><li>Dati inerenti il <?php echo $locale->nomeCompleto(); ?></li></h5>
                                <ul>
                                    <?php   $unit = $locale->comitati();
                                            if (!$unit){ 
                                                echo "Non esistono unità territoriali per questo comitato";
                                                continue;
                                            }
                                            foreach ( $unit as $_unit ){ 
                                                $presidenti = $_unit->presidenti();
                                                if ( !$presidenti ) { 
                                                        $locale = $_unit->locale();
                                                        $presidenti = $locale->presidenti();
                                                }
                                                if ( !$presidenti ) {
                                                    $pres = "Nessun Presidente iscritto";
                                                    $volPen = "0";
                                                    $titPen = "0";
                                                }
                                                foreach ( $presidenti as $presidente ){
                                                    if ( $presidente->attuale() ){
                                                        $pres = $presidente->volontario()->nomeCompleto(); 
                                                        $volPen = $presidente->volontario()->numAppPending(APP_PRESIDENTE);
                                                        $titPen = $presidente->volontario()->NumTitoliPending(APP_PRESIDENTE); 
                                                    }else{  
                                                        $pres = "Nessun Presidente iscritto";
                                                    }
                                                } ?>
                                                    <p><li><strong><?php echo $_unit->nomeCompleto(); ?></strong></li></p>
                                                    <p>Il Presidente su Gaia del <?php echo $_unit->nomeCompleto(); ?> risulta essere <strong><?php echo $pres; ?></strong></p>
                                                    <p>Sono presenti in questa unità territoriale <strong><?php echo count($_unit->membriAttuali()); ?></strong> volontari iscritti</p>
                                                    <p>Vi sono <strong><?php echo $volPen; ?></strong> volontari che attendono di essere confermati</p>
                                                    <p>Il Presidente deve confermare <strong><?php echo $titPen; ?></strong> tra titoli e patenti CRI</p>
                                                    <?php foreach ($_unit->attivita() as $attivita){
                                                    $a++;
                                                    } ?>
                                                    <p>Sono presenti <strong><?php echo $a; ?></strong> attività del comitato</p><br/>
                                        <?php $a=0;
                                            } ?>
                                </ul>
                                
                            </ul>
                <?php   } ?>
            <?php   } ?>
        </ul>
    </ul>