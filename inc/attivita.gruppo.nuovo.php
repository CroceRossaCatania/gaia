<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();
paginaAttivita();

controllaParametri(array('id'));
$attivita = $_GET['id'];
$attivita = Attivita::id($attivita);

paginaAttivita($attivita);

$g = new Gruppo();
	$g->nome        =   $attivita->nome;
	$g->comitato    =   $attivita->comitato()->oid();
	$g->obiettivo   =   $attivita->area()->obiettivo;
	$g->area        =   $attivita->area();
	$g->referente   =   $attivita->referente();
	$g->attivita 	=	$attivita->id;
	if ($attivita->comitato()->_estensione() == EST_REGIONALE) {
        $g->estensione  =   EST_GRP_REGIONALE;    
    } elseif ($attivita->comitato()->_estensione() == EST_PROVINCIALE) {
        $g->estensione  =   EST_GRP_PROVINCIALE;
    } elseif ($attivita->comitato()->_estensione() == EST_LOCALE) {
        $g->estensione  =   EST_GRP_LOCALE;
    } else {
        $g->estensione  =   EST_GRP_UNITA;
    }

redirect('attivita.scheda&gok&id=' . $attivita->id);

?>
