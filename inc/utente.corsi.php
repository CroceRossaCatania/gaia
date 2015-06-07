<?php

/*
 * ©2013 Croce Rossa Italiana
 */

if (isset($_GET['t'])) {
    $t = (int) $_GET['t'];
} else {
    $t = 0;
}
$titoli = $conf['Corsi'][$t];

paginaPrivata();

?>
<div class="row-fluid">
    <div class="span3">
        <?php        menuVolontario(); ?>
    </div>
    <div class="span9">
    
         <h2><i class="icon-beaker muted"></i> Titoli di Studio</h2>

         <select>
             <option>Direttore</option>
              <option>Docente</option>
               <option>Discente</option>
         </select>
             
            <div class="row-fluid">
                <div class="span12">
                    <h3><i class="icon-list muted"></i> Nel mio curriculum <span class="muted">13 inseriti</span></h3>
                    <table class="table table-striped">

                        <?php for($i=0; $i<13; $i++) : ?>
                        <tr>
                            <td><strong>nome</strong></td>
                            <td>tipo</td>
                            <td>
                                <abbr title="<?php echo date('d-m-Y H:i'); ?>">
                                    <i class="icon-ok"></i> Confermato
                                </abbr>
                            </td>                         
                            <td><i class="icon-time"></i> Pendente</td>                  
                            <td><small>
                                
                                <i class="icon-calendar muted"></i>
                                inizio
                                <br />
                                
                                <i class="icon-time muted"></i>
                                fine
                                <br />
                                
                                <i class="icon-road muted"></i>
                                luogo
                                <br />
                                
                                <i class="icon-barcode muted"></i>
                               codice
                                <br />
                                
                                
                            </small></td>
                            
                            
                            <td>
                                <div class="btn-group">
                                    <a href="?p=utente.titolo.modifica&t=<?php echo $titolo->id; ?>" title="Modifica il titolo" class="btn btn-small btn-info">
                                        <i class="icon-edit"></i>
                                    </a>
                                    <a  href="?p=utente.titolo.cancella&id=<?php echo $titolo->id; ?>" title="Cancella il titolo" class="btn btn-small btn-warning">
                                        <i class="icon-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endfor; ?>
                    </table>

                </div>
            </div>
         
         
         
         
            
         
         
            
        </div>
    </div>
