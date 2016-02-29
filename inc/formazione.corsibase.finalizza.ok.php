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

$part = $corso->partecipazioni(ISCR_CONFERMATA);

$tuttiEsaminati = true;

foreach($part as $p) {
    if(isset($_POST["ammissione_{$p->id}"])) {
        $ammissione = $_POST["ammissione_{$p->id}"];
        if($ammissione == 1) {
            //valutare situazione promozione o bocciature

            if($_POST["p1_{$p->id}"] && $_POST["p2_{$p->id}"]){
                //parte 1 e parte 2 superata

                $p->stato = ISCR_SUPERATO;
                $p->tAttestato = time();
                $p->cAttestato = $me;
                $p->p1 = $_POST["p1_{$p->id}"];
                $p->p2 = $_POST["p2_{$p->id}"];
                $p->a1 = $_POST["arg_p1_{$p->id}"];
                $p->a2 = $_POST["arg_p2_{$p->id}"];
                if(isset($_POST["extra_1_{$p->id}"])) {
                    $p->e1 = $_POST["extra_1_{$p->id}"];
                }
                $p->utente()->trasformaInVolontario($me, $corso->tEsame);

                // mandare email superamento
                if($p->utente()->email()) {
                    $m = new Email('superatoCorsoBase', 'Corso base superato!');
                    $m->a           = $p->utente();
                    $m->da          = $me;
                    $m->_NOME       = $p->utente()->nome;
                    $m->_CORSO      = $corso->nome();
                    $m->accoda();
                }
            } elseif($_POST["p1_{$p->id}"] && $_POST["extra_2_{$p->id}"]) {
                //parte 1 superata e parte 2 da non fare

                $p->stato = ISCR_SUPERATO;
                $p->tAttestato = time();
                $p->cAttestato = $me;
                $p->p1 = $_POST["p1_{$p->id}"];
                $p->a1 = $_POST["arg_p1_{$p->id}"];
                $p->e2 = $_POST["extra_2_{$p->id}"];
                $p->utente()->trasformaInVolontario($me, $corso->tEsame);

                // mandare email superamento
                if($p->utente()->email()) {
                    $m = new Email('superatoCorsoBase', 'Corso base superato!');
                    $m->a           = $p->utente();
                    $m->da          = $me;
                    $m->_NOME       = $p->utente()->nome;
                    $m->_CORSO      = $corso->nome();
                    $m->accoda();
                }
            } else {
                //esame non passato

                $p->stato = ISCR_BOCCIATO;
                $p->tAttestato = time();
                $p->cAttestato = $me;
                $p->utente()->stato = PERSONA;

                // mandare email non superamento
                if($p->utente()->email()) {
                    $m = new Email('nonSuperatoCorsoBase', 'Corso base non superato');
                    $m->a           = $p->utente();
                    $m->da          = $me;
                    $m->_NOME       = $p->utente()->nome;
                    $m->_CORSO      = $corso->nome();
                    $m->accoda();
                }
            }
        } elseif($ammissione == 2) {
            // non ammesso

            $m = $_POST["inputMotivo_{$p->id}"];
            $motivo = "non ammesso per: {$m}";
            $p->stato = ISCR_BOCCIATO;
            $p->tAttestato = time();
            $p->cAttestato = $me;
            $p->motivo = $motivo;
            $p->utente()->stato = PERSONA;

            // mandare email non ammissione
            if($p->utente()->email()) {
                $m = new Email('nonAmmessoCorsoBase', 'Corso base non superato');
                $m->a           = $p->utente();
                $m->da          = $me;
                $m->_NOME       = $p->utente()->nome;
                $m->_CORSO      = $corso->nome();
                $m->_MOTIVO     = $motivo;
                $m->accoda();
            }

        } elseif($ammissione == 3) {
            // assente

            // recupero chiudo 
            $motivo = "non presente all'esame";
            $p->stato = ISCR_BOCCIATO;
            $p->tAttestato = time();
            $p->cAttestato = $me;
            $p->motivo = $motivo;
            $p->utente()->stato = PERSONA;

            // mandare email assenza
            if($p->utente()->email()) {
                $m = new Email('assenteCorsoBase', 'Corso base non superato');
                $m->a           = $p->utente();
                $m->da          = $me;
                $m->_NOME       = $p->utente()->nome;
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
