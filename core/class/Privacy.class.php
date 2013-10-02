<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class Privacy extends Entita {
        
    protected static
        $_t  = 'privacy',
        $_dt = null;
    
 	public function __call( $parametro, $altrui ) {
 
		if ( !$altrui || ! $altrui[0] instanceOf Persona )
			return false;
		$altrui = $altrui[0];
			return (bool) (
		// a) sono admin
		$this->admin()
		// b) sono presidente del di lui comitato
		or $altrui->presiede( $this->volontario()->unComitato() )
		// c) a tutti i volontari
		or $this->{$parametro} >= PRIVACY_VOLONTARI
		// d) siamo nello stesso comitato locale & impostazioni di conseguenza
		or (
			$this->volontario()->unComitato()->locale() == $altrui->unComitato()->locale()
			and $this->{$parametro} >= PRIVACY_COMITATO
			)
		);
	}

	// vaffanculo! e tu sai perche. stronzo!
    public function volontario() {
        return Volontario::by('id', $this->volontario);
    }
    
}