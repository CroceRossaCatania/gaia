# Il progetto Gaia

### La storia

Gaia nasce nell'estate del 2012 con l'idea di una profonda rivoluzione in Croce Rossa, che mostri il 
dinamismo, la forza e la giovinezza dell'associazione.

Crediamo in una Croce Rossa Italiana che sa muoversi velocemente, più trasparente ed aperta a tutti.

### L'obiettivo

Vogliamo ottenere un sistema informativo efficiente e di facile consultazione. 

### Punti chiave del progetto
 
* **Efficienza**: Bisogna cavare il potenziale inespresso di Croce Rossa.
* **Semplicità**: Il sistema deve essere semplice per chiunque.
* **Trasparenza**: Croce Rossa è aperta e trasparente a tutti.


### Il nome

> G.A.I.A. è l'acronimo di "Gestione Avanzata ed Integrata dell'Anagrafica".
> 
> Gaia è anche il nome di un pianeta immaginario, frutto della fantasia di Isaac Asimov, in cui grazie alla perfetta integrazione di ognuna della sue parti l'intero sistema si mantiene in un perfetto equilibrio con un costante flusso di comunicazione ed una stretta interdipendenza.

cit. Alfio Musmarra

### Le persone

Gaia è sviluppato all'interno dei Servizi Informatici del Comitato Provinciale di Catania. Puoi contattarci all'indirizzo email <informatica@cricatania.it>.




## Il software

### Requisiti

Gaia dovrebbe funzionare su tutti i moderni sistemi Linux che abbiano almeno:

* PHP 5.4+
* MySQL 5+

Per un migliore funzionamento, sono opzionali:

* Imagick (con `imagick-dev` e `php5-imagick`)
* `cron` (Il software di cronjob unix)

### Installazione

Per motivi di sviluppo, è possibile installare Gaia come segue:

1. Copiare il file `/core/conf/database.conf.php.sample` in `/core/conf/database.conf.php`
2. Modificare, in quest'ultimo, i parametri di accesso a MySQL.
3. Modificare `/upload/setup/comitati.txt` con i Comitati da precaricare.
3. Permettere la scrittura alla directory `/upload` ed alle sue sottodirectory.
4. Da browser, puntare alla pagina: `setup.php`.
5. Registrare il primo volontario, che sarà automaticamente un amministratore.
6. (Opzionale) Impostare cron per richiedere ogni nottevia HTTP il file `cronjob.php`
7. (Sviluppo) Creare il file vuoto `/upload/setup/autopull` per permettere l'autopull via GitHub.

### Collaborare

Ogni tipo di collaborazione è benvenuta. **Accettiamo volentieri le Pull Request.**

Contattaci a <informatica@cricatania.it> per saperne di più.
