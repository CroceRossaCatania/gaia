<?php 

$id = $_GET['id'];
$turno = Turno::by('id', $id);

$richiesta = true;
foreach($turno->richieste() as $r ){
    foreach($r->elementi() as $e){
    	if(!$me->verificaTitolo($e->titolo())){
    		$richiesta=false;
    	}
    }
}

echo "<br/>risultato ",$richiesta;
echo $turno->prenotazione;
echo "<br/>",$turno->fine, "<br/>";
echo time(), "<br/>";
if(time() >= $turno->prenotazione && $richiesta && $turno->attivita()->puoPartecipare($me)){
	echo "ok";
}