<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

controllaParametri(array('id'));
$a = Attivita::id($_GET['id']);
$c = Commento::filtra([['attivita', $a],['upCommento', '0']], 'tCommenta DESC');

if (!$a->puoPartecipare($me)) {
    redirect("attivita.scheda&id={$a->id}");
}

?>

<div class="row-fluid">
    <div class="span3">
        <?php menuVolontario(); ?>
    </div>

    <div class="span9">
        <div class="row-fluid">
            <div class="span3 allinea-sinistra">
                <a href="?p=attivita.scheda&id=<?php echo $a->id; ?>" class="btn btn-large">
                    <i class="icon-reply"></i> Attività
                </a>
            </div>
            <div class="span6 allinea-centro">
                <h3><?php echo $a->nome; ?></h3>
            </div>
            <div class="span3">
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12 btn-group allinea-centro">
                <a id="pulsanteScrivi" class="btn">
                    <i class="icon-comment"></i> Commenta
                </a>
            </div>     
        </div>
        <hr />
        <form id="boxScrivi" action="?p=attivita.pagina.commento.ok&id=<?php echo $a->id; ?>" method="POST" class="row-fluid <?php if ( $c ) { ?>nascosto<?php } ?>">
                    <div class="span9">
                        <textarea name="inputCommento" autofocus placeholder="Scrivi il tuo messaggio..." rows="3" class="span12"></textarea>
                      <label>
                            <input type="checkbox" checked name="annuncia" />
                            <strong> 
                               <i class="icon-bullhorn"></i>
                                Annuncia tramite email
                            </strong> ai futuri partecipanti
                        </label>
                    </div>
                    <div class="span3">
                        <button type="submit" class="btn btn-large btn-success btn-block" data-attendere="Invio...">
                            Invia <i class="icon-ok"></i>
                        </button>
                    </div>
                </form>
        <?php
            if(!$c){ ?>
                <div class="alert alert-info">
                    <h3><i class="icon-thumbs-down"></i> Nessuna discussione presente in questa pagina.</h3>
                    <p><strong><?php echo $me->nomeCompleto(); ?></strong>, inizia tu una nuova discussione su questa pagina cliccando su commenta.</p>
                </div>
            <?php }else{
            foreach($c as $_c){ ?>
        <div class="row-fluid">
            <br/>
            <div class="span12 commento">
                <div class="span2 allinea-destra">
                    <?php $g= Volontario::by('id',$_c->volontario); ?>
                    <img src="<?php echo $g->avatar()->img(10); ?>" class="img-polaroid" />
                </div>
                <div class="span8">
                    <p class="text-info"><?php echo $g->nomeCompleto(); ?> <?php echo $_c->quando()->inTesto(); ?></p>
                    <p class="text"><blockquote><?php echo $_c->commento; ?></blockquote></p>
                </div>
                <div class="span2 allinea-destra">
                 <?php if($_c->volontario == $me || $me->admin()){?>
                    <a name="<?= $_c->id; ?>" title="Cancella" href="?p=attivita.pagina.commento.cancella&id=<?php echo $_c; ?>">
                        <i class="icon-remove"></i>
                    </a>
                    <a title="Modifica" href="?p=attivita.pagina.commento.modifica&id=<?php echo $_c; ?>">
                        <i class="icon-edit"></i>
                    </a>
                    
                <?php } ?>
                </div>
            </div>
        </div>
    <?php 
            $n = Commento::filtra([['attivita', $a],['upCommento', $_c->id]]); 
            foreach ($n as$_n){ ?>
        <div class="row-fluid">
            <div class="span11 subcommento">
                <div class="span2 allinea-destra">
                    <?php $g= Volontario::by('id',$_n->volontario); ?>
                        <img src="<?php echo $g->avatar()->img(10); ?>" class="img-polaroid" />
                </div>
                <div class="span8">
                    <p class="text-info"><?php echo $g->nomeCompleto(); ?> <?php echo $_n->quando()->inTesto(); ?></p>
                    <p class="text"><blockquote><?php echo $_n->commento; ?></blockquote></p>
                </div>
                <div class="span2 allinea-destra">
                    <?php if($_n->volontario == $me || $me->admin()){?>
                    <a title="Cancella" href="?p=attivita.pagina.commento.cancella&id=<?php echo $_n; ?>">
                        <i class="icon-remove"></i>
                    </a>
                    <a  title="Modifica"  href="?p=attivita.pagina.commento.modifica&id=<?php echo $_n; ?>">
                        <i class="icon-edit"></i>
                    </a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php } ?>
        <div class="row-fluid">
            <form action="?p=attivita.pagina.commento.ok&h=<?php echo $_c->id; ?>&id=<?php echo $a; ?>" method="POST">
            <div class="span11 subcommento">
                <div class="span2 allinea-destra">
                    <img src="<?php echo $me->avatar()->img(10); ?>" class="img-polaroid" />
                </div>
                <div class="span10">
                    <p class="text-info"><?php echo $me->nomeCompleto(); ?></p>
                    <input name="inputCommento" class="span10" placeholder="Scrivi una risposta..." type="text" class="inputCommento">
                    <button type="submit" class="btn btn-info">
                        <i class="icon-share-alt"></i> Rispondi
                    </button>
                </div>
            </div>
            </form>
        </div>
        <?php } } ?>
    </div>
</div>