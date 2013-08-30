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
        Azione
    </th>
</thead>

<?php foreach ( $me->attivitaDiGestione() as $attivita ) { ?>

<tr>
    <td style="width: 40%;">
        <strong>
            <a href="?p=attivita.scheda&id=<?php echo $attivita->id; ?>">
                <?php echo $attivita->nome; ?>
            </a>
        </strong><br />
        <?php echo $attivita->luogo; ?>
        <br />
        <?php if ( $attivita->referente ) { ?>
            Referente: 
                <a href="?p=public.utente&id=<?php echo $attivita->referente()->id; ?>" target="_new">
                    <?php echo $attivita->referente()->nomeCompleto(); ?>
                </a>
        <?php } else { ?>
            <i class="icon-warning-sign"></i> Nessun referente
        <?php } ?>
    </td>
    
    <td style="width: 20%;">
        <?php echo $attivita->comitato()->nomeCompleto(); ?>
    </td>
    
    <td style="width: 20%;">
        <?php echo $attivita->area()->nomeCompleto(); ?>
    </td>
    
    
    <td style="width: 20%;">
        <?php if ($me->presidenziante() || $me->admin()){ ?>
            <a href="?p=attivita.referente.nuovo&id=<?= $attivita->id; ?>">
                <i class="icon-pencil"></i> 
                cambia referente
            </a>
            <br />
        <?php } ?>
        <a href="?p=attivita.modifica&id=<?php echo $attivita->id; ?>">
            <i class="icon-edit"></i> modifica attività
        </a>
        <br />
        <a href="?p=attivita.turni&id=<?php echo $attivita->id; ?>">
            <strong><i class="icon-plus"></i> giorni e turni</strong>
        </a>        
        <br />
        <a href="?p=attivita.report&id=<?php echo $attivita->id; ?>" data-attendere="Generazione in corso...">
            <i class="icon-download-alt"></i> scarica report
        </a>
    </td>
        
</tr>

<?php } ?>

</table>
