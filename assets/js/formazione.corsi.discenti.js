$(document).ready(function () {

    $('##nuova-persona').on('submit', function () {

        api('aggiungi:civile', {
                "nome": $('#inputNome').val(),
                "cognome": $('#inputCognome').val(),
                "sesso": $('#inputSesso').val(),
                "dnascita": $('#inputDataNascita').val(),
                "prnascita": $('#inputProvinciaNascita').val(),
                "conascita": $('#inputComuneNascita').val(),
                "coresidenza": $('#inputComuneResidenza').val(),
                "caresidenza": $('#inputCAPResidenza').val(),
                "prresidenza": $('#inputProvinciaResidenza').val(),
                "indirizzo": $('#inputIndirizzo').val(),
                "civico": $('#inputCivico').val()
            }, 
            function (x) {
                console.log(x);
            }
        );
        // recuperare i discenti già selezionati 
        // salvarli in un cookie?! per recuperarli al caricamento successivo dopo l'inserimento di una nuova persona

        return false;
    });

});
