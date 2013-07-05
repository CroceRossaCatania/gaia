<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

?>


<h2>Gestione delle attività</h2>

<table class="table table-striped table-bordered">

<thead>
    <th>
        Attività
    </th>
    <th>
        Comitato
    </th>
    <th>
        Area
    </th>
    <th>
        Referente
    </th>
    <th>
        Azione
    </th>
</thead>

<?php foreach ( $me->attivitaDiGestione() as $attivita ) { ?>

<tr>
    <td>
        <strong>
            <a href="?p=attivita.scheda&id=<?php echo $attivita->id; ?>">
                <?php echo $attivita->nome; ?>
            </a>
        </strong><br />
        <?php echo $attivita->luogo; ?>
    </td>
    
    <td>
        <?php echo $attivita->comitato()->nomeCompleto(); ?>
    </td>
    
    <td>
        <?php echo $attivita->area()->nomeCompleto(); ?>
    </td>
    
    <td>
        <?php if ( $attivita->referente ) { ?>
            <?php echo $attivita->referente()->nomeCompleto(); ?>
        <?php } else { ?>
            <i class="icon-warning-sign"></i> Nessun referente
        <?php } ?>
    </td>
    
    <td>
        <a href="?p=attivita.modifica&id=<?php echo $attivita->id; ?>">
            <i class="icon-pencil"></i> modifica attività
        </a>
        <br />
        <a href="?p=attivita.turni&id=<?php echo $attivita->id; ?>">
            <strong><i class="icon-plus"></i> aggiungi giorno o turno</strong>
        </a>
    </td>
        
</tr>

<?php } ?>

</table>
