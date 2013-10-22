<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

$t = $_GET['id'];

        $t = Reperibilita::id($t);
        $t->fine    = time();
        redirect('utente.reperibilita&del');
