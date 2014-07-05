<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();
richiediComitato();

?>


<div class="row-fluid">
    <div class="span3">
        <?php        menuVolontario(); ?>
    </div>
    <div class="span9">
        <?php if ( $me->gruppiDiCompetenza() ) { ?>
        <div class="row-fluid">
            <div class="span12">
                <a href="?p=gruppi.dash" class="btn btn-large btn-primary btn-block">
                    <i class="icon-list"></i>
                    Vai all'elenco dei Gruppi di lavoro che gestisci
                </a>
            </div>
        </div>
        <hr />
        <?php } ?>
        <?php if ( isset($_GET['ok']) ) { ?>
        <div class="alert alert-success">
            <i class="icon-save"></i> <strong>Iscritto al gruppo</strong>.
            Sei stato iscritto con successo al gruppo di lavoro.
        </div>
        <?php } ?>
        <?php if ( isset($_GET['e']) ) { ?>
        <div class="alert alert-error">
            <i class="icon-warning-sign"></i> <strong>Già iscritto al gruppo</strong>.
            Sei già iscritto a questo gruppo di lavoro.
        </div>
        <?php } ?>
        <?php if ( isset($_GET['last']) ) { ?>
        <div class="alert alert-error">
            <i class="icon-warning-sign"></i> <strong>Devi appartenere almeno ad un gruppo</strong>.
            Non puoi abbandonare il gruppo, perchè devi essere iscritto almeno ad un gruppo.
        </div>
        <?php } ?>
        <?php if ( isset($_GET['del']) ) { ?>
        <div class="alert alert-success">
            <i class="icon-ok"></i> <strong>Gruppo abbandonato</strong>.
           Hai abbandonato il gruppo di lavoro con successo.
        </div>
        <?php } ?>
        
        <div class="row-fluid">
            <h2><i class="icon-group muted"></i> Gruppi di lavoro</h2>
            <div class="alert alert-block alert-info ">
                <div class="row-fluid">
                    <span class="span9">
                        <h4><i class="icon-question-sign"></i> Vuoi iscriverti ad un gruppo di lavoro ?</h4>
                        <p>Con questo modulo puoi richiedere l'iscrizione ad un gruppo di lavoro presente nel tuo Comitato</p>
                        <p>Seleziona il Gruppo a cui vuoi iscriverti e clicca su iscriviti</p>
                    </span>
                </div>
            </div>           
        </div>
        
<div class="row-fluid">
    <form class="form-horizontal" action="?p=utente.gruppo.nuovo.ok&id=<?php echo $me->id; ?>" method="POST">
   <div class="control-group">
        <label class="control-label" for="inputGruppo">Gruppi di lavoro </label>
        <div class="controls">
            <?php
            $app = $me->appartenenzeAttuali();
            $gruppi = $me->gruppiDisponibili();
            $nogruppi = (bool) !$gruppi;
            

            if ($nogruppi) { ?>
                <span class="text-error">
                    <i class="icon-warning-sign"></i>
                    Spiacente.<br />
                    Attualmente nel tuo Comitato non esistono gruppi di lavoro.
                </span>

            <?php } else { ?>
                <select name="inputGruppo" class="input-xxlarge" required>
                <?php foreach ($gruppi as $g) { ?>
                        <option value="<?php echo $g->id; ?>"><?php echo $g->comitato()->nomeCompleto() ?> : <?php echo $g->nome; ?></option>
                <?php } ?>
                </select>
            
            </div>
          </div>
        <div class="control-group">
            <div class="controls">
              <button type="submit" class="btn btn-large btn-success" <?php if ($nogruppi) { ?> disabled <?php } ?>>
                  <i class="icon-ok"></i> Iscriviti
              </button>
            </div>
          </div>
                    <?php if ( $me->mieiGruppi() ) { ?>

        <div class="row-fluid">
            <h2>
                <i class="icon-flag muted"></i>
                Gruppi
            </h2>
            
        </div>
        
        <div class="row-fluid">
            
            <table class="table table-bordered table-striped">
                <thead>
                    <th>Stato</th>
                    <th>Nome</th>
                    <th>Comitato</th>
                    <th>Inizio</th>
                    <th>Fine</th>
                    <th>Azione</th>
                </thead>
                
                <?php foreach ( $me->mieiGruppi() as $_g ) { ?>
                    <tr<?php if ($_g->attuale()) { ?> class="success"<?php } ?>>
                        <td>
                            <?php if ($_g->attuale()) { ?>
                                Attuale
                            <?php } else { ?>
                                Passato
                            <?php } ?>
                        </td>
                        <td>
                            <strong><?php echo $_g->gruppo()->nome; ?></strong>
                        </td>
                        <td>
                            <strong><?php echo $_g->comitato()->nomeCompleto(); ?></strong>
                        </td>
                        <td>
                            <i class="icon-calendar muted"></i>
                            <?php echo $_g->inizio()->inTesto(false); ?>
                        </td>
                        <td>
                            <?php if ($_g->fine) { ?>
                                <i class="icon-time muted"></i>
                                <?php echo $_g->fine()->inTesto(false); ?>
                            <?php } else { ?>
                                <i class="icon-question-sign muted"></i>
                                Indeterminato
                            <?php } ?>
                        </td>
                        <td>
                            <?php if ($_g->attuale() && ($me->contaGruppi() > 1)) { ?>
                            <a class="btn btn-danger" onClick="return confirm('Vuoi veramente abbandonare questo gruppo di lavoro ?');" href="?p=utente.gruppo.dimetti&id=<?php echo $_g->id; ?>">
                                <i class="icon-ban-circle"></i>
                                Abbandona
                            </a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
        <?php } ?>
        </div>
    <?php } ?>  
    </div>
</div>
