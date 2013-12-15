<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

?>

<h3><i class="icon-bolt muted"></i> Procedura di cambio degli stati</h3>

<?php if(!isset($_POST['inputDataTaglio'])) {?>

<div class="row-fluid">
    <div class="span12">
        <form class="form-horizontal" action="?p=admin.limbo.cambiastato" method="POST">
          <div class="control-group">
            <label class="control-label" for="inputDataTaglio">Data di taglio</label>
            <div class="controls">
              <input class="input-small" type="text" id="inputDataTaglio" name="inputDataTaglio" required />
            </div>
          </div>
          <div class="control-group">
            <div class="controls">
              <button type="submit" class="btn btn-large btn-success">
                  <i class="icon-ok"></i>
                  Cambia stato!
              </button>
            </div>
          </div>
        </form>

    </div>
</div>


<?php } else {
$data   = DT::createFromFormat('d/m/Y', $_POST['inputDataTaglio']);
?>
<pre>
<code>
    <?php

    echo('<br><strong>Avviata procedura di cambio stato con taglio a '.$data->getTimeStamp().'<br><br>');
    $v = Volontario::elenco();
    $totale = 0;
    foreach($v as $_v) 
    {
        $appartenenze = $_v->numAppartenenzeTotali(MEMBRO_DIMESSO);
        if($appartenenze == 0 && $_v->stato == VOLONTARIO && $_v->timestamp > $data->getTimeStamp())
        {
            $totale++;
            echo('Anagrafica ID:['.$_v->id.'] '.$_v->codiceFiscale.' '.$_v->nome.' '.$_v->cognome.' '.$_v->timestamp.' -> nuovo stato: Aspirante<br>');
        }
    }




    echo('<br><strong>Sono stati cambiati '.$totale.' stati</strong>');

    ?>
</code>
</pre>

<?php } ?>