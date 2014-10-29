<?php

paginaPrivata();

if ( $me->stato != ASPIRANTE )
    redirect('utente.me');

// Se non ho ancora registrato il mio essere aspirante
if ( !($a = Aspirante::daVolontario($me)) )
    redirect('aspirante.registra');

?>
<div class="row-fluid">
    <div class="span3">
        <?php menuAspirante(); ?>
    </div>
    <div class="span9">

        <h2><i class="icon-remove-sign"></i> Vuoi realmente cancellarti da Gaia?</h2>
        <p>Cancellandoti da Gaia:
        <ul>
            <li>Non potrai più riottenere l’accesso al tuo account;</li>
            <li>La maggior parte delle informazioni personali a esso associate verranno rimosse dal
             sistema. Tali informazioni includono, ad esempio, i tuoi dati anagrafici, 
             il tuo indirizzo e-mail, l’indirizzo postale e il tuo numero di telefono. </li>
            <li>Alcune delle informazioni personali potrebbero essere conservate, 
             come ad esempio il tuo nome nel caso in cui tu abbia inviato un messaggio a un altro utente;</li>
            <li>Ti verrà mandata un'email di conferma dell'avvio della procedura di cancellazione del
             tuo account.</li>
        </p>
        <form action="?p=aspirante.cancellati.ok" method="POST">

            <div>
            <label for="checkbox" class="checkbox">
                <input type="checkbox" name="conferma" value="true" id="checkbox" class="checkbox" required />
                <strong>Confermo di aver letto e compreso</strong>
            </label>
            </div>
            <br />
            <button type="submit" name="azione" value="salva" class="btn btn-danger">
                <i class="icon-remove-sign"></i> Cancellami da Gaia
            </button>
        </form>          
    </div>
</div>
