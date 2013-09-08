<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class ICalendar extends File {
    
    public function creaCalendar($attivita, $turno) {
        
        /* Genero quel che mi serve per popolare */
        $turno = new Turno($turno);
        $att = new Attivita($attivita);
        $ref = new Volontario($att->referente);

        /* Strutturo il file */
        $f = new File();
        $f->autore  = $this->utente;
        $f->nome    = ''.date('Ymd_THis', $turno->inizio).'_'.$turno->nome. '_.ics';
        $f->mime    = 'text/calendar';

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
        DTEND:".date('Ymd\THis\Z', $turno->inizio)."
        SUMMARY:Trip Milano Centrale-Roma Termini\, Train Frecciarossa 9607\, Coa
         ch 8\, Position 4D\, PNR UVPNEN\,  
        LOCATION:".$attivita->luogo."
        UID:".$turno->id."
        DESCRIPTION:".$attivita->descrizione."\n\n\n
        ORGANIZER;CN=".$ref->nomeCompleto().":mailto:".$ref->email."
        END:VEVENT
        END:VCALENDAR
        ";
        file_put_contents($this->percorso(), $s);

        return $f;
    }    
}
