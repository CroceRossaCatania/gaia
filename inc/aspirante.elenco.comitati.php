<?php

paginaPrivata();

if ( $me->stato != ASPIRANTE )
    redirect('utente.me');

// Se non ho ancora registrato il mio essere aspirante
if ( !($a = Aspirante::daVolontario($me)) )
    redirect('aspirante.registra');

?>
<div class="row-fluid">
    <div class="span3">
        <?php menuAspirante(); ?>
    </div>
    <div class="span9">

        <h2><i class="icon-list"></i> Elenco delle unità CRI presenti nella tua zona</h2>
        <?php if(isset($_GET['err'])) { ?>
            <div class="alert alert-block alert-error">
            <h4><i class="icon-warning-sign"></i> <strong>Qualcosa non ha funzionato</strong>.</h4>
            <p>L'operazione che stavi tentando di eseguire non è andata a buon fine. Per favore riprova.</p>
            </div> 

        <?php } ?>


        <div class="row-fluid">
            <div class="span12">

                <table class="table table-striped table-bordered">

                    <thead>
                        <th> 
                            Comitato
                        </th>
                        <th>
                            Luogo
                        </th>
                        <th>
                            Telefono
                        </th>

                        <th>
                            Azione
                        </th>
                    </thead>

                    <?php foreach ( $a->comitati() as $c ) { ?>

                    <tr>

                        <td style="width: 20%;">
                            <?php echo $c->nomeCompleto(); ?>
                        </td>
                        <td style="width: 45%;">
                            <?php echo($c->formattato);?>
                        </td>
                
                        <td style="width: 15%;">
                            <?php echo($c->telefono);?>
                        </td>
                        
                        <td style="width: 20%;">
                            <a href="?p=formazione.corsibase.modifica&id=<?php echo $corso->id; ?>">
                                <i class="icon-edit"></i> Manda email
                            </a>
                            <br />      
                        </td>
                        
                    </tr>

                    <?php } ?>

                </table>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <a class="btn btn-block btn-large" href="?p=public.comitati.mappa">
                    <i class="icon-globe"></i>
                    Mappa di tutti i comitati
                </a>
            </div>
        </div>          
    </div>
</div>
