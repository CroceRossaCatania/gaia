<?php

/*
 * ©2013 Croce Rossa Italiana
 */

/*
 * Elenco Applicazioni da gestire
 * !!!! commentato APP_FORMAZIONE per fare merge di quote!!!
 */

controllaParametri(array('oid'));

$_daGestire = [
    APP_CO          =>  [EST_UNITA, EST_LOCALE, EST_PROVINCIALE, EST_REGIONALE, EST_NAZIONALE],
    APP_SOCI        =>  [EST_UNITA, EST_LOCALE, EST_PROVINCIALE, EST_REGIONALE, EST_NAZIONALE],
    //APP_FORMAZIONE  =>  [EST_LOCALE, EST_PROVINCIALE, EST_REGIONALE, EST_NAZIONALE]
];

$c = $_GET['oid'];
$c = GeoPolitica::daOid($c);

paginaApp([APP_PRESIDENTE], [$c]);

caricaSelettore();

$back = false;
if ( isset($_GET['back']) && !($_GET['back']==="")) {
    $back = $_GET['back'];
}

?>

<script type="text/javascript">
$(document).ready(function() {
    <?php if ( $back ) { ?>
        $('#elencoTab a[href="#<?php echo $back; ?>"]').tab('show');
    <?php } ?>
});
</script>

<div class='row-fluid allinea-centro'>
    
    <div class='span3'>
        <a href="?p=presidente.dash">
            <i class="icon-reply icon-3x"></i><br />
            Torna alla dashboard
        </a>
    </div>
    
    <div class='span6'>
        <h4><?php echo $c->nomeCompleto(); ?></h4>
        <p class="text-error">Croce Rossa Italiana</p>
    </div>
    
    <div class='span3'>
        <i class="icon-group icon-3x"></i><br />
        Gestione comitato
    </div>
    
    
</div>

<hr class='hidden-phone' />


