<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class ICalendar extends File {
    
    public function genera($attivita, $turno) {

        $att = new Attivita($attivita);
        $turno = new Turno($turno);
        $ref = new Volontario($att->referente);
        $c = new Comitato($att->comitato);
        $name = ''.date('Ymd_THis', $turno->inizio).'_'.$turno->id.'_.ics';

        /* Strutturo il file */
        $this->autore  = $sessione->utente;
        $this->nome    = $name;
        $this->mime    = 'text/calendar; charset=UTF-8; method=REQUEST';

        /* Inserisco le informazioni */
        $s = "
        BEGIN:VCALENDAR
        VERSION:2.0
        PRODID:-//Croce Rossa Italiana//Progetto GAIA//IT
        CALSCALE:GREGORIAN
        METHOD:REQUEST
        BEGIN:VEVENT
        DTSTAMP:".date('Ymd\THis\Z', time())."
        DTSTART:".date('Ymd\THis\Z', $turno->inizio)."
        DTEND:".date('Ymd\THis\Z', $turno->fine)."
        SUMMARY:".$att->nome.": ".$turno->nome."  
        LOCATION:".$att->luogo."
        UID:".$turno->id."
        DESCRIPTION:\nTurno organizzato da".$c->nomeCompleto().",
        dettagli: ".strip_tags($att->descrizione)."
        ORGANIZER;CN=".$ref->nomeCompleto().":mailto:".$ref->email."
        END:VEVENT
        END:VCALENDAR
        ";

        file_put_contents($this->percorso(), $s);
    }    
}
