<?php

/*
 * ©2013 Croce Rossa Italiana
 */
paginaApp([APP_SOCI , APP_PRESIDENTE]);
menuElenchiVolontari(
    "Volontari in estesione",
    "#",
    "#"
);
$elenco = $me->comitatiApp ([ APP_SOCI, APP_PRESIDENTE ]);
foreach ( $elenco as $unit ){
    $t[] = $unit->locale();
}
$t = array_unique($t);
?>
<form action="?p=presidente.utenti.inestensione.ok" method="POST">
    <div class="row-fluid">
        <div class="row-fluid">
            <div class="span4-centrato">
                <label class="control-label" for="oid">Seleziona Comitato</label>
            </div>
            <div class="span8">
                <select class="input-xxlarge" id="oid" name="oid" required>
                <?php
                    foreach ( $t as $numero ) { ?>
                    <option value="<?php echo $numero->oid(); ?>"><?php echo $numero->nomeCompleto(); ?></option>
                    <?php } ?>
                </select>   
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-success">
        <i class="icon-arrow"></i> Conferma
    </button>
</form>