<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
if(isset($_GET['naz'])){ 
    $comitati = $me->comitatiDiCompetenza();
    $cLoc=0;
    $unit=0;
    $numVol = 0;
    $a=0;
    $nazionale = 1;
    $nazionale = Nazionale::id($nazionale);
    $regionali = Regionale::filtra([
                ['nazionale',  $nazionale],
            ], 'nome ASC');

    foreach ($regionali as $regionale){ 
        $prov = $regionale->provinciali();
        foreach ( $prov as $_prov ){
            $locali = $_prov->locali();
            foreach ( $locali as $locale ){
                $cLoc++;
                $unit = $locale->comitati();
                foreach ( $unit as $_unit ){
                    $cUnit++;
                    $volUnit = count($_unit->membriAttuali());
                    $numVol = $numVol+$volUnit;
                }
            }
        } 
    } ?>
    <h3><i class="icon-copy muted"></i> Report attivazioni su gaia</h3>

    <p>Questo è un report autogenerato da Gaia che permette di avere informazioni relative ai dati caricati sul sistema.</p><br/>
    <h3><li>Dati generali su gaia</li></h3>
        <p>Attualmente su Gaia sono presenti <strong><?php echo $me->numVolontariDiCompetenza(); ?></strong> volontari, in <strong><?php echo count($comitati); ?></strong> unità territoriali.</p><br/>

        <h5><li>Dati su tesserini gestiti da nazionale</li></h5>
        <ul>
            <li>Vi sono: <?= $nazionale->tesserini(); ?> tesserini richiesti</li>
            <li>Vi sono: <?= $nazionale->tesserini(STAMPATO); ?> tesserini stampati</li>
            <li>Vi sono: <?= $nazionale->tesserini(SPEDITO_CASA); ?> tesserini spediti a casa</li>
            <li>Vi sono: <?= $nazionale->tesserini(SPEDITO_COMITATO); ?> tesserini spediti in comitato</li>
            <li>Vi sono: <?= $nazionale->tesserini(INVALIDATO); ?> tesserini invalidati</li>
        </ul>
        <br/>
        <h5><li>Dati su fototessere</li></h5>
        <ul>
            <li>Vi sono: <?= $nazionale->fototessereNazionali(); ?> fototessere approvate</li>
            <li>Vi sono: <?= $nazionale->fototessereNazionali(FOTOTESSERA_PENDING); ?> fototessere in attesa di approvazione</li>
        </ul>
        <br/>
        <?php 
        $regionali = 0;
        $g = 0;
        $regionali = Regionale::filtra([
                ['nazionale',  $nazionale],
            ], 'nome ASC');

            foreach ($regionali as $g ){ ?>
            sono dentro
                <h3><li>Dati inerenti il <?= $g->nomeCompleto(); ?></li></h3>
                    <?php $presidenti = $g->presidenti(); 
                    if ( !$presidenti ) {
                        $pres = "Nessun Presidente iscritto";
                    }
                    foreach ( $presidenti as $presidente ){
                        if ( $presidente->attuale() ){
                            $pres = $presidente->volontario()->nomeCompleto();
                        }
                    }
                    ?>
                    <p>Il Presidente su Gaia del <?php echo $g->nomeCompleto(); ?> risulta essere <strong><?php echo $pres; ?></strong></p>

                    <p>Il <?php echo $g->nomeCompleto(); ?> ha attualmente su Gaia <strong><?php echo $numVol; ?></strong> volontari iscritti, sono presenti:</p>
                    <ul>
                        <li><?php echo count($prov); ?> Comitati Provinciali</li>
                        <li><?php echo $cLoc; ?> Comitati Locali</li>
                        <li><?php echo $cUnit; ?> Unità territoriali</li><br/>
                    </ul>
                    <h3><p>Tesserini</p></h3>
                    <ul>
                        <li>Vi sono: <?= $g->tesserini(); ?> tesserini richiesti</li>
                        <li>Vi sono: <?= $g->tesserini(STAMPATO); ?> tesserini stampati</li>
                        <li>Vi sono: <?= $g->tesserini(SPEDITO_CASA); ?> tesserini spediti a casa</li>
                        <li>Vi sono: <?= $g->tesserini(SPEDITO_COMITATO); ?> tesserini spediti in comitato</li>
                        <li>Vi sono: <?= $g->tesserini(INVALIDATO); ?> tesserini invalidati</li>
                    </ul>
                    <br/>
        <?php }
}else{
    controllaParametri(array('oid'), 'admin.report&err');
    $oid = $_POST['oid'];
    $g = GeoPolitica::daOid($oid);
    $comitati = $me->comitatiDiCompetenza();
    $prov = $g->provinciali();
    $cLoc=0;
    $unit=0;
    $numVol = 0;
    $a=0;
    foreach ( $prov as $_prov ){
        $locali = $_prov->locali();
        foreach ( $locali as $locale ){
            $cLoc++;
            $unit = $locale->comitati();
            foreach ( $unit as $_unit ){
                $cUnit++;
                $volUnit = count($_unit->membriAttuali());
                $numVol = $numVol+$volUnit;
            }
        }
    }
    ?>

    <h3><i class="icon-copy muted"></i> Report attivazioni su gaia</h3>

    <p>Questo è un report autogenerato da Gaia che permette di avere informazioni relative ai dati caricati sul sistema.</p><br/>
    <div class="tabbable">
        <ul class="nav nav-tabs">
        <li class="active"><a href="#tab1" data-toggle="tab">Nazionale</a></li>
        <li><a href="#tab2" data-toggle="tab">Regionale</a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="tab1">
            <h3><li>Dati generali su gaia</li></h3>
            <p>Attualmente su Gaia sono presenti <strong><?php echo $me->numVolontariDiCompetenza(); ?></strong> volontari, in <strong><?php echo count($comitati); ?></strong> unità territoriali.</p><br/>

            <h5><li>Dati su tesserini gestiti da nazionale</li></h5>
            <ul>
                <li>Vi sono: <?= $g->nazionale()->tesserini(); ?> tesserini richiesti</li>
                <li>Vi sono: <?= $g->nazionale()->tesserini(STAMPATO); ?> tesserini stampati</li>
                <li>Vi sono: <?= $g->nazionale()->tesserini(SPEDITO_CASA); ?> tesserini spediti a casa</li>
                <li>Vi sono: <?= $g->nazionale()->tesserini(SPEDITO_COMITATO); ?> tesserini spediti in comitato</li>
                <li>Vi sono: <?= $g->nazionale()->tesserini(INVALIDATO); ?> tesserini invalidati</li>
            </ul>
            <br/>
            <h5><li>Dati su fototessere</li></h5>
            <ul>
                <li>Vi sono: <?= $g->nazionale()->fototessereNazionali(); ?> fototessere approvate</li>
                <li>Vi sono: <?= $g->nazionale()->fototessereNazionali(FOTOTESSERA_PENDING); ?> fototessere in attesa di approvazione</li>
            </ul>
            <br/>
        </div>
        <div class="tab-pane" id="tab2">
            <h3><li>Dati inerenti il <?php echo $g->nomeCompleto(); ?></li></h3>
            <?php $presidenti = $g->presidenti(); 
            if ( !$presidenti ) {
                $pres = "Nessun Presidente iscritto";
            }
            foreach ( $presidenti as $presidente ){
                if ( $presidente->attuale() ){
                    $pres = $presidente->volontario()->nomeCompleto();
                }
            }
            ?>
            <p>Il Presidente su Gaia del <?php echo $g->nomeCompleto(); ?> risulta essere <strong><?php echo $pres; ?></strong></p>

            <p>Il <?php echo $g->nomeCompleto(); ?> ha attualmente su Gaia <strong><?php echo $numVol; ?></strong> volontari iscritti, sono presenti:</p>
            <ul>
                <li><?php echo count($prov); ?> Comitati Provinciali</li>
                <li><?php echo $cLoc; ?> Comitati Locali</li>
                <li><?php echo $cUnit; ?> Unità territoriali</li><br/>
            </ul>
            <h3><p>Tesserini</p></h3>
            <ul>
                <li>Vi sono: <?= $g->tesserini(); ?> tesserini richiesti</li>
                <li>Vi sono: <?= $g->tesserini(STAMPATO); ?> tesserini stampati</li>
                <li>Vi sono: <?= $g->tesserini(SPEDITO_CASA); ?> tesserini spediti a casa</li>
                <li>Vi sono: <?= $g->tesserini(SPEDITO_COMITATO); ?> tesserini spediti in comitato</li>
                <li>Vi sono: <?= $g->tesserini(INVALIDATO); ?> tesserini invalidati</li>
            </ul>
            <br/>
            <p>Verranno ora riportati i dati relativi ad ogni Comitato Provinciale</p>
            <ul>
                <?php   foreach($prov as $_prov){ ?>
                <h5><li>Dati inerenti il <?php echo $_prov->nomeCompleto(); ?></li></h5>
                <?php   $presidenti = $_prov->presidenti(); 
                if ( !$presidenti ) {
                    $pres = "Nessun Presidente iscritto";
                }
                foreach ( $presidenti as $presidente ){
                    if ( $presidente->attuale() ){
                        $pres = $presidente->volontario()->nomeCompleto();
                    }
                }
                ?>
                <p>Il Presidente su Gaia del <?php echo $_prov->nomeCompleto(); ?> risulta essere <strong><?php echo $pres; ?></strong></p><br/>
                <?php   $locali = $_prov->locali();
                foreach ( $locali as $locale ){ ?>
                <ul>
                    <h5><li>Dati inerenti il <?php echo $locale->nomeCompleto(); ?></li></h5>
                    <ul>
                        <?php   $h=0;
                        $unit = $locale->comitati();
                        if (!$unit){ 
                            echo "Non esistono unità territoriali per questo comitato";
                            continue;
                        }
                        foreach ( $unit as $_unit ){ 
                            $presidenti = $_unit->locale()->presidenti();
                            if ( !$presidenti ) {
                                $pres = "Nessun Presidente iscritto";
                            }
                            foreach ( $presidenti as $presidente ){
                                if ( $presidente->attuale() ){
                                    $pres = $presidente->volontario()->nomeCompleto(); 
                                }else{  
                                    $pres = "Nessun Presidente iscritto";
                                }
                            } 
                            $volPen = count($_unit->appartenenzePendenti());
                            $titPen = count($_unit->titoliPendenti());
                            $isc = $_unit->numMembriAttuali();
                            if($h==0){ ?>
                            <p>Il Presidente su Gaia del <?php echo $locale->nomeCompleto(); ?> risulta essere <strong><?php echo $pres; ?></strong></p>
                            <?php $h=1; } ?>
                            <p><li><strong><?php echo $_unit->nomeCompleto(); ?></strong></li></p>
                            <p>Sono presenti in questa unità territoriale <strong><?php echo $isc; ?></strong> volontari iscritti</p>
                            <p>Vi sono <strong><?php echo $volPen; ?></strong> volontari che attendono di essere confermati</p>
                            <p>Il Presidente deve confermare <strong><?php echo $titPen; ?></strong> tra titoli e patenti CRI</p>
                            <p>Sono presenti <strong><?php echo count($_unit->attivita()); ?></strong> attività del comitato</p><br/>
                            <?php   $a=0;
                            $volPen = 0;
                            $titPen = 0;
                            $isc = 0;
                        } ?>
                    </ul>
                </ul>
                <?php   } ?>
                <?php   } ?>
            </ul>
        </div>
    </div>
<?php } ?>
