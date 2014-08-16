<?php

paginaAdmin();

?>
<h2>Playground</h2>
<pre>
<?php

$v = Utente::filtra([
	['codiceFiscale', 'FRSLMN%', OP_LIKE]
]);

var_dump($v);





?>
</pre>

