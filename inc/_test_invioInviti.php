<?php

$p = PartecipazioneCorso::id(63);
$p->md5 = PartecipazioneCorso::md5($p->id);

$c = Corso::id($p->corso);
$v = $p->volontario();

$r = $p->inviaInvito(Corso::id($p->corso), $v);

?>