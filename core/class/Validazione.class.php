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

    /**
     * Crea la validazione
     * @param $v id volontario
     * @param $stato tipologia di validazione da effettuare
     * @param $note default null, eventuali campi aggiuntivi
     * @return codice o false nel caso in cui sia già presente una richiesta
     */
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

    /**
     * Cerca la validazione per codice e controlla se è attiva
     * @param $codice della validazione da cercare
     * @return validazione o false nel caso in cui sia assente o scaduta
     */
    public static function cercaValidazione($codice) {
        $v = Validazione::by('codice', $codice);
        if ($v && $v->stato !=VAL_CHIUSA) {
            return $v;
        }
        return false;
    }

    /**
     * Restituisce il volontario di una validazione
     * @return volontario
     */
    public function volontario() {
        return Volontario::id($this->volontario);
    }

}