<div class="">

    <?php if ( isset($_GET['ok']) ) { ?>
    <div class="alert alert-success">
        <i class="icon-ok"></i> <strong>Modifiche salvate</strong> &mdash;
        Le modifiche sono state salvate con successo alle <?php echo date('H:i:s'); ?>.
    </div>
    <?php } ?>

    <?php if ( isset($_GET['errnome']) ) { ?>
    <div class="alert alert-error">
        <i class="icon-warning-sign"></i> <strong>Modifiche non salvate</strong> &mdash;
        Non è possibile chiamare un'area <strong>Generale</strong>.
    </div>
    <?php } ?>

    <?php if ( isset($_GET['errquota']) ) { ?>
    <div class="alert alert-error">
        <i class="icon-warning-sign"></i> <strong>Modifiche non salvate</strong> &mdash;
        Non è possibile inserire un valore inferiore a quello stabilito a livello Nazionale.
    </div>
    <?php } ?>

    <?php if ( isset($_GET['double']) ) { ?>
    <div class="alert alert-error">
        <i class="icon-warning-sign"></i> <strong>Modifiche non salvate</strong> &mdash;
        Non è possibile delegare più volte la stessa persona.
    </div>
    <?php } ?>

        

    <div class="tabbable tabs-left">
        <ul class="nav nav-tabs" id="elencoTab">
            <li class="active">
                <a data-toggle="tab" href="#dettagli">
                    <i class='icon-info-sign'></i>
                    Dettagli comitato
                </a>
            </li>
            <?php if ( $c instanceOf Locale ) { ?>
            <li>
                <a data-toggle="tab" href="#benemeriti">
                    <i class='icon-money'></i>
                    Soci Benemeriti
                </a>
            </li>
            <?php } ?>
            <li>
                <a data-toggle="tab" href="#obiettivi">
                    <i class='icon-flag-alt'></i>
                    Obiettivi strategici
                </a>
            </li>
            <li>
                <a data-toggle="tab" href="#aree">
                    <i class='icon-compass'></i>
                    Aree di intervento
                </a>
            </li>

            <?php if ( $c instanceOf Comitato ) { ?>
            <li>
                <a data-toggle="tab" href="#referenti">
                    <i class='icon-group'></i>
                    Referenti
                </a>
            </li>
            <li>
                <a data-toggle="tab" href="#attivita">
                    <i class='icon-calendar-empty'></i>
                    Attività
                </a>
            </li>
            <?php } /*else { ?>


            <li>
                <a data-toggle="tab" href="#corsibase">
                    <i class='icon-rocket'></i>
                    Corsi base
                </a>
            </li>
            <?php } */?>

            
            <?php
                foreach ( $_daGestire as $_gestione => $_estensioni ) {

                    // Se questa applicazione non e' da gestire
                    if ( !in_array( $c->_estensione(), $_estensioni) )
                        continue;

                    $_nome = $conf['applicazioni'][$_gestione];
                    ?>
                <li>
                    <a data-toggle="tab" href="#app_<?php echo $_gestione; ?>">
                        <i class="icon-male"></i>
                        <?php echo $_nome; ?>
                    </a>
                </li>
            <?php } ?>


        </ul>
        
        <div class="tab-content">
            

            <!-- Tab: Dettagli -->
            <div class="tab-pane active"    id="dettagli">

                <?php if ( $c->principale ) { ?>
                    <div class="alert alert-warning">
                        <i class="icon-info-sign"></i>
                            Questa &egrave; l'unit&agrave; territoriale principale del <?= $c->locale()->nomeCompleto(); ?>,
                            di conseguenza ne eredita tutti i dettagli anagrafici.<br />
                            <a class="btn btn-warning" href="?p=presidente.comitato&oid=<?= $c->locale()->oid(); ?>">
                                Modifica i dettagli per il <?= $c->locale()->nomeCompleto(); ?>
                            </a>
                    </div>
                <?php } ?>

                
                <div class="alert alert-info">
                    <i class="icon-info-sign"></i> Queste informazioni sono rese pubbliche.
                </div>
                
                <div class="row-fluid">
                    
                    <div class="span4">
                        <h4>Indirizzo</h4>
                        <p><?php echo $c->formattato; ?></p>
                    </div>
                    
                    <div class="span2">
                        <h4>Telefono</h4>
                        <p><?php echo $c->telefono; ?></p>
                        
                        <?php if ( $c->fax ) { ?>
                            <h4>Fax</h4>
                            <p><?php echo $c->fax; ?></p>
                        <?php } ?>
                    </div>
                    
                    <div class="span4">
                        <h4>Email</h4>
                        <p><code><?php echo $c->email; ?></code></p>
                    </div>
                    
                    <div class="span2">
                        <?php if ( !$c->principale && $c->modificabileDa($me)) { ?>
                        <a class="btn btn-large btn-block btn-info" href="?p=presidente.wizard&oid=<?php echo $c->oid(); ?>">
                            <i class="icon-pencil icon-3x"></i><br />
                            Modifica
                        </a>
                        <?php } ?>
                    </div>
                    
                </div>
                <div class="row-fluid">
                    <div class="span4">
                        <h4>Partita IVA</h4>
                        <p><?php echo $c->piva(); ?></p>
                    </div>
                    <div class="span8">
                        <h4>Codice Fiscale</h4>
                        <p><?php echo $c->cf(); ?></p>
                    </div>
                </div>
                
            </div>

            <!-- Tab: Soci Benemeriti -->
            <?php if($c instanceOf Locale) { ?>
            <div class="tab-pane"    id="benemeriti">
                <h4>Tesseramenti e importi della quota socio benemerito</h4>
                <form action="?p=presidente.comitato.ok" method="POST">

                    <div class="alert alert-info">
                        <i class="icon-info-sign"></i> Modifiche non reversibili. <br />
                        Una volta modificato l'importo della quota integrativa per i soci Benemeriti
                        l'operazione non può essere annullata. <br />Per problemi contattare il supporto.
                    </div>
                    <input type="hidden" name="oid" value="<?php echo $c->oid(); ?>" />

                    <table class="table table-striped table-bordered">

                        <thead>
                            <th>Anno</th>
                            <th>Stato</th>
                            <th>Importo per soci benemeriti</th>
                            <th>Azione</th>
                        </thead>

                    <?php foreach (Tesseramento::elenco() as $t) { ?>
                        <tr>
                            <td><?php echo $t->anno; ?></td>
                            <td><?php echo $conf['tesseramento'][$t->stato]; ?></td>
                            <td> €
                                <?php if ($t->stato == TESSERAMENTO_APERTO
                                        && $c->quotaBenemeriti() == $t->benemerito) { ?>
                                <input class="input-mini" type="number"
                                step="0.1" min="<?php echo $t->benemerito; ?>"
                                name="<?php echo $t->anno; ?>_benemerito" 
                                value="<?php echo number_format((float) $c->quotaBenemeriti($t->anno), 2, '.', ''); ?>"
                                />  
                                <?php } else { 
                                    echo number_format((float) $c->quotaBenemeriti($t->anno), 2, '.', '');
                                 } ?>                         
                            </td>
                            <td>
                                <?php if($t->stato == TESSERAMENTO_APERTO
                                        && $c->quotaBenemeriti() == $t->benemerito) { ?>
                                    <input class="btn btn-success" type="submit" value="Varia">
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </table>
                </form>
            </div>
            <?php } ?>
            
            <!-- Tab: Obiettivi -->
            <div class="tab-pane"           id="obiettivi">
                
                <form action="?p=presidente.comitato.ok" method="POST">
                <input type="hidden" name="oid" value="<?php echo $c->oid(); ?>" />

                
                <div class="alert alert-info">
                    <i class="icon-info-sign"></i> I delegati selezionati possono creare attività
                    nel comitato riguardanti il loro Obiettivo Strategico.
                </div>
                
                <?php 
                $delegati = false;
                foreach ( $conf['obiettivi'] as $num => $nome ) {
                    if ($c->obiettivi($num)) {
                        $delegati = true;
                    }
                } if (!$delegati) { ?>
                <div class="alert alert-error">
                    <i class="icon-warning-sign"></i> <strong>Attenzione</strong> &mdash;
                    Ancora nessun delegato obiettivo scelto!
                </div>
                <?php } ?>

                <div class="row-fluid">
                <?php
                $nOb = 0;
                $acapo = 0;
                foreach ( $conf['obiettivi'] as $num => $nome ) { 
                        $acapo++; ?>
                    <div class="span4 allinea-centro">
                        <h4><?php echo $nome; ?></h4>
                        <?php
                        $o = $c->obiettivi($num);
                        $nOb += count($o);
                        if ($o) {
                            $o = $o[0];
                        ?>
                        <div class="btn-group btn-group-vertical">
                            <a data-autosubmit="true" data-selettore="true" data-input="<?php echo $num; ?>" class="btn btn-small">
                                <?php echo $o->nomeCompleto(); ?> <i class="icon-pencil"></i> 
                            </a>
                            <button onClick="return confirm('Vuoi veramente rimuovere questo delegato? L\'operazione non è reversibile');" name="cancellaDelegato" 
                            value="<?php echo $num; ?>" title="Rimuovi delegato" class="btn btn-small btn-danger">
                                <i class="icon-remove"></i> Rimuovi delegato
                            </button>
                        </div>
                        <?php } else { ?>
                        <a data-autosubmit="true" data-selettore="true" data-input="<?php echo $num; ?>" class="btn btn-small">
                            Scegli volontario <i class="icon-pencil"></i>
                        </a>
                        <?php } ?>
                    </div>

                    <?php if ($acapo == 3) { ?>
                            </div>
                            <div class="row-fluid">
                        <?php }  
                    } ?>
                </div>
                
                </form>
                    
            </div>
            
            <!-- Tab: Aree -->
            <div class="tab-pane"           id="aree">
                <form action="?p=presidente.comitato.ok" method="POST">
                <input type="hidden" name="oid" value="<?php echo $c->oid(); ?>" />

                <div class="alert alert-info"><i class="icon-info-sign"></i> 
                   Inserire le aree di intervento e selezionare i responsabili associati.<br />Essi saranno 
                   in grado di <strong>organizzare nuove attività su Gaia</strong> riguardanti la loro Area. <br />
                   &Egrave; possibile cancellare solo le aree che non hanno attivit&agrave; associate.<br />
                   In caso di <strong>rimozione</strong> del responsabile la competenza passa al <strong>Delegato d'Area</strong> o,
                   in caso di sua assenza, al <strong>Presidente</strong>.
                </div>

                <?php if ( $c->aree() ) { ?>
                <table id="tabellaAree" class="table table-striped table-bordered">

                    <thead>
                        <th>Obiettivo   </th>
                        <th>Nome area   </th>
                        <th>Attività    </th>
                        <th>Responsabile</th>
                    </thead>

                    <?php foreach ( $c->aree() as $area ) {
                        $attivita = count($area->attivita());
                        ?>
                    <tr id="area-<?php echo $area->id; ?>">
                        <td>                            
                            <?php echo( $conf['obiettivi'][$area->obiettivo] )?>
                        </td>
                        <td>
                            <?php if ($area->nome == 'Generale') { ?>
                                Generale
                            <?php } else { ?>
                            <input class="alCambioSalva" type="text" required name="<?php echo $area->id; ?>_inputNome" value="<?php echo $area->nome; ?>" />
                            <i class="icon-save icon-large text-warning"></i>
                            <?php } ?>
                        </td>
                        <td>
                            <?php echo $attivita; ?> attività
                        </td>
                        <td>
                            <?php if ($area->nome == 'Generale' && !$me->admin()) {
                                echo( $area->responsabile()->nomeCompleto());
                            } else { ?>
                            <div class="btn-group">
                                <a data-selettore="true" data-autosubmit="true" data-input="<?php echo $area->id; ?>_inputResponsabile" class="btn btn-small">
                                    <?php echo $area->responsabile()->nomeCompleto(); ?> <i class="icon-pencil"></i>
                                </a>
                                <button  onClick="return confirm('Vuoi veramente rimuovere questo referente? L\'operazione non è reversibile. Al suo posto verrà nominato il Delegato d'area.');" 
                                value="<?php echo $area->id; ?>" name="rimuoviReferente" title="Rimuovi referente" class="btn btn-small btn-danger">
                                <i class="icon-remove"></i> Rimuovi referente
                                </button>
                            
                            <?php 
                                if ( $area->nome != 'Generale' && (!$attivita || $me->admin)  ) { ?>

                                <button onClick="return confirm('Vuoi veramente rimuovere questo progetto? L\'operazione non è reversibile');" name="cancellaProgetto" 
                                value="<?php echo $area->id; ?>" title="Cancella Progetto" class="btn btn-small btn-danger">
                                <i class="icon-trash"></i> Cancella
                                </button>
                            <?php }} ?>
                            </div>
                               
                        </td>

                    </tr>

                    <?php } ?>

                    <tr>
                        <td colspan="5">
                            <a id="pulsanteNuovaArea" class="btn btn-block btn-info">
                                <i class="icon-plus"></i>
                                Aggiungi area e responsabile
                            </a>
                        </td>
                    </tr>
                    
                </table>
                
                <div class="nascosto" id="nuovaArea">
                    <hr />
                    <h3><i class="icon-asterisk"></i> Nuovo progetto</h3>
                    <div class="alert alert-info"><i class="icon-info-sign"></i> 
                    Non è possibile chiamare il nuovo Progetto <strong>Generale</strong>.
                    </div>
                    <table class="table">
                        <tr>
                            <td>
                                <select name="nuovaArea_inputObiettivo">
                                <?php foreach ( $conf['obiettivi'] as $x => $y ) { ?>
                                    <option value="<?php echo $x; ?>"><?php echo $y; ?></option>
                                <?php } ?>
                                </select>
                            </td>
                            <td>
                                <input type="text" required name="nuovaArea_nome" value="Nome nuovo Progetto" />
                            <td>
                                <a data-selettore="true" data-input="nuovaArea_volontario" class="btn btn-success btn-block" data-autosubmit="true">
                                    Avanti
                                    <i class="icon-chevron-right"></i>
                                </a>
                            </td>
                        </tr>
                    </table>
                    
                </div>

                

                
                <?php } else { ?>
                    <div class="alert alert-block alert-error">
                        <h4><i class="icon-warning-sign"></i> <strong>Attenzione</strong></h4>
                        <p>È necessario creare almeno un delegato Obiettivo Strategico per poter creare aree di intervento.</p>
                        <p><i class="icon-arrow-left"></i> <strong>Vai alla scheda obiettivi strategici del comitato.</strong></p>
                    </div>
                <?php } ?>
                
                </form>

            </div>
            
            <!-- Tab: Referenti -->
            <div class="tab-pane"           id="referenti">
                <h4>Elenco referenti</h4>
                <p>Per un elenco dei referenti delle attività, vai alla pagina di <a href="?p=attivita.gestione">Gestione delle Attività</a>.</p>
                
                <h4>Crea referente</h4>
                <p>Per creare un'attività ed assegnarvi un referente, vai alla pagina di <a href="?p=attivita.idea">Creazione attività</a>.</p>

            </div>   
            
            <!-- Tab: Attivita -->
            <div class="tab-pane"           id="attivita">
                <h4>Elenco attività</h4>
                <p>Per un elenco delle attività del comitato, vai alla pagina di <a href="?p=attivita.gestione">Gestione delle Attività</a>.</p>
                
                <h4>Crea attività</h4>
                <p>Per creare un'attività, vai alla pagina di <a href="?p=attivita.idea">Creazione attività</a>.</p>
            </div>
            
            <!-- Tab: Corsi base -->
            <?php /*
            <div class="tab-pane"           id="corsibase">
                <h4>Corsi base</h4>
                <p>Per questo comitato, sono stati organizzati e pubblicati un totale di <strong><?php echo count($c->corsiBase(true)); ?> corsi base</strong>.</p>
                <p>Per gestire i corsi base, vai alla pagina di <a href="?p=formazione.corsibase">Gestione dei corsi base</a>.</p>
            </div>
            */ ?>
            
            <?php            
            $i = 0;
            foreach ( $_daGestire as $_gestione => $_estensioni ) {

                // Se questa applicazione non e' da gestire
                if ( !in_array( $c->_estensione(), $_estensioni) )
                    continue;

                $_nome = $conf['applicazioni'][$_gestione];
                $delegati = $c->delegati($_gestione, true);
                ?>
                <!-- Tab: App <?php echo $_nome; ?> -->
                <div class="tab-pane"   id="app_<?php echo $_gestione; ?>">
                    
                    <div class="alert alert-info">
                        <i class="icon-info-sign"></i> 
                        È possibile delegare le funzioni di
                        di <strong><?= $_nome; ?></strong> per il <strong><?= $c->nomeCompleto(); ?></strong>.
                    </div>

                        
                    <h4>Volontari con accesso alle funzioni di <?php echo $_nome; ?></h4>
                    
                    <form action="?p=presidente.comitato.delegato" method="POST">
                    <input type="hidden" name="oid" value="<?= $c->oid(); ?>" />
                    <input type="hidden" name="applicazione" value="<?= $_gestione; ?>" />

                    <table class="table table-striped table-bordered">

                        <thead>
                            <th>Nome volontario</th>
                            <th>Delegato il</th>
                            <th>Delegato da</th>
                            <th>Fine delegazione</th>
                        </thead>
                        
                        <tr>
                            <td colspan="4">
                                <a data-autosubmit="true" data-selettore="true" data-input="persona" class="btn btn-block btn-primary">
                                    <i class="icon-plus"></i>
                                    Aggiungi un volontario che potrà accedere alle funzioni di <?php echo $_nome; ?>
                                </a>
                            </td>
                        </tr>
                        
                        <?php foreach ( $delegati as $delegato ) { ?>
                        <tr<?php if ($delegato->attuale()) { ?> class="success"<?php } ?>>
                            
                            <td>
                                <strong><a href="?p=profilo.controllo&id=<?php echo $delegato->volontario; ?>" target="_new">
                                    <?php echo $delegato->volontario()->nomeCompleto(); ?>
                                </a></strong>
                            </td>
                            
                            <td>
                                <?php echo $delegato->inizio()->inTesto(); ?>
                            </td>
                            
                            <td>
                                <a href="?p=public.utente&id=<?php echo $delegato->pConferma; ?>" target="_new">
                                    <?php echo $delegato->pConferma()->nomeCompleto(); ?>
                                </a>
                            </td>
                            
                            <td>
                                <?php if ( $delegato->attuale() ) { ?>
                                    <i class="icon-time"></i>
                                    <strong>Attualmente in carica</strong><br />
                                    <a href="?p=presidente.comitato.delegato.revoca&id=<?php echo $delegato->id; ?>&oid=<?php echo $c->oid(); ?>"
                                       onclick="return confirm('Sei sicuro di voler terminare i poteri per il volontario?');">
                                        <i class="icon-remove"></i> termina delegazione
                                    </a>
                                <?php } else { ?>
                                    <?php echo $delegato->fine()->inTesto(); ?>
                                <?php } ?>
                                
                            </td>
                            
                            
                        </tr>
                        <?php } ?>
                        
                        <?php if ( !$delegati ) { ?>
                            <tr class="warning">
                                <td colspan="4" class="allinea-centro text-error">
                                    <i class="icon-warning-sign"></i>
                                    Nessun volontario selezionato. Solo il presidente
                                    ha accesso alle funzioni di <?php echo $_nome; ?>.
                                </td>
                            </tr>
                        <?php } ?>
                            
                            
                        
                    </table>
                    </form>

                            
                    <hr />
                    <p class="text-info">
                        <i class="icon-info-sign"></i>
                        Quando deleghi un volontario, notifichiamo automaticamente a quest'ultimo l'autorizzazione via email.
                    </p>

                    
                </div>
            <?php } ?>
                         

            
        </div>
    </div>

    


</div>
