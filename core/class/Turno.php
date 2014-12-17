<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class Turno extends Entita {
    
    protected static
        $_t  = 'turni',
        $_dt = null;

    use EntitaCache;
    
    public function attivita() {
        return Attivita::id($this->attivita);
    }

    public function inizio() {
        return DT::daTimestamp($this->inizio);
    }

    public function fine() {
        return DT::daTimestamp($this->fine);
    }
    
    public function prenotazione() {
        return DT::daTimestamp($this->prenotazione);
    }

    public function partecipazioni() {
        return Partecipazione::filtra([
            ['turno',   $this->id]
        ]);
    }

    public function haRichiestoPartecipazione(Utente $v) {
        $r = $this->partecipazioni();
        foreach ($r as $_r) {
            if ($_r->volontario()->id == $v->id) {
                return true;
            }
        }
        return false;
    }
    
    public function volontari( $stato = PART_OK ) {
        $r = [];
        foreach ( $this->partecipazioniStato($stato) as $p ) {
            $r[] = $p->volontario();
        }
        return $r;
    }
    
    
    public function partecipazioniStato($stato = PART_OK) {
        return Partecipazione::filtra([
            ['turno',   $this->id],
            ['stato',   $stato]
        ]);
    }
    
    public function cancella() {
        foreach ( $this->partecipazioni() as $part ) {
            $part->cancella();
        }
        parent::cancella();
    }
    
    public function durata() {
        return $this->inizio()->diff($this->fine());
    }
    
    public function partecipazione(Utente $v) {
        $p = Partecipazione::filtra([
            ['turno',       $this->id],
            ['volontario',  $v->id]
        ]);
        if ( $p ) {
            return $p[0];
        } else {
            return null;
        }
    }

    /**
     * Ritorna se la prenotazione risulta essere ritirabile
     * @param mixed $v Riferimento all'utente
     * @return bool true se esiste una partecipazione ed e ritirabile, altrimenti false
     */
	public function partecipazioneRitirabile(Utente $v) {
    	$val=$this->partecipazione($v);
    	return (bool) ($val && $val->ritirabile());	
    }
    /**
     * Ritorna lo stato della prenotazione se presente(in attesa, concessa, negata)
     * @param mixed $v Riferimento all'utente
     * @return null | int Stato partecipazione se esiste altrimenti null
     */
    public function partecipazioneStato(Utente $v) {
    	$val=$this->partecipazione($v);
    	if($val)
    		return $val->stato;
    	return val;
    }
    
    public function partecipa(Utente $v) {
        return (bool) $this->partecipazione($v);
    }

    public function chiediPartecipazione(Utente $v) {
        if ( !$this->puoRichiederePartecipazione($v) )
            return false;
        $p = new Partecipazione;
        $p->turno       = $this;
        $p->volontario  = $v;
        $p->generaAutorizzazioni();
        return true;
    }

    /**
     * Usata per chiedere la partecipazione, da parte di un Presidente, per un
     * suo volontario. Si assume verificato il rapporto di presidente/volontario.
     *
     * Richiede utente identificato tramite Sessione web ($sessione globale).
     *
     * @param Utente $presidente    Il presidente che effettua la richiesta
     * @param Utente $v             Il volontario che intende partecipare all'attivita'
     * @return bool                 Riuscito o non riuscito
     */
    public function chiediPartecipazionePerVolontario(Utente $presidente, Utente $v) {
        $r = $this->chiediPartecipazione($v);
        if ( !$r ) { return false; }
        $p = $this->partecipazione($v);
        $a = new Autorizzazione();
        $a->partecipazione = $this->id;
        $a->volontario     = $presidente;
        $a->concedi($presidente);
        return true;
    }
        
    public static function neltempo(DT $inizio, DT $fine) {
        global $db;
        $q = "
            SELECT
                turni.id
            FROM
                turni, attivita
            WHERE
                turni.fine    <= :fine
            AND
                turni.inizio  >= :inizio
            AND
                attivita.id = turni.attivita
            AND
                attivita.stato = :stato
            ORDER BY
                inizio ASC";
        $q = $db->prepare($q);
        $inizio = $inizio->getTimestamp();
        $fine   = $fine->getTimestamp();
        $q->bindParam(':fine', $fine);
        $q->bindParam(':inizio', $inizio);
        $q->bindValue(':stato', ATT_STATO_OK);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = Turno::id($k[0]);
        }
        return $r;
    }
    
    public function puoPartecipare(Utente $v) {
        return $this->attivita()->puoPartecipare($v);
    }
    
    public function puoRichiederePartecipazione($v) {
        if ( $v === null || $v instanceof Anonimo ) { return true; }
        return (( time() <= $this->fine ) 
                && ( time() <= $this->prenotazione ) 
                && $this->attivita()->puoPartecipare($v)
                && !$this->haRichiestoPartecipazione($v));
    }

    public function scoperto() {
        return (bool) ( count($this->partecipazioniStato()) < $this->minimo && $this->inizio()->getTimestamp() > time() );
    }
    
    public function pieno() {
        return (bool) ( count($this->partecipazioniStato()) >= $this->massimo );
    }
    
    public function futuro() {
        $ora = new DT;
        return (bool) ( $this->fine() > $ora );
    }
    
    public function passato() {
        return !$this->futuro();
    }
    
    public function richieste() {
        return RichiestaTurno::filtra ([
            ['turno', $this->id] 
        ]);
    }

    public function toJSON( $user ) {
        return [
            'id'                 =>  $this->id,
            'nome'               =>  $this->nome,
            'inizio'             =>  $this->inizio(),
            'fine'               =>  $this->fine(),
            'durata'             =>  $this->durata(),
            'pieno'              =>  $this->pieno(),
            'futuro'             =>  $this->futuro(),
            'scoperto'           =>  $this->scoperto(),
            'puoRichiedere'      =>  $this->puoRichiederePartecipazione($user),
            'partecipa'          =>  $this->partecipa($user),
            'partecipazione'     =>  $this->partecipazione($user),
            'ritirabile'         =>  $this->partecipazioneRitirabile($user),
            'stato'              =>  $this->partecipazioneStato($user)
        ];
    }
}
