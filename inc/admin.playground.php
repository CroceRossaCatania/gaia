<?php

paginaAdmin();

?>
<h2>Playground</h2>
<pre>
<?php

$s = new Sessione;
$s->test = "x";
$s = new Sessione;
$s->test = "x";
$s->foo = "x";

var_dump(Sessione::filtra([['y', 1]]));
var_dump(Sessione::filtra([['test', 1]]));
var_dump(Sessione::filtra([['test', "x"]]));
var_dump(Sessione::filtra([['test', "x"], ["foo", "x"]]));









?>
</pre>

