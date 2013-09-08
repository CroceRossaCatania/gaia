<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class ICalendar extends File {
    
    public function __construct($turno) {
        
        global $sessione;
        $turno = new Turno($turno);


        /* Strutturo il file */
        $this->autore  = $sessione->utente;
        $this->nome    = ''.date('Ymd_THis', $turno->inizio).'_'.$turno->nome. '_.ics';
        $this->mime    = 'text/calendar';

    }

    public function genera($attivita, $turno) {

        $att = new Attivita($attivita);
        $turno = new Turno($turno);
        $ref = new Volontario($att->referente);
        $c = new Comitato($att->comitato);

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
        SUMMARY:".$attivita->nome.": ".$turno->nome.",  
        LOCATION:".$attivita->luogo."
        UID:".$turno->id."
        DESCRIPTION:Turno organizzato da".$c->nomeCompleto()." per ".strip_tags($attivita->descrizione)."\n\n\n
        ORGANIZER;CN=".$ref->nomeCompleto().":mailto:".$ref->email."
        END:VEVENT
        END:VCALENDAR
        ";

        file_put_contents($this->percorso(), $s);
    }    
}
