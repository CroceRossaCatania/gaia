<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class Validazione extends Entita {

    protected static
        $_t  = 'validazioni',
        $_dt = null;

    /**
     * Verifica se una validazione è già esistente
     * @param string $codice la codifica della validazione
     */
    public static function esiste($codice) {
        $v = Validazione::by('codice', $codice);
        if ($v) {
            return true;
        }
        return false;
    }

    public static function generaValidazione($v, $stato, $note = null) {

        $validazione = Validazione::filtra([['volontario', $v],['stato', $stato]]);
        if($validazione){
            return false;
        }

        /*Inserire qui la genereazione della stringa casuale */
        $codice = generaStringaCasuale(26, DIZIONARIO_ALFANUMERICO, array($this, 'esiste'));

        $val = new Validazione();
        $val->codice = $codice;
        $val->stato = $stato;
        $val->volontario = $v;
        $val->timestamp = time();
        if ($note) {
            $val->note = $note;
        }
        return $codice;
    }

    public static function cercaValidazione($codice, $stato) {
        $v = Validazione::filtra([
            ['codice', $codice],
            ['stato', $stato]]);
        if ($v) {
            return $v[0];
        }
        return false;
    }

    public function volontario() {
        return Volontario::id($this->volontario);
    }

}