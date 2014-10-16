<?php

paginaAdmin();

?>
<h2>Playground</h2>
<pre>
<?php

$nazionale = Nazionale::id(1);
$r_ct  	   = Regionale::id(1);
$p_ct 	   = Provinciale::id(1);
$r_a 	   = Regionale::id(2);

var_dump($nazionale->contiene($r_ct));	// 1
var_dump($r_ct->contiene($p_ct));		// 1
var_dump($p_ct->contiene($r_ct));		// 0
var_dump($r_ct->contiene($r_ct));		// 1
var_dump($r_a->contiene($p_ct));		// 0
var_dump($r_a->contiene($r_ct));		// 0


var_dump($nazionale->dominioComune($r_a));


?>
</pre>

