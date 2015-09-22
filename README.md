# Il progetto Gaia

Leggi le **[Informazioni sul progetto Gaia](https://gaia.cri.it/?p=public.about)**

### Link utili

* [Cose da fare/Roadmap](https://github.com/CroceRossaCatania/gaia/issues?direction=desc&labels=roadmap&page=1&sort=updated&state=open)
* [Segnala bug o proponi una feature](https://github.com/CroceRossaCatania/gaia/issues)
* [Elenco bug aperti](https://github.com/CroceRossaCatania/gaia/issues?labels=bug&page=1&state=open)
* [Suggerimenti degli utenti aperti](https://github.com/CroceRossaCatania/gaia/issues?labels=proposta&page=1&state=open)

## Collaborare

**Leggi: [Come partecipare al progetto](http://goo.gl/Jjiqo)**

Alternativamente, contattaci a <info@gaia.cri.it> per saperne di più.


# Progetti affini

* **gaia-android (aka Gaia Mobile)** - [scopri e partecipa...](https://github.com/AlfioEmanueleFresta/gaia-android)
* **gaia-api-php**, librerie PHP per integrare le applicazioni con Gaia - [scopri e partecipa...](https://github.com/AlfioEmanueleFresta/gaia-api-php)

# Il software di Gaia

**Leggi: [Documento tecnico di Gaia](http://goo.gl/Dg3JV) per requisiti ed informazioni sulle tecnologie.**

### Installazione

**Nota bene**: Attualmente, per motivi di tempo, **non** offriamo supporto per l'installazione del software sul proprio server.
Ogni richiesta al supporto a riguardo verra' ignorata. Se sei interessato a collaborare al Progetto Gaia, contattaci a info@gaia.cri.it.

#### La via facile (Ubuntu 13.04+)

**Script di installazione**, basta aprire un terminale (col proprio utente) ed incollare:

```bash
cd ~
git clone https://github.com/CroceRossaCatania/gaia.git
cd gaia
sh scripts/installa-dipendenze.sh
sh scripts/scorciatoie.sh
sh scripts/configurazione-base.sh
```

(Necessario GIT installato sul sistema)

### Eseguire Gaia

È possibile avviare Gaia nel server di sviluppo di PHP 5.5+ come segue:
```bash
gaia
```
Basterà dirigersi su (http://localhost:8888/) per accedere alla propria installazione.

#### Crontab

Per il corretto funzionamento dell'applicazione e del sistema di posta, modificare il proprio crontab (es.: con `crontab -e`), come segue:
```bash
# Cronjob notturno (manutenzione e azioni automatiche)
0 1 * * * cd ~/gaia && php cronjob.php > /dev/null

# Ogni 1-5 minuti (smaltimento coda di invio)
* * * * * cd ~/gaia && php mailer.php | tee -a upload/log/mailer.log
```


Verbale (con numero di corso) da stampare
Modifica docente se corso già approvato rompe tutto
Codice numerico progressivo di un corso per anno e per tipo di corso
Cosa succede se la data inserita è entro 15 gg
I regionali possono modificare i corsi? NO, vengono notificati via email alla creazione
I regionali nel TS/SA deve validare gli istruttori per singola lezione: uno psicologo può insegnare in una lezione "sostegno psicologico al paziente" ma non in altre lezioni
Quando si parte? 30 novembre
Sostituire "insegnanti" con "docenti"
Attestati PDF
Inserire in fondo al PDF "firmato in originale"
A chiusura corso, lanciare procedura di generazione dei pdf
Elenco certificati relativi ad un corso, disponibili al direttore per la stampa
Ufficio Soci deve poter accettare la partecipazione di un discente in sua vece, perchè questo potrebbe non avere email o accesso a internet
Delegato tecnico area 1 non esiste: deve poter agire su tutti i corsi, i docenti e i discenti 