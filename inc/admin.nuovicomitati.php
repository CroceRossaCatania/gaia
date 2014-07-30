<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

?>

<div class="row-fluid">
	<div class="row-fluid">
        <div class="span12">
            <div class="span12 centrato">
                <h1><i class="icon-stackexchange"></i> Script Comitati Nuovi</h1>
                <div class="alert alert-block alert-danger">
                    <h3><i class="icon-warning-sign"></i> Attenzione!!!</h3>
                    <p>Pagina contenente gli script per lo spostamento dei comitati</p>
                    <p>Rischi di fare grossi danni!!!</p>
                </div>        
            </div>
            <hr/>
        </div>
    </div>
    <?php for($i = 40; $i >= 0; $i -= 10) { ?>
    <div class="row-fluid">
        <div class="span12 centrato">
            <a href="?p=admin.nuovicomitati.ok&livello=<?php echo $i; ?>" class="btn btn-large btn-danger">
                Sposta <?php echo $conf['est_obj'][$i]; ?>
            </a>
        </div>
    </div>
    <br />
    <?php } ?>
</div>