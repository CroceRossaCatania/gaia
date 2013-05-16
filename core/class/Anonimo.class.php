<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class Anonimo extends Utente {
    
    public 
            $id     = 0,
            $nome   = 'Anonimo',
            $cognome= '',
            $email  = 'fittizziacri@mailinator.com';
    
    public function __construct() {
        
    }
    
    public function __set($a, $b) {
        return;
    }
    
    public function __get($a) {
        return null;
    }
    
    
    public function appartenenze() {
        return [];
    }
    
    public function storico() {
        return [];
    }
    
    public function appartenenzePendenti() {
        return [];
    }
    
    public function in(Comitato $c) {
        return false;
    }
    
    public function volontario() {
        return $this;
    }
    
    public function admin() {
        return false;
    }
    
    public function titoli() {
        return [];
    }    
    
    public function titoliPersonali() {
        return [];
    }    
    
    public function titoliTipo( $tipoTitoli ) {
        return [];
    }

    public function haTitolo ( Titolo $titolo ) {
        return false;
    }
    
    public function calendarioAttivita(DT $inizio, DT $fine) {
        $t = [];
        foreach ( Attivita::filtra([['pubblica',  ATTIVITA_PUBBLICA]]) as $a ) {
            $t[] = $a;
        }
        return $t;
    }
    
    public function appartenenzeAttuali($tipo = MEMBRO_VOLONTARIO) {
        return [];
    }
    
    public function comitati($tipo = MEMBRO_VOLONTARIO) {
        return [];
    }
    
    public function unComitato($tipo = MEMBRO_VOLONTARIO) {
        return false;
    }
    
    public function numeroAppartenenzeAttuali($tipo = MEMBRO_VOLONTARIO) {
        return 0;
    }
    
    /*
     * Ritorna le appartenenze delle quali si è presidente.
     */
    public function presidenziante() {
        return [];
    }
    
    public function comitatiPresidenzianti() {
        return [];
    }
    
    public function numVolontariDiCompetenza() {
        return 0;
    }
    
    public function presiede( $comitato = null ) {
        return false;
    }
    
    public function comitatiDiCompetenza() {
        return [];
    }


    public function cancella() {
        return;
    }
    
    public function presidente_numTitoliPending() {
        return 0;
    }
    
    public function presidente_numAppPending() {
        return 0;
    }
    
    public function documento($tipo = DOC_CARTA_IDENTITA) {
        return false;
    }
    
    public function autorizzazioniPendenti() {
        return [];
    }
    
    public function storicoDelegazioni($app = null, $comitato = null) {
        return [];
    }
    
    public function delegazioni($app = null, $comitato = null) {
        return [];
    }
    
    public function comitatiDelegazioni($app = null) {
        return [];
    }
    
    public function dominiDelegazioni($app) {
        return [];
    }
    
    public function partecipazioni( $stato = false ) {
        return [];
    }
    
    
    public function trasferimenti($stato = null) {
        return [];
    }
    
    public function inRiserva() {
        return [];
    }
    
    public function riserve() {
        return [];
    }
    
    public function mieiGruppi() {
        return [];
    }
    
     public function gruppiAttuali() {
        return [];
    }
    
    public function mieReperibilita() {
        return [];
    }
    
    public function areeDiResponsabilita() {
        return [];
    }
    
    public function areeDiCompetenza( $c = null ) {
        return [];
    }
    
    public function comitatiAreeDiCompetenza() {
        return [];
    }
    
    
    public function attivitaReferenziate() {
        return [];
    }
            
    public function attivitaReferenziateDaCompletare() {
        return [];
    }
    
    public function attivitaAreeDiCompetenza() {
        return [];
    }
    
    public function attivitaDiGestione() {
        return [];
    }
    
    
    
}