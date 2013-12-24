<?php  

/*
 * ©2013 Croce Rossa Italiana
 */

$parametri = array('v', 'turno');
controllaParametri($parametri);

$v = $_GET['v'];
$turno = $_GET['turno'];
$turno = Turno::id($turno);
$d = $me->delegazioni();
if( count($d) == 1 ){
    redirect("attivita.poteri.ok&v=$v&turno=$turno");
}else{
?>
<form class="form-horizontal" action="?p=attivita.poteri.ok&v=<?= $v; ?>&turno=<?= $turno; ?>" method="POST">
    <div class="modal fade automodal">
        <div class="modal-header">
          <h3><i class="icon-rocket"></i> Conferisci poteri</h3>
        </div>
        <div class="modal-body">
            <div class="row-fluid">
                <div class="alert alert-info">
                    <div class="row-fluid">
                        <span class="span12">
                            <p>Con questa schermata potrai conferire dei "poteri" sugli uffici al volontario per la durata del suo turno.</p>
                            </span>
                    </div>
                </div>     
            </div>
            <div class="row-fluid">
                    <div class="span4 centrato">
                        <label class="control-label" for="inputPotere">Ufficio</label>
                    </div>
                <div class="span8">
                    <select class="input-large" id="inputPotere" name="inputPotere"  required >
                    <?php
                        foreach ( $d as $_d ) { ?>
                        <option value="<?php echo $_d->applicazione; ?>"><?php echo $conf['applicazioni'][$_d->applicazione]; ?></option>
                        <?php } ?>
                    </select>   
                </div>
            </div>
        </div>
    <div class="modal-footer">
      <a href="?p=attivita.scheda&id=<?= $turno->attivita(); ?>&turno=<?= $turno; ?>" class="btn">Annulla</a>
      <button type="submit" class="btn btn-success">
          <i class="icon-ok"></i> Conferisci poteri
      </button>
    </div>
</div>
    
</form>
<?php } ?>
