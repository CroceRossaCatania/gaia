<?php

/**
 * (c)2014 Croce Rossa Italiana
 */

paginaAdmin();

$dbs = $mdb->command(['dbStats' => 1]);

?>

<h2><i class="icon-heart muted"></i> Statistiche database Mongo</h2>

<div class="row-fluid">

	<div class="span4">
		<h3>Totale database</h3>
	</div>
    <div class="span8">
        <table class="table table-bordered table-striped">
            <thead>
                <th>Nome parametro</th>
                <th>Valore attuale</th>
            </thead>
            <tbody>
                <tr>
                    <td>Nome database</td>
                    <td><code><?= $dbs['db']; ?></code><td>
                </tr>
                <tr>
                    <td>Numero collezioni</td>
                    <td><code><?= $dbs['collections']; ?></code><td>
                </tr>
                <tr>
                    <td>Oggetti in DB</td>
                    <td><code><?= number_format($dbs['objects']); ?></code><td>
                </tr>
                <tr>
                    <td>Spazio dati</td>
                    <td><code><?= number_format($dbs['dataSize']); ?> bytes</code><td>
                </tr>
                <tr>
                    <td>Disco occupato</td>
                    <td><code><?= number_format($dbs['storageSize']); ?> bytes</code><td>
                </tr>
                <tr>
                    <td>Disco allocato</td>
                    <td><code><?= number_format($dbs['fileSize']); ?> bytes</code><td>
                </tr>
            </tbody>
        </table>
    </div>

</div>