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
     * @param bool $ancheChiusa se messo a false non ritorna validazioni scaudute
     */
    public static function esiste($codice, $ancheChiusa = true) {
        $v = Validazione::by('codice', $codice);
        if ($v) {
            if (!$ancheChiusa && $v->stato == VAL_CHIUSA) {
                 return false;
            }
            return $v;
        }
        return false;
    }

    public static function generaValidazione($v, $stato, $note = null) {

        $validazione = Validazione::filtra([['volontario', $v],['stato', $stato]]);
        if($validazione){
            return false;
        }

        /*Inserire qui la genereazione della stringa casuale */
        $caratteri= 26;
        $dizionario = DIZIONARIO_ALFANUMERICO;
        $controllo_esistenza = null;
        $codice = generaStringaCasuale($caratteri,$dizionario,$controllo_esistenza);
        /**/

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

    public function volontario() {
        return Volontario::id($this->volontario);
    }

}