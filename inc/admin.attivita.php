<?php


/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

set_time_limit(0);
?>
<h3><i class="icon-wrench muted"></i> Manutenzione attività</h3>
<pre>
<code>Rimozione attività con dati incompleti:
    <?php
    $attivita = Attivita::elenco();
    $eseguiti=0;
    $nAutorizzazioni = 0;
    $nPartecipazioni = 0;
    $nTurni = 0;
    $nAttivita = 0;
    echo "Start manutenzione attività:<br/>";
    foreach( $attivita as $a ){
        echo("Controllo attività {$a->id} <br />");
        $comitato = $a->comitato();
        if( $comitato ){
            if(!$a->referente()) {
                echo "Attività rotta: ", $a->nome;
                $comitato = $a->comitato();
                echo " - ", $comitato->nomeCompleto(), " ID:",$comitato->oid();
                $presidente = $comitato->primoPresidente();
                echo  " - Presidente: ", $presidente->nomeCompleto();            
                $a->referente = $presidente;
                $turni = Turno::filtra([['attivita', $a]]);
                foreach( $turni as $_t ){
                    $part = Partecipazione::filtra([['turno', $_t]]);
                    foreach( $part as $_p ){
                        $aut = Autorizzazione::filtra([['partecipazione', $_p]]);
                        foreach( $aut as $_a ){
                            $_a->volontario = $presidente;
                            echo("<br />Correggo autorizzazione! <br>");
                        }
                    }
                }
                echo  " - Operazione completata! <br/><br />";
                $eseguiti++;
                continue;
            }
            continue;
        } else{
            echo "Inizio rimozione attività con dati incompleti: ID: ", $a->id, $a->nome;
            $turni = Turno::filtra([['attivita', $a]]);
            foreach( $turni as $turno ){
                $partecipazioni = Partecipazione::filtra([['turno', $turno]]);
                foreach( $partecipazioni as $partecipazione ){
                    $autorizzazioni = Autorizzazione::filtra([['partecipazione', $partecipazione]]);
                    foreach( $autorizzazioni as $autorizzazione ){
                        $autorizzazione->cancella();
                        $nAutorizzazioni++;
                    }
                    $partecipazione->cancella();
                    $nPartecipazioni++;
                }
                $turno->cancella();     
                $nTurni++;
            }
            $a->cancella();
            $nAttivita++;
        }
        echo " - Attività rimossa - Operazione completata!<br/>";
    }
    ?>
    Ho rimosso <strong><?= $nAutorizzazioni; ?></strong> turni, <strong><?= $nPartecipazioni; ?></strong> partecipazioni, <strong><?= $nTurni; ?></strong> turni, <strong><?= $nAttivita; ?></strong> attivita.
    Eseguite <strong><?= $eseguiti; ?></strong> riparazioni.</code>
    </pre>