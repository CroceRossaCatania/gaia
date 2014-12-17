<?php

paginaAdmin();

?>
<h2>Playground</h2>
<pre>
<?php


$com	   = Comitato::id(56);
echo $com->nomeCompleto();
echo "<br />";
echo $com->principale;
echo "<br />";
echo $com->linkMappa();


?>
</pre>

