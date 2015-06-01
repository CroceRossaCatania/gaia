<?php

/*
 * ©2012 Croce Rossa Italiana
 */

class Errore extends Exception {
   
    public
            $codice,
            $messaggio,
            $timestamp,
            $extra = null;
    
    public function __construct($code = 1000) {
        global $conf;
        $this->codice = $code;
        if (isset($conf['errori'][$code])) {
            $this->messaggio = $conf['errori'][$code];
        } else {
            $this->messaggio = $conf['errori'][1000];
        }
        $this->timestamp = time();
        parent::__construct($this->messaggio, $code, null);
    }
    
    public function __toString() {
        $backtrace = json_encode($this->getTrace(), JSON_PRETTY_PRINT);
        return date('YmdHis', $this->timestamp) . " [ERR #" . $this->codice . "]: " . $this->messaggio . "\t{$this->extra}\n\nBacktrace:\n{$backtrace}";
    }
	
	public function toJSON() {
		return [
			'errore' => [
				'codice'	=>	$this->codice,
				'messaggio'	=>	$this->messaggio,
				'timestamp'	=>	$this->timestamp,
				'log'		=>	$this->__toString(),
                'info'      =>  $this->extra
			]
		];
	}
}