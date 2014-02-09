<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class ePDO extends PDO {
    
    public $numQuery = 0;
    
    /*public function __construct($dsn, $username, $passwd, $options) {
        parent::__construct($dsn, $username, $passwd, $options);
        file_put_contents('/tmp/t1', "\n\n");
    }*/
    
    public function prepare ( $q, $opzioni = [] ) {
        $this->numQuery++;
        //file_put_contents('/tmp/t1', $q, FILE_APPEND);
        return parent::prepare( $q, $opzioni );
    }

    public function __destruct() {
        global $cache, $conf;
        if ( $cache ) {
            $q = (int) $cache->get( $conf['db_hash'] . '__nq' );
            $q += $this->numQuery;
            $cache->set( $conf['db_hash'] . '__nq', $q );
        }
    }
}