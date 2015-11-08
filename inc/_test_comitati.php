
<?php
/*
 * ©2013 Gaia è costruita in maniera strana
 */

$idVolontari = array(
    $me->id
);

// $delegazioni = $me->comitatiDelegazioni(APP_OBIETTIVO);
// $presidenzianti = $me->comitatiPresidenzianti();
$cmts = $me->unitaDiCompetenza();
var_dump("<pre>");
print_r($cmts);
var_dump("<pre style='background:red'>");

var_dump("<pre>");
$deleghe = array_merge($me->entitaDelegazioni(APP_OBIETTIVO), $me->entitaDelegazioni(APP_PRESIDENTE));
foreach($deleghe as $d){
    print_r(Utility::comitatoPermessi($d));
}
die("aaa");
$comitati = array_merge($delegazioni, $presidenzianti);

print "<pre style='background: pink'>";
print_r($comitati);
print "</pre>";


//$comitati = Comitato::elenco();
$permessi = array("locale" => 0, "provinciale" => 0, "regionale" => 0, "nazionale" => 0);

foreach($comitati as $c){


   /* print_r($c); */
    print "<b>"."[".$c->id."]".$c->nome."</b>";
    print "<pre>";
    $_permessi = 
    $permessi['locale'] = $permessi['locale'] | $_permessi['locale'];
    $permessi['provinciale'] = $permessi['provinciale'] | $_permessi['provinciale'];
    $permessi['regionale'] = $permessi['regionale'] | $_permessi['regionale'];
    $permessi['nazionale'] = $permessi['nazionale'] | $_permessi['nazionale'];
    print "</pre>";
    
}
    print "<pre>";
    print_r($permessi);
    print "</pre>";
    
    /*
foreach ($comitati as $c) {
    print "<pre>";
    print_r($c);
    print "</pre>";
    
    print "<pre>";
    print_r($c->locale());
    print "</pre>";
    
    print "<pre>";
    $c->provinciale();
    print "</pre>";

    print "<pre>";
    $c->regionale();
    print "</pre>";
    
    print "<pre>";
    $c->nazionale();
    print "</pre>";
    
}
*/
/*
foreach ($idVolontari as $id) {
    $volontario = Volontario::id(id);
    print_r($volontario->comitati());
}
 * 
 */

?>