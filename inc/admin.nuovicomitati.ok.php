<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaAdmin();

if ( !isset($_GET['livello']) ) { 
	redirect('utente.me');
}

$livello = (int) $_GET['livello'];

function genera_elenco($livello) {
	switch ($livello) {
	case EST_NAZIONALE:
		return Nazionale::elenco();
		break;
	case EST_REGIONALE:
		return Regionale::elenco();
		break;
	case EST_PROVINCIALE:
		return Provinciale::elenco();
		break;
	case EST_LOCALE:
		return Locale::elenco();
		break;
	case EST_UNITA:
		return Comitato::elenco();
		break;
	default:
		break;
	}
}

function recupera_proprieta($comitato, $livello) {
	switch($livello) {
		case EST_NAZIONALE: $table = 'datiNazionali';
							break;
		case EST_REGIONALE: $table = 'datiRegionali';
							break;
		case EST_PROVINCIALE: $table = 'datiProvinciali';
							break;
		case EST_LOCALE: $table = 'datiLocali';
							break;
		case EST_UNITA: $table = 'datiComitati';
							break;
	}
	global $db;
    $q = $db->prepare("
        SELECT
            nome, valore
        FROM
            {$table}
        WHERE
            id = :id
        ");
    $q->bindParam(':id', $comitato->id);
    $q->execute();
    $r = [];
    while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
        $r[$k[0]] = $k[1];
    }
    return $r;

}



?>

<div class="row-fluid">
	<?php echo("Modifica livello {$conf['est_obj'][$livello]} <br />"); 
	$elenco = genera_elenco($livello);

	$vecchi = ComitatoNuovo::filtra([['estensione', $livello]]);
	foreach ($vecchi as $v) {
		$v->cancella();
	}

	foreach ($elenco as $c) {
		echo("{$c->nome} <br />");
		$nuovo = new ComitatoNuovo();
		$nuovo->nome = $c->nome;
		$nuovo->vecchio_id = $c->id;
		$nuovo->estensione = $livello;
		if ($c->nazionale) {
			$vecchio = ComitatoNuovo::filtra([
											['estensione', EST_NAZIONALE],
											['vecchio_id', $c->nazionale]
											])[0];
			$nuovo->superiore = $vecchio->id;
		} elseif($c->regionale) {
			$vecchio = ComitatoNuovo::filtra([
											['estensione', EST_REGIONALE],
											['vecchio_id', $c->regionale]
											])[0];
			$nuovo->regionale = $vecchio->id;
		} elseif ($c->provinciale) {
			$vecchio = ComitatoNuovo::filtra([
											['estensione', EST_PROVINCIALE],
											['vecchio_id', $c->provinciale]
											])[0];
			$nuovo->provinciale = $vecchio->id;
		} elseif($c->locale) {
			$vecchio = ComitatoNuovo::filtra([
											['estensione', EST_LOCALE],
											['vecchio_id', $c->locale]
											])[0];
			$nuovo->locale = $vecchio->id;
		}

		if ($c->principale) {
			$nuovo->principale = $c->principale;
		}

		$attributi = recupera_proprieta($c, $livello);
		foreach ($attributi as $key => $value) {
			echo("{$key} -> {$value} <br />");
			$nuovo->$key = $c->$key;
		}
		if($nuovo->formattato) {
			$nuovo->localizzaStringa($nuovo->formattato);
		}

		?>
		<br />Forse ho fatto... abbiamo nuovo comitato di livello <?php echo $livello; ?> con ID <?php echo $nuovo->id; ?>
		che si chiama <?php echo $nuovo->nome; ?> e oid() legacy <?php echo $nuovo->oid(); ?>.

		<?php
	}

	?>
</div>