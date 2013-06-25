<?php

paginaAdmin();

if ( !$cache ) {
    die('Gaia non sta usando la cache.');
}

$info = $cache->getStats();

?>

<?php if (isset($_GET['flush'])) { ?>
<div class='alert alert-block alert-success'>
    <h4>Cache flushata con successo &mdash; <?php echo date('d-m-Y H:i:s'); ?></h4>
    <p>Le performance di Gaia potrebbero subire rallentamenti per le prossime ore
        fino alla ricostruzione della cache.</p>
</div>
<?php } ?>

<div class="row-fluid">
    
    <div class="span4">
        <h2>Cache server</h2>

        <p>Statistiche di funzionamento del server di cache.</p>
        
        <p>Le richieste GET ricevute sono il numero di interrogazioni risparmiate
            al database.</p>
        
        <a href="?p=admin.cache.flush" class="btn btn-large btn-danger">
            <i class="icon-warning-sign"></i>
            Resetta la cache (flush)
        </a>
        
        <hr />
        
        <div class='alert alert-info'>
            Query fatte al database dall'ultimo flush della cache:
            <strong><?php echo (int) $cache->get( $conf['db_hash'] . '__nq' ); ?></strong>
        </div>
        
    </div>
    
    
    <div class="span8">

        <?php foreach ( $info as $indirizzo => $server ) { ?>


        <table class="table table-bordered table-striped">
            <thead>
                <th>Nome parametro</th>
                <th>Valore attuale</th>
            </thead>
            <tbody>
                <tr>
                    <td>Indirizzo server</td>
                    <td><code><?= $indirizzo; ?></code> (versione <?= $server['version']; ?>)<td>
                </tr>
                <tr>
                    <td>Attività (uptime)</td>
                    <td><?= round( $server['uptime'] / 3600, 2 ); ?> ore<td>
                </tr>
                <tr>
                    <td><strong>Chiavi in memoria</strong></td>
                    <td><?= $server['total_items']; ?> (<?= $server['curr_items']; ?> attuali)<td>
                </tr>      
                <tr>
                    <td>Spazio usato</td>
                    <td><?= round( $server['bytes'] / 1024 , 2 ); ?> kB<td>
                </tr>
                <tr>
                    <td>Spazio massimo</td>
                    <td><?= round( $server['limit_maxbytes'] / ( 1024 * 1024 ) , 2 ); ?> MB<td>
                </tr>
                <tr>
                    <td>Connessioni ricevute</td>
                    <td><?= $server['total_connections']; ?> (<?= $server['curr_connections']; ?> attuali)<td>
                </tr>     
                <tr>
                    <td>GET ricevuti</td>
                    <td><?= $server['cmd_get']; ?> (<strong><?= $server['get_hits']; ?> servite</strong>, <?= $server['get_misses']; ?> perse)<td>
                </tr>
                <tr>
                    <td>SET ricevuti</td>
                    <td><?= $server['cmd_set']; ?><td>
                </tr>
                <tr>
                    <td>I/O</td>
                    <td>
                        <?= round( $server['bytes_read'] / 1024 , 2 ); ?> kB letti<br />
                        <?= round( $server['bytes_written'] / 1024 , 2 ); ?> kB scritti
                    <td>
                </tr>
                <tr>
                    <td><strong>Ricerche in cache</strong><br />
                        Contiene filtri, elenchi e by.</td>
                    <td>
                        <?php $entita = ['Appartenenza', 'Comitato', 'Provinciale', 'Regionale', 'Nazionale', 'Volontario', 'Delegato', 'Autorizzazione', 'Partecipazione', 'Turno', 'Attivita']; ?>
                        <table class='table table-condensed table-striped'>
                            <?php foreach ( $entita as $singola ) {
                                $qq = $singola::_elencoCacheQuery(); ?>
                            <tr>
                                <td><?= $singola; ?></td>
                                <td><?= count($qq); ?></td>
                            </tr>
                            <?php } ?>
                            
                        </table>
                    
                    
                    <td>
                </tr>
                <tr>
                    <td>Ricerche evitate</td>
                    <td><?php echo (int) ( $cache->get( $conf['db_hash'] . '__re' ) ); ?></td>
                </tr>
            </tbody>
        </table>

        <?php } ?>
        
    </div>

    
</div>