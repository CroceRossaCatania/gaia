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
sh scripts/scorciatoie.sh.sh
sh scripts/configurazione-base.sh
```

(Necessario GIT installato sul sistema)

### Eseguire Gaia

È possibile avviare Gaia nel server di sviluppo di PHP 5.5+ come segue:
```bash
gaia
```
Basterà dirigersi su (http://localhost:8888/) per accedere alla propria installazione.
