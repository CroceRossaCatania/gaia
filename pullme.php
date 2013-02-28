<?php
 
header('Content-Type: text/plain');
 
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Richiesta non valida');
}

echo "Risultato:\n\n";

system("git pull");
