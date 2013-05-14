<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

$a = $_GET['a'];
$p = Attivita::by('id', $a);
?>

<style type="text/css">
#commento{
    border:1px red solid;   
    margin-left: auto;    
    margin-right: auto;    
    background: #e8e8e8;
    }

#subcommento{
    border:1px tomato solid;   
    position:relative;
    left:74px;  
    background: #ededed;
    }
</style>

<div class="row-fluid">
    <div class="span3">
        <?php menuVolontario(); ?>
    </div>

    <div class="span9">
        <div class="row-fluid">
            <div class="span12">
                <h3><?php echo $p->nome; ?></h3>
                <hr/>
            </div>
            <div class="span12 btn-group allinea-centro">
                <a href="?p=attivita.pagina.commento&a=<?php echo $a; ?>&h=0" class="btn">
                    <i class="icon-comment"></i> Commenta
                </a>
                <a href="?p=attivita.pagina.foto&a=<?php echo $a; ?>" class="btn btn-info">
                    <i class="icon-camera"></i> Foto
                </a>
                <a href="?p=attivita.pagina.verbale&a=<?php echo $a; ?>" class="btn btn-danger">
                    <i class="icon-edit"></i> Verbale
                </a>
            </div>     
        </div>
        <hr /> 
        <?php 
            $c = Commento::filtra([['attivita', $a],['upCommento', '0']]);
            foreach($c as $_c){ ?>
        <div class="row-fluid">
            <br/>
            <div class="span12" id="commento">
                <div class="span2 allinea-destra">
                    <?php $g= Volontario::by('id',$_c->volontario); ?>
                        <img src="<?php echo $g->avatar()->img(10); ?>" class="img-polaroid" />
                </div>
                <div class="span8">
                    <p class="text-info"><?php echo $g->nomeCompleto(); ?> <?php echo $_c->quando()->inTesto(); ?></p>
                    <p class="text"><blockquote><?php echo $_c->commento; ?></blockquote></p>
                </div>
                <div class="span2 allinea-destra btn-group-vertical">
                    <a href="?p=attivita.pagina.commento&a=<?php echo $a; ?>&h=<?php echo $_c; ?>" class="btn">
                        <i class="icon-comment"></i> Commenta
                    </a>
                 <?php if($_c->volontario == $me || $me->admin()){?>
                    <a href="?p=attivita.pagina.commento.modifica&a=<?php echo $_c; ?>" class="btn">
                        <i class="icon-edit"></i> Modifica
                    </a>
                    <a href="?p=attivita.pagina.commento.cancella&a=<?php echo $_c; ?>" class="btn">
                        <i class="icon-remove"></i> Cancella
                    </a>
                <?php } ?>
                </div>
            </div>
        </div>
    <?php 
            $n = Commento::filtra([['attivita', $a],['upCommento', $_c->id]]); 
            foreach ($n as$_n){ ?>
        <div class="row-fluid">
            <div class="span11" id="subcommento">
                <div class="span2 allinea-destra">
                    <?php $g= Volontario::by('id',$_n->volontario); ?>
                        <img src="<?php echo $g->avatar()->img(10); ?>" class="img-polaroid" />
                </div>
                <div class="span8">
                    <p class="text-info"><?php echo $g->nomeCompleto(); ?> <?php echo $_n->quando()->inTesto(); ?></p>
                    <p class="text"><blockquote><?php echo $_n->commento; ?></blockquote></p>
                </div>
                <div class="span2 allinea-destra btn-group-vertical">
                    <?php if($_n->volontario == $me || $me->admin()){?>
                    <a href="?p=attivita.pagina.commento.modifica&a=<?php echo $_n; ?>" class="btn">
                        <i class="icon-edit"></i> Modifica
                    </a>
                    <a href="?p=attivita.pagina.commento.cancella&a=<?php echo $_n; ?>" class="btn">
                        <i class="icon-remove"></i> Cancella
                    </a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php }} ?>
    </div>
</div>