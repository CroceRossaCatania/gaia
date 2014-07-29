<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

?>
<h3><i class="icon-users muted"></i> Fix estensione gruppi</h3>

<pre>
	<code>
		<?php
			$inizio = time();
			$i=0;
			$gruppi = Gruppo::elenco();

			echo('<br><strong>Avviata procedura di fix estensione gruppi</strong><br><br>');

			foreach ( $gruppi as $gruppo ){

				if ( $gruppo->estensione != null ){ continue; }

				$est = $gruppo->attivita()->comitato()->_estensione();

				echo('Gruppo ID:['.$gruppo->id.'] -> fix ');

				if ( $est == EST_REGIONALE ) {
				    $gruppo->estensione  =   EST_GRP_REGIONALE;    
				} elseif ( $est == EST_PROVINCIALE ) {
				    $gruppo->estensione  =   EST_GRP_PROVINCIALE;
				} elseif ( $est == EST_LOCALE ) {
				    $gruppo->estensione  =   EST_GRP_LOCALE;
				} else {
					$gruppo->estensione  =   EST_GRP_UNITA;
				}
				echo(' Nuova estensione gruppo:' .$conf['est_grp'][$gruppo->estensione].'</br>');
				$i++;
			}

			$fine = time();
			$time = $fine-$inizio;
			echo('Eseguiti:' .$i.'fix, ho impiegato:'.$time.'secondi');
		?>
	</code>
</pre>