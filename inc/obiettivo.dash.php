<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_OBIETTIVO , APP_PRESIDENTE]);
$d = $me->dominiDelegazioni(APP_OBIETTIVO);

foreach ( $d as $_d ){
    if ( $_d == 1 ){
        $uno = true;
    }
    if ( $_d == 2 ){
        $due = true;
    }
    if ( $_d == 3 ){
        $tre = true;
    }
    if ( $_d == 4 ){
        $quattro = true;
    }
    if ( $_d == 5 ){
        $cinque = true;
    }
    if ( $_d == 6 ){
        $sei = true;
    }
}
?>

<div class="row-fluid">
    <div class="span3">
        <?php menuVolontario(); ?>
    </div>
    <div class="span9">
        <div class="row-fluid">
            <div class="span12">
                <h3>Delegato obiettivo </h3>
            </div>
        </div>
                    
        <div class="row-fluid">
            <div class="span3">
                
            </div>
            
            <div class="span6 allinea-centro">
                <img src="https://upload.wikimedia.org/wikipedia/it/thumb/4/4a/Emblema_CRI.svg/75px-Emblema_CRI.svg.png" />
            </div>

            <div class="span3">
                <table class="table table-striped table-condensed">
<!--                
                    <tr><td>Reperibili</td><td><?php echo "help"; ?></td></tr>
                    <tr><td>In servizio</td><td><?php echo "help"; ?></td></tr>
                    -->
                </table>
            </div>
        </div>
        <hr />
        
        <div class="span12">
            <div class="span6">
                <div class="btn-group btn-group-vertical span12">
                    <a href="?p=presidente.utenti" class="btn btn-primary btn-block">
                        <i class="icon-list"></i>
                        Elenco Volontari
                    </a>
               </div>
            </div>
            <?php if ( $tre == true ){ ?>
            <div class="span6">
                <div class="btn-group btn-group-vertical span12">
                    <a href="?p=co.reperibilita" class="btn btn-block">
                        <i class="icon-thumbs-up"></i>
                        Volontari reperibili
                    </a>
                </div>
            </div>
            <?php } ?>
        </div>
   </div>
    <hr/>
</div>
            
