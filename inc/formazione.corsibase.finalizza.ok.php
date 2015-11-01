<?php

/*
* ©2014 Croce Rossa Italiana
*/

paginaPrivata();
controllaParametri(array('id'));

$corso = CorsoBase::id($_POST['id']);
paginaCorsoBase($corso);

if($corso->stato == CORSO_S_CONCLUSO) {
    redirect("formazione.corsibase.scheda&id={$corso->id}&err");
}

$partecipazioni = $corso->partecipazioni(ISCR_CONFERMATA);

$tuttiEsaminati = true;

foreach($partecipazioni as $part) {
    if(isset($_POST["ammissione_{$part->id}"])) {
        $ammissione = $_POST["ammissione_{$part->id}"];
        if($ammissione == 1) {
            //valutare situazione promozione o bocciature

            if($_POST["p1_{$part->id}"] && $_POST["p2_{$part->id}"]){
                //parte 1 e parte 2 superata

                $part->stato = ISCR_SUPERATO;
                $part->tAttestato = time();
                $part->cAttestato = $me;
                $part->p1 = $_POST["p1_{$part->id}"];
                $part->p2 = $_POST["p2_{$part->id}"];
                $part->a1 = $_POST["arg_p1_{$part->id}"];
                $part->a2 = $_POST["arg_p2_{$part->id}"];
                if(isset($_POST["extra_1_{$part->id}"])) {
                    $part->e1 = $_POST["extra_1_{$part->id}"];
                }
                $part->utente()->trasformaInVolontario($me);

                // mandare email superamento
                if($part->utente()->email()) {
                    $m = new Email('superatoCorsoBase', 'Corso base superato!');
                    $m->a           = $part->utente();
                    $m->da          = $me;
                    $m->_NOME       = $part->utente()->nome;
                    $m->_CORSO      = $corso->nome();
                    $m->accoda();
                }
            } elseif($_POST["p1_{$part->id}"] && $_POST["extra_2_{$part->id}"]) {
                //parte 1 superata e parte 2 da non fare

                $part->stato = ISCR_SUPERATO;
                $part->tAttestato = time();
                $part->cAttestato = $me;
                $part->p1 = $_POST["p1_{$part->id}"];
                $part->a1 = $_POST["arg_p1_{$part->id}"];
                $part->e2 = $_POST["extra_2_{$part->id}"];
                $part->utente()->trasformaInVolontario($me);

                // mandare email superamento
                if($part->utente()->email()) {
                    $m = new Email('superatoCorsoBase', 'Corso base superato!');
                    $m->a           = $part->utente();
                    $m->da          = $me;
                    $m->_NOME       = $part->utente()->nome;
                    $m->_CORSO      = $corso->nome();
                    $m->accoda();
                }
            } else {
                //esame non passato

                $part->stato = ISCR_BOCCIATO;
                $part->tAttestato = time();
                $part->cAttestato = $me;
                $part->utente()->stato = PERSONA;

                // mandare email non superamento
                if($part->utente()->email()) {
                    $m = new Email('nonSuperatoCorsoBase', 'Corso base non superato');
                    $m->a           = $part->utente();
                    $m->da          = $me;
                    $m->_NOME       = $part->utente()->nome;
                    $m->_CORSO      = $corso->nome();
                    $m->accoda();
                }
            }
        } elseif($ammissione == 2) {
            // non ammesso

            $m = $_POST["inputMotivo_{$part->id}"];
            $motivo = "non ammesso per: {$m}";
            $part->stato = ISCR_BOCCIATO;
            $part->tAttestato = time();
            $part->cAttestato = $me;
            $part->motivo = $motivo;
            $part->utente()->stato = PERSONA;

            // mandare email non ammissione
            if($part->utente()->email()) {
                $m = new Email('nonAmmessoCorsoBase', 'Corso base non superato');
                $m->a           = $part->utente();
                $m->da          = $me;
                $m->_NOME       = $part->utente()->nome;
                $m->_CORSO      = $corso->nome();
                $m->_MOTIVO     = $motivo;
                $m->accoda();
            }

        } elseif($ammissione == 3) {
            // assente

            // recupero chiudo 
            $motivo = "non presente all'esame";
            $part->stato = ISCR_BOCCIATO;
            $part->tAttestato = time();
            $part->cAttestato = $me;
            $part->motivo = $motivo;
            $part->utente()->stato = PERSONA;

            // mandare email assenza
            if($part->utente()->email()) {
                $m = new Email('assenteCorsoBase', 'Corso base non superato');
                $m->a           = $part->utente();
                $m->da          = $me;
                $m->_NOME       = $part->utente()->nome;
                $m->_CORSO      = $corso->nome();
                $m->accoda();
            }

        }
    } else {
        $tuttiEsaminati = false;
    }
}

if($tuttiEsaminati){
    // modifica stato esame
    $corso->stato = CORSO_S_CONCLUSO;
    redirect("formazione.corsibase.scheda&id={$corso->id}&verbok");
}

//redirect con errore
redirect("formazione.corsibase.scheda&id={$corso->id}&verberr");
