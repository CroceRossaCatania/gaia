# Il progetto Gaia

Leggi le **[Informazioni sul progetto Gaia](http://www.gaiacri.it/?p=public.about)**

### Link utili

* [Cose da fare/Roadmap](https://github.com/CroceRossaCatania/gaia/wiki/Roadmap)
* [Segnala bug o proponi una feature](https://github.com/CroceRossaCatania/gaia/issues)
* [Elenco bug aperti](https://github.com/CroceRossaCatania/gaia/issues?labels=bug&page=1&state=open)
* [Suggerimenti degli utenti aperti](https://github.com/CroceRossaCatania/gaia/issues?labels=Suggerimenti+degli+utenti&page=1&state=open)

## Collaborare

Ogni tipo di collaborazione è benvenuta. **Accettiamo volentieri le Pull Request.**

Contattaci a <informatica@cricatania.it> per saperne di più.


# Progetti affini

* **gaia-android (aka Gaia Mobile)** - [scopri e partecipa...](https://github.com/AlfioEmanueleFresta/gaia-android)
* **gaia-api-php**, librerie PHP per integrare le applicazioni con Gaia - [scopri e partecipa...](https://github.com/AlfioEmanueleFresta/gaia-api-php)

# Il software di Gaia

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
3. Permettere la scrittura alla directory `/upload` ed alle sue sottodirectory.
4. Da browser, puntare alla pagina: `setup.php`.
5. Registrare il primo volontario, che sarà automaticamente un amministratore.
6. (Opzionale) Impostare cron per richiedere ogni nottevia HTTP il file `cronjob.php`

