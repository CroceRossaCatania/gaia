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


        /* 
         * Issue #847: se trovo validazione aperta la chiudo e ne faccio una nuova
         */
        if($validazione){
            $validazione = $validazione[0];
            $validazione->stato = VAL_ANNULLATA;
            $validazione->timestamp = time();
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
        if ($v && (int) $v->stato > VAL_CHIUSA) {
            return $v;
        }
        return false;
    }

    /**
     * Restituisce il volontario di una validazione
     * @return volontario
     */
    public function utente() {
        return Utente::id($this->volontario);
    }

    public static function chiudi() {
        $valpass = Validazione::filtra([['stato', VAL_PASS]]);
        $valmail = Validazione::filtra([['stato', VAL_MAIL]]);
        $valmails = Validazione::filtra([['stato', VAL_MAILS]]);
        $validazioni = array_merge($valpass, $valmail);
        $validazioni = array_merge($validazioni, $valmails);
        $duegiornifa = time() - DUEGIORNI;
        foreach ($validazioni as $v) {
            if($v->timestamp < $duegiornifa) {
                $v->stato = VAL_CHIUSA;
            }
        }

    }

}