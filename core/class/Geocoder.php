<?php

/*
 * ©2012 Alfio Emanuele Fresta
 */

class Geocoder {
    
    public 
            $risultati;
    
    const GEOCODING_URL = 'http://maps.googleapis.com/maps/api/geocode/json?sensor=false&language=it&address=';
     
    public function __construct( $query ) {
        
        $res = [
            'civico'    =>  [ 'street_number', 'long_name' ],
            'via'       =>  [ 'route', 'long_name' ],
            'comune'    =>  [ 'locality', 'long_name' ],
            'provincia' =>  [ 'administrative_area_level_2', 'long_name' ],
            'regione'   =>  [ 'administrative_area_level_1', 'long_name' ],
            'stato'     =>  [ 'country', 'short_name' ],
            'cap'       =>  [ 'postal_code', 'long_name' ]
        ];  
        $query = urlencode($query);
        $url = self::GEOCODING_URL . $query;
        $query = file_get_contents($url);
        $query = json_decode($query);
        if ( !$query->results ) {
            $this->risultati = [];
            return;
        }
        foreach ( $query->results as $r ) {
            $n = new GeocoderResult();
            foreach ( $r->address_components as $ac ) {
                foreach ( $res as $pr => $va ) {
                    if ( in_array($va[0], $ac->types) ) {
                        $n->{$pr} = $ac->{$va[1]};
                    }
                } 
            }
            $n->lat = $r->geometry->location->lat;
            $n->lng = $r->geometry->location->lng;
            $n->provincia = str_replace('Province of ', '', $n->provincia);
            $n->indirizzo = $n->via . ', ' . $n->civico;
            $n->formattato = $r->formatted_address;
            $n->formattato = str_replace('Province of ', '', $n->formattato);
            $this->risultati[] = $n;
        }
    }
    
}