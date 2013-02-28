<?php

/*
 * ©2012 Croce Rossa Italiana
 */


/*genera il riepilogo */
    $cn = mysql_connect("localhost", "root", "sanbitter");
    mysql_select_db("diefenbaker", $cn);
    $query1 = mysql_query("SELECT * FROM titoliPersonali WHERE pConferma IS NULL", $cn);
    $query2 = mysql_query("SELECT * FROM appartenenza WHERE conferma = 0", $cn);
    $quantit = mysql_num_rows($query1);
    $quantiv = mysql_num_rows($query2);
    if ($quantit == 0)
    {
        $pending = "Nessun Titolo da Confermare";
        echo $pending;
    }
    else
    {
        $pending=$quantit;
        echo "Titoli in sospeso:",$pending,"<br/>";
    }
    if ($quantiv == 0)
    {
        $pending2 = "Nessun Volontario da Confermare";
        echo $pending2;
    }
    else
    {
        $pending2=$quantiv;
        echo "Volontari in sospeso:",$pending2,"<br/>";
    }
    
$a="ico88@hotmail.com";
$oggetto="Aggiornamento Iscrizioni e Titoli su Gaia.cricatania.it";
$messaggio="";
$intestazioni= "From:informatica@cricatania.it";
$intestazioni .= "Reply-To:informatica@cricatania.it";
$intestazioni .= "X-Mailer: PHP/".phpversion();
mail($a, $oggetto, $messaggio, $intestazioni);
mysql_close($cn);

?>