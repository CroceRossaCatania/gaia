/*
 * ©2012 Croce Rossa Italiana
 */

/* Cagami non appena il motore javascript è pronto... */
$(document).ready( function () {
/* Ad ogni rilascio tasti dell'input... */
$("#cercaUtente").keyup ( function () { // Il selettore per id si può abbreviare col cancelletto
/* Le variabili in javascript si dichiarano con var (senza tipo),
* e *non* hanno il $ come in php. Il $ è la funzione "Selettore" di jQuery,
* e vuole come unico argomento una stringa o un oggetto.
* es: $("#cercaUtente") seleziona
* tutti gli oggetti/tag HTML (chiamati DOM) che hanno ID cercaUtente.
* Altri modi per cercare sono per classe (col . anziché col #) o per [attributo]
* $("[required]"), $("[type='email']"), ecc.
*/
var testo = $("#cercaUtente").val(); 
var testo2="#";
/* Carico il valore della ricerca in testo */
/* Se il campo è vuoto, mostro tutto ed esco! */
if ( testo.length == '' ) {
$("#tabellaUtenti tr").show();
return;
}
/* Cerco tutte le righe (tr) dentro la tabella *ALLA QUALE DARE ID: tabellaUtenti
* per ognuna, tramite "each", eseguo una funzione che ha come parametro ogni volta:
* i: indice (es.: 0, 1, 2, 3,)
* e: vero e proprio oggetto della riga che posso usare per manipolarlo
*/
$("#tabellaUtenti tr").each( function ( i, e ) {
/* Se c'è qualche campo che contiene quello che cerco... */
if ( $(e).find('td:contains("' + testo + '")').length > 0) {
$(e).show('highlight', 300); /* Mostra la riga e la fa lampiare */
} else if ($(e).find('th:contains("' + testo2 + '")').length>0)  {
$(e).show('highlight', 300);
}else{
$(e).hide(); /* Nasconde la riga immediatamente */
}
});
});
});

