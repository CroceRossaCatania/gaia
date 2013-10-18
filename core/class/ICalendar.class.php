<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class ICalendar extends File {
    
    public function genera($attivita, $turno) {

        $att = Attivita::id($attivita);
        $turno = Turno::id($turno);
        $ref = Volontario::id($att->referente);
        $c = $att->comitato();
        $name = ''.date('Ymd_THis', $turno->inizio).'_'.$turno->id.'_.ics';

        /* Strutturo il file */
        $this->autore  = $sessione->utente;
        $this->nome    = $name;
        $this->mime    = 'text/calendar; charset=utf-8; method=REQUEST';

        /* Inserisco le informazioni */
        $s = "BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//Croce Rossa Italiana//Progetto GAIA//IT
METHOD:REQUEST
BEGIN:VTIMEZONE
TZID:Europe/Rome
BEGIN:DAYLIGHT
TZOFFSETFROM:+0100
TZOFFSETTO:+0200
TZNAME:CEST
DTSTART:19700329T020000
RRULE:FREQ=YEARLY;BYMONTH=3;BYDAY=-1SU
END:DAYLIGHT
BEGIN:STANDARD
TZOFFSETFROM:+0200
TZOFFSETTO:+0100
TZNAME:CET
DTSTART:19701025T030000
RRULE:FREQ=YEARLY;BYMONTH=10;BYDAY=-1SU
END:STANDARD
END:VTIMEZONE
BEGIN:VEVENT
DTSTAMP:".date('Ymd\THis', time())."
DTSTART;TZID=Europe/Rome:".date('Ymd\THis', $turno->inizio)."
DTEND;TZID=Europe/Rome:".date('Ymd\THis', $turno->fine)."
SUMMARY:".$att->nome.": ".$turno->nome."
LOCATION:".$att->luogo."
UID:".$turno->id."
DESCRIPTION:\nTurno organizzato da ".$c->nomeCompleto().",
dettagli: ".strip_tags($att->descrizione)."
ORGANIZER;CN=\"".$ref->nomeCompleto()."\":mailto:".$ref->email."
END:VEVENT
END:VCALENDAR\n";

        file_put_contents($this->percorso(), utf8_encode($s));
    }    
}
