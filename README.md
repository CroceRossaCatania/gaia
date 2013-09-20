# Il progetto Gaia

Leggi le **[Informazioni sul progetto Gaia](http://www.gaiacri.it/?p=public.about)**

### Link utili

* [Cose da fare/Roadmap](https://github.com/CroceRossaCatania/gaia/issues?direction=desc&labels=roadmap&page=1&sort=updated&state=open)
* [Segnala bug o proponi una feature](https://github.com/CroceRossaCatania/gaia/issues)
* [Elenco bug aperti](https://github.com/CroceRossaCatania/gaia/issues?labels=bug&page=1&state=open)
* [Suggerimenti degli utenti aperti](https://github.com/CroceRossaCatania/gaia/issues?labels=proposta&page=1&state=open)

## Collaborare

**Leggi: [Come partecipare al progetto](http://goo.gl/Jjiqo)**

Alternativamente, contattaci a <info@gaiacri.it> per saperne di più.


# Progetti affini

* **gaia-android (aka Gaia Mobile)** - [scopri e partecipa...](https://github.com/AlfioEmanueleFresta/gaia-android)
* **gaia-api-php**, librerie PHP per integrare le applicazioni con Gaia - [scopri e partecipa...](https://github.com/AlfioEmanueleFresta/gaia-api-php)

# Il software di Gaia

**Leggi: [Documento tecnico di Gaia](http://goo.gl/Dg3JV) per requisiti ed informazioni sulle tecnologie.**

### Installazione

Per motivi di sviluppo, è possibile installare Gaia seguendo una delle due vie...

#### La via facile (Ubuntu 13.04+)

**Script di installazione**, basta aprire un terminale (col proprio utente) ed incollare:

```bash
wget https://gist.github.com/AlfioEmanueleFresta/6264461/raw/59887421d49daa3c18f2fe399584bf02a351c844/gaia.sh
sh gaia.sh
```

##### La via facile (Mint Linux Olivia+)

1. Impostazioni > Sorgenti Software (Software Sources) > PPA > Aggiungi `ppa:ondrej/php5`
2. Usare lo script di installazione per Ubuntu qua sopra.

#### La via difficile

1. Importare il file `/core/conf/gaia.sql` nel proprio database tramite phpMyAdmin
2. Copiare il file `/core/conf/database.conf.php.sample` in `/core/conf/database.conf.php`
3. Copiare il file `/core/conf/smtp.conf.php.sample` in `/core/conf/smtp.conf.php`
4. Copiare il file `/core/conf/autopull.conf.php.sample` in `/core/conf/autopull.conf.php`
4. Modificare, nei primi due file, i parametri di accesso a MySQL ed al server SMTP.
5. Permettere la scrittura alla directory `/upload` ed alle sue sottodirectory.
6. Permettere la scrittura alla directory `/core/inc/dompdf` ed alle sue sottodirectory.
7. Da browser, puntare alla pagina: `setup.php`.
8. Registrare il primo volontario, che sarà automaticamente un amministratore.
9. (Opzionale) Impostare cron per richiedere ogni nottevia HTTP il file `cronjob.php`

### Eseguire Gaia

È possibile avviare Gaia nel server di sviluppo di PHP 5.5+ come segue:
```bash
cd /percorso/per/gaia
php -S localhost:8888 router.php
```
Basterà dirigersi su **http://localhost:8888/** per accedere alla propria installazione.
