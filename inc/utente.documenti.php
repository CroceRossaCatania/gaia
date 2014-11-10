<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

?>
<div class="row-fluid">
    <div class="span3">
        <?php        menuVolontario(); ?>
    </div>
    <div class="span9">
        <div class="row-fluid">
            
            <div class="row-fluid">
                <div class="span7">
                    <h2>
                        <i class="icon-folder-open muted"></i>
                        Documenti
                    </h2>
                </div>
                <div class="span5">
                    <?php if ( $me->documenti() ) { ?>
                        <a href="?p=utente.documenti.zip" class="btn btn-large btn-block btn-inverse" data-attendere="Generazione file in corso...">
                            <i class="icon-download-alt"></i>
                            Scarica i miei documenti in ZIP
                        </a>
                    <?php } else { ?>
                        <a href="javascript:alert('Nessun documento presente.');" class="btn btn-large btn-block btn-inverse disabled">
                            <i class="icon-download-alt"></i>
                            Scarica i miei documenti in ZIP
                        </a>
                    <?php } ?>
                </div>
            </div>
            
            <p>Da questa sezione puoi visualizzare, modificare e caricare i tuoi documenti.</p>
            <hr />
            <div class="row-fluid allinea-sinistra">
                
                <?php if ( isset($_GET['ok']) ) { ?>
                    <div class="alert alert-success">
                        <i class="icon-ok"></i>
                        <strong>Grazie.</strong>
                        Il documento è stato caricato con successo.
                    </div>
                    <hr />
                <?php } elseif ( isset($_GET['err']) ) { ?>
                    <div class="alert alert-error">
                        <i class="icon-warning-sign"></i>
                        <strong>Errore</strong> &mdash; File non selezionato, troppo grande o non valido. Si accettano file come <strong>JPG</strong>, <strong>PNG</strong>, ecc.
                    </div>
                    <hr />
                <?php }?>
                    
                <?php foreach ( $me->storico() as $app ) {
                         if($app->stato == MEMBRO_DIMESSO){ $a=1;}} ?>
                    
            <?php foreach ( $conf['docs_tipologie'] as $tipo => $nome ) { ?>
                
                <a class="btn btn-large" id="_<?php echo $tipo; ?>_pulsante" onclick="$(this).hide();$('#_<?php echo $tipo; ?>_cont').show();">
                    <i class="icon-chevron-right muted"></i>
                    <?php echo $nome; ?>
                </a>
                
                <div style="display: none;" class="row-fluid" id="_<?php echo $tipo; ?>_cont">
                    <p>
                        <a class="btn btn-large btn-inverse" onclick="$('#_<?php echo $tipo; ?>_cont').hide();$('#_<?php echo $tipo; ?>_pulsante').show();">
                            <i class="icon-chevron-down muted"></i>
                            <?php echo $nome; ?>
                        </a>
                    </p>
                    
                    <?php if ( $d = $me->documento($tipo) ) { ?>

                    
                    <div class="row-fluid">
                        <div class="span5 allinea-centro">
                            
                            <div class="alert alert-info allinea-sinistra">
                                <i class="icon-time"></i>
                                Documento caricato il <strong><?php echo date('d-m-Y', $d->timestamp); ?></strong>.
                            </div> 
                            
                            <p><img src="<?php echo $d->anteprima(); ?>" class="img-polaroid" /></p>
                            <p>
                                <a href="<?php echo $d->originale(); ?>" class="btn btn-primary" target="_new">
                                    <i class="icon-download"></i>
                                    Scarica questo documento
                                </a>
                            </p>
                            
                        </div>
                    
                        <div class="span7">
                            <?php if($a!=1){ ?>
                            <form class="modDocumento" action="?p=utente.documenti.ok" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="tipo" value="<?php echo $tipo; ?>" />
                                <h3>
                                    <i class="icon-edit"></i>
                                    Modifica o carica nuovo documento
                                </h3>
                                <p>Nel caso tu voglia aggiornare o modificare il documento,<br />
                                    segui queste istruzioni:</p>
                                <ol>
                                    <li>
                                        <p>
                                            <strong>Seleziona il file</strong> in formato <strong>JPG,PNG</strong> dal tuo computer:<br />
                                             <input type="file" name="file" />
                                        </p>
                                    </li>

                                    <li><p>
                                        <strong>Clicca sul pulsante</strong>:<br />
                                        <button type="submit" class="btn btn-success">
                                            <i class="icon-save"></i> Carica documento
                                        </button>
                                        </p>
                                    </li>
                                </ol>
                                

                            </form>
                            <?php } ?>
                        </div>
                    </div>

                    <?php } else { ?>
                         <div class="row-fluid">
                        <div class="span5 allinea-centro">
                            
                            <div class="alert alert-warning allinea-sinistra">
                                <i class="icon-warning-sign"></i>
                                Nessun documento caricato.
                            </div> 
                            
                            <p>
                                
                            </p>
                            
                        </div>
                    
                        <div class="span7">
                            <?php if($a!=1){ ?>
                            <form class="modDocumento" action="?p=utente.documenti.ok" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="tipo" value="<?php echo $tipo; ?>" />
                                <h2>
                                    <i class="icon-plus"></i>
                                    Aggiungi il documento
                                </h2>
                                <ol>
                                    <li>
                                        <p>
                                            <strong>Seleziona il file</strong> in formato <strong>JPG,PNG</strong> dal tuo computer:<br />
                                             <input type="file" name="file" />
                                        </p>
                                    </li>

                                    <li><p>
                                        <strong>Clicca sul pulsante</strong>:<br />
                                        <button type="submit" class="btn btn-success">
                                            <i class="icon-save"></i> Carica documento
                                        </button>
                                        </p>
                                    </li>
                                </ol>

                            <?php } ?>
                            </form>
                        </div>
                         </div>
                    
                    <?php } ?>
                    
                    
                </div>
                
                <hr />
                
                
            <?php } ?>
                
        
            </div>
        </div>
    </div>
</div>
