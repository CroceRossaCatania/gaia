<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(array('id'), 'admin.presidenti&err');
$t = $_GET['id'];
$v = Volontario::id($t);

?>

<h3>
  <i class="icon-gears"></i>
  Nomina <?php echo $v->nomeCompleto(); ?> presidente di...
</h3>

<table class="table table-condensed table-striped">
<?php 
$livello = 0;
$massimo = 5;
$ricorsiva = function( $comitato ) use (&$ricorsiva, &$livello, $massimo, $v) {
    ?>
    <tr>
        <?php for ( $a = 0; $a <= $livello; $a++ ) { ?>
            <td>&nbsp;</td>
        <?php } ?>
        <td data-livello="<?php echo $livello; ?>" colspan="<?php echo ($massimo - $livello); ?>">
                <?php if ( $comitato instanceOf Comitato ) { ?>
                    <?php echo $comitato->nome; ?>
                <?php } else { ?>
                    <strong><?php echo $comitato->nomeCompleto(); ?></strong>
                <?php } ?>
        </td>

            <td>
                    <a 
                        href="?p=admin.presidente.nuovo.ok&v=<?php echo $v->id; ?>&oid=<?php echo $comitato->oid(); ?>"
                        data-attendere="generazione..."
                        >
                        <i class="icon-ok"></i>
                        nomina presidente
                    </a>
            </td>

        <?php if ($figli = $comitato->figli()) { 
            $livello++;
            ?>
                <?php foreach ( $figli as $figlio ) {
                    $ricorsiva($figlio);
                } ?>
            
        <?php 
        $livello--;
        } ?>
    <?php
};

$n = new Nazionale(1);
$ricorsiva($n);

?>
</table>
