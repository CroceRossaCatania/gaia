<?php

paginaAdmin();

/* Entra nella magica admin mode... */
$sessione->adminMode = time();

redirect();