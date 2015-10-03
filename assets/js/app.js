/*
 * ©2012 Croce Rossa Italiana
 * Tutti i diritti sono riservati
 */

var
    uid = null,
    sid = null,
    uob = null;
    
var conf = {
    api:    'api.php',
    key:    'bb2c08ff4da11f0b590a7ae884412e2bfd8ac28a'
};

$(window).ready( function () { 
    
    /* Impostazioni di jQuery UI */
    $.datepicker.setDefaults( $.datepicker.regional[ "it" ] );
    
    /* Impostazioni iniziali AJAX */
    $.ajaxSetup({
       type:        "POST",
       dataType:    "json",
       error:       _rete_errore,
       contentType: "application/json; charset=UTF-8",
       success:     _rete_ok
    });
      
    /* Carica eventuali impostazioni */
    sid = $.cookie('sessione');
    _sincronizza();
    api('ciao', {}, _aggiorna_chiSono());
    
    /* Bind */
    $("#_logout").click( _logout );
    $("#_login").click( _login );
    
    $("[data-attendere]")               .each( _attendere );
    $("[data-attendere-caricamento]")   .each( _attendere_caricamento );
    $("[data-suggerimento]")            .each( _suggerimento );
    $("[data-volontari]")               .each( _tabella );
    $("[data-posta]")                   .each( _posta );
    $("[data-conferma]")                .each( _conferma );

    _render_utenti();
    _render_modali();
    _render_like();

    disabilita_campi_captcha();

    $('.automodal').modal({ keyboard: false, backdrop: 'static' });
    $('.alCambioSalva').change( function () {
        $(this).parents('form').submit();
    })
    
    $("#navigatoreMobileSelect").change( _navigatore_mobile );

    normativa_cookie();

    tinyMCE.baseURL = "/assets/js/tinymce/";
    tinymce.init({
        selector:   "textarea.conEditor",
        language:   'it',
        plugins: [
            "lists link image",
            "visualblocks fullscreen",
            "media paste"
        ],
        toolbar: "bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
        menubar: false,
        statusbar: false,
        relative_urls: false
    });


} );

$(document).ready( function() { 
 
  /* Affare che fa scomparire la roba */
  
   $("[data-nascondi]").each( function(i, e) {
    var testo = $(e).html();
    $(e).html("<i class='" + $(e).data('icona') + "'></i> " + $(e).data('nascondi'))
      .addClass('btn')
      .addClass('btn-info');
    $(e).click( function() {
      $(e).html(testo)
        .removeClass('btn')
        .removeClass('btn-info');
    });
  });
 
});

function normativa_cookie() {
    if ( $.cookie('normativaEU') === null ) {
        $("#normativaEU").show('fade', 500);
    }
    $("#nascondiNormativaEU").click(function() {
        $.cookie('normativaEU', 'OK', { expires: 365 });
        return true;
    })
}

function disabilita_campi_captcha() {
    $("[data-aspetta-captcha]").each(function(i,e){
        if ( DEBUG ) {
            return;
        }
        $(e).addClass('disabled');
        $(e).attr('disabled', 'disabled');
    });
}

/**
 * Questa funzione viene chiamata non appena il captcha
 * viene completato. tutti gli oggetti con data-aspetta-captcha
 * vengono abilitati 
 */
function cc() {
    $("[data-aspetta-captcha]").each(function(i,e){
        $(e).removeClass('disabled');
        $(e).removeAttr('disabled');
    });
}

/* Test di funzionamento in HTML5 e caricamento dei polyfill */
Modernizr.load([
  {
    /* Campi richiesti  */
    test: Modernizr.input.required,
    nope: ['js/polyfill/required.js']
        
  },
  {
    /* Placeholder! */
    test: Modernizr.input.placeholder,
    nope: ['js/polyfill/placeholder.css', 'js/polyfill/placeholder.js']
  },
]);

function _rete_errore(a, b, c) {
    // alert('C\'è stato un errore nel processare la richiesta.');
}

function _rete_ok(a, b, c) {
    sid = a.sessione.id;
    uob = a.sessione.utente;
    if ( uob ) {
        uid = uob.id;
    }
    _sincronizza();
}

function _sincronizza() {
    $.cookie('sessione', sid);
    _aggiorna_chiSono();
}

function _conferma(i, e) {
    $(e).click( function() {
        return confirm($(e).data('conferma'));
    });
}

function _aggiorna_chiSono() {
}
 
var _cache = {}; 
function api(metodo, dati, callback, cache) {
    if ( cache === undefined ) {
        // Standard, non cache
        $.post(
            conf.api,
            JSON.stringify($.extend(
                dati,
                { 
                    metodo: metodo,
                    sid:    sid,
                    key:    conf.key
                })),
            [_rete_ok, callback]
        );
    } else {

        // Cache!
        var chiave = metodo + ':' + JSON.stringify(dati);
        if (_cache.hasOwnProperty(chiave)) {
            callback(_cache[chiave]);
        } else {
            api(metodo, dati, function(x) {
                _cache[chiave] = x;
                if ( callback !== undefined )
                    callback(x);
            });
        }

    }
}

function _dump( x ) {
}

function _logout () {
    api('logout');
}

function _login () {
   
}

function _abilita_filtraggio (idInput, idTabella) {
    $(idInput).keyup ( function () {
        var testo = $(idInput).val().toLowerCase(); 
        if ( testo.length < 2 ) { /* 2, minimo numero di caratteri */
            $(idTabella + " tr").show();
            return;
        }

        $(idTabella + " tr").each( function ( i, e ) {
            var x = false;
            $(e).children("td").each( function (a, b) {
                var attuale = $(b).text().toLowerCase();
                if ( attuale.indexOf(testo) !== -1 )  {
                    x = true;
                    return;
                }
            });
            if ( x ) {
                $(e).show(); 
            } else {
                $(e).hide(); 
            }
        });
        $(idTabella + " thead tr").show();
        
    });
}

function caricaMapsApi( callback ) {
  var script = document.createElement("script");
  script.type = "text/javascript";
  script.src = "https://maps.google.com/maps/api/js?sensor=false&callback=" + callback;
  document.body.appendChild(script);
}

function _attendere(i, e) {
    $(e).click ( function() {
        var vecchioTesto = $(e).html();
        var testo = $(e).data('attendere');
        $(e).addClass('disabled').attr('disabled', 'disabled');
        $(e).html('<i class="icon-spin icon-spinner"></i> ' + testo);
        setTimeout( function() {
            $(e).html(vecchioTesto);
            $(e).removeClass('disabled').removeAttr('disabled');
        }, 6500);
        if ( $(e).attr('type') == 'submit' ) {
            $(e).parents('form').submit();
            return true;
        }
    });
}

function _attendere_caricamento(i, e) {
    $(e).click ( function() {
        var testo = $(e).data('attendere-caricamento');
        $(e).addClass('disabled').attr('disabled', 'disabled');
        $(e).html('<i class="icon-spin icon-spinner"></i> ' + testo);
        if ( $(e).attr('type') == 'submit' ) {
            $(e).parents('form').submit();
            return true;
        }
    });
}

function _suggerimento(i, e) {
    $(e).attr('title', $(e).data('suggerimento'));
    $(e).tooltip({
        html:   true
    });
}

function _navigatore_mobile() {
    location.href = '?p=' + $("#navigatoreMobileSelect").val();
}

/* TO ISO STRING */
if ( !Date.prototype.toISOString ) {
     
    ( function() {
     
        function pad(number) {
            var r = String(number);
            if ( r.length === 1 ) {
                r = '0' + r;
            }
            return r;
        }
  
        Date.prototype.toISOString = function() {
            return this.getUTCFullYear()
                + '-' + pad( this.getUTCMonth() + 1 )
                + '-' + pad( this.getUTCDate() )
                + 'T' + pad( this.getUTCHours() )
                + ':' + pad( this.getUTCMinutes() )
                + ':' + pad( this.getUTCSeconds() )
                + '.' + String( (this.getUTCMilliseconds()/1000).toFixed(3) ).slice( 2, 5 )
                + 'Z';
        };
   
    }() );
}

/*
 * Genera, per un dato elemento, una tabella di volontari
 */
function _tabella (i, e) {
    var _tid = 'tabella_' + Math.floor( Math.random() * 100 );
    $(e)
        .addClass('table')
        .addClass('table-condensed')
        .addClass('table-striped')
        .addClass('table-bordered');
    // Crea l'input
    var x = $(
        '<div id="'+ _tid + '_ricerca" class="row-fluid ricerca-tabella">' +
        '<div class="span5 allinea-centro grassetto">' +
            '<p>Pagina <span id="' + _tid + '_a">X</span> di ' +
            '<span id="' + _tid + '_b">Y</span> &mdash; ' +
            '<span id="' + _tid + '_c">Z</span> risultati trovati' +
        '</div>' + 
        '<div class="span2 btn-group allinea-centro grassetto">' +
            '<a class="btn ' + _tid + '_indietro">' +
                '<i class="icon-chevron-left"></i>' +
            '</a>' +
            '<a class="btn ' + _tid + '_avanti">' +
                '<i class="icon-chevron-right"></i>' +
            '</a>' +
        '</div>' + 
        '<div class="span5 allinea-centro input-append">' +
            '<input type="text" class="input-xlarge" placeholder="Ricerca volontari..." />' +
            '<button class="btn btn-primary">' +
                '<i class="icon-search"></i>' +
            '</button>' +
        '</div>' +
        '</div>'
    );
    $(e).before(x);
    var y = $(
        '<div id="'+ _tid + '_ricerca" class="row-fluid ricerca-tabella">' +
        '<div class="span2 offset5 btn-group allinea-centro grassetto">' +
            '<a class="btn ' + _tid + '_indietro">' +
                '<i class="icon-chevron-left"></i>' +
            '</a>' +
            '<a class="btn ' + _tid + '_avanti">' +
                '<i class="icon-chevron-right"></i>' +
            '</a>' +
        '</div>' + 
        '</div>'
    );
    $(e).after(y);
    $(e).data('tid', _tid);
    $('#' + _tid + '_ricerca').find('input').change( function(x, y) {
        _tabella_ricerca ( e, $(this).val(), $(this) );
    });
    // Avvia senza ricerca...
    _tabella_ricerca(e, null, $('#' + _tid + '_ricerca').find('input').first());
}

function _tabella_ricerca ( e, query, input, pagina ) {
    _tabella_caricamento(e);
    _tabella_blocca_input(input);
    if ( !pagina || pagina < 0 ) {
        pagina = 1;
    }
    var perPagina = $(e).data('perpagina');
    var _tid      = $(e).data('tid');
    var geoPolitica = '';
    if ( typeof $(e).data('comitati') == 'undefined') {
        geoPolitica = false;
    } else {
        geoPolitica = $(e).data('comitati');
    }

    var stato = '';
    if ( typeof $(e).data('stato') == 'undefined') {
        stato = false;
    } else {
        stato = $(e).data('stato');
    }

    var statoPersona = '';
    if ( typeof $(e).data('statopersona') == 'undefined') {
        statoPersona = false;
    } else {
        statoPersona = $(e).data('statopersona');
    }

    var passato     = $(e).data('passato');
    var giovane     = $(e).data('giovane');
    var infermiera  = $(e).data('infermiera');
    var militare    = $(e).data('militare');

    if (!perPagina) {
        perPagina = 30;
    }
    api('volontari:cerca', {
        'query':        query,
        'pagina':       pagina,
        'perPagina':    perPagina,
        'comitati':     geoPolitica,
        'stato':        stato,
        'passato':      passato,
        'giovane':      giovane,
        'statoPersona': statoPersona,
        'infermiera':   infermiera,
        'militare':     militare
    }, function (dati) {
        _tabella_ridisegna(e, dati.risposta, input);
         /* Pulsante indietro... */
        if ( pagina == 1 ) {
            $('.' + _tid + '_indietro')
                .unbind('click')
                .addClass('disabled');
        } else {
            $('.' + _tid + '_indietro')
                .unbind('click')
                .removeClass('disabled')
                .click ( function () {
                    _tabella_ricerca(e, query, input, pagina - 1);
                });
        }   
        /* Pulsante avanti... */
        if ( pagina == dati.risposta.pagine ) {
            $('.' + _tid + '_avanti')
                .unbind('click')
                .addClass('disabled');
        } else {
            $('.' + _tid + '_avanti')
                .unbind('click')
                .removeClass('disabled')
                .click ( function () {
                    _tabella_ricerca(e, query, input, pagina + 1);
                });
        }

    });

}


function _tabella_blocca_input( input ) {
    $(input).addClass('disabled').attr('disabled', 'disabled');
    $(input).parent().find('button').html (
        '<i class="icon-spinner icon-spin"></i>'
    );
}

function _tabella_sblocca_input ( input ) {
    $(input).removeClass('disabled').removeAttr('disabled');
    $(input).parent().find('button').html (
        '<i class="icon-search"></i>'
    );
    $(input).select().focus();
}



function _tabella_ridisegna( e, dati, input ) {
    var _tid = $(e).data('tid');

    /* Eventuale testo */
    var _rid = $(e).data('azioni');
    if ( _rid ) {
        var _testo = $(_rid).html();
    } else {
        var _testo = '(nessuna azione)';
    }
    /* Aggiorna i totali (pagina x di y, tot risultati) */
    $('#' + _tid + '_a').text( dati.pagina );
    $('#' + _tid + '_b').text( dati.pagine );
    $('#' + _tid + '_c').text( dati.totale );
    $(e).html(
        '<thead class="allinea-centro">' +
            '<th>Cognome</th>' +
            '<th>Nome</th>' +
            '<th>Cod. Fisc.</th>' +
            '<th>Comitato</th>' +
            '<th>Azioni</th>' +
        '</thead>' +
        '<tbody>' +
        '</tbody>'
    );
    var tbody = $(e).find('tbody');
    $.each( dati.risultati, function (i, volontario) {
        var nt = _tabella_sostituzioni(_testo, volontario);
        $(tbody).append(
            '<tr>' +
                '<td class="grassetto">' + volontario.cognome         + '</td>' +
                '<td class="grassetto">' + volontario.nome            + '</td>' +
                '<td>' + volontario.codiceFiscale   + '</td>' +
                '<td>' + volontario.comitato.nome   + '</td>' +
                '<td>' + nt + '</td>' +
            '</tr>'
        );
    });
    if ( dati.risultati.length == 0 ) {
        $(tbody).append(
            '<tr class="error">' +
                '<td colspan="5" class="allinea-centro">' +
                    '<h3><i class="icon-frown"></i> Nessun volontario trovato</h3>' +
                    '<p>Per favore prova con un altra ricerca.</p>' +
                    '<p>Sono accettate parti di nome, cognome, email e codice fiscale.</p>' +
                '</td>' +
            '</tr>'
        );
    }
    _tabella_sblocca_input(input);
}

function _tabella_sostituzioni (testo, volontario) {
    testo = testo.replace(/{id}/g,       volontario.id);
    testo = testo.replace(/{nome}/g,     volontario.nome);
    testo = testo.replace(/{cognome}/g,  volontario.cognome);
    // se non è riammissibile nascondo il tasto
    if (!volontario.riammissibile) {
        testo = testo.replace(/{riammissibile}/g,  "nascosto");
    }
    // se è già iscritto ad un base nascondo il tasto
    if (volontario.iscrittoBase) {
        testo = testo.replace(/{iscrittoBase}/g,  "nascosto");
    }
    return testo;
}

function _tabella_caricamento (e) {
    $(e).html(
        '<tr class="warning"><td class="allinea-centro"><h3>' +
            '<i class="icon-spinner icon-spin allinea-centro"></i> ' +
            '<strong>Caricamento in corso...</strong>' +
        '</h3></td></tr>'
    );
}


/*
 * Sistema di gestione della posta
 */
 function _posta (i, e) {
    var _eid = 'posta_' + Math.floor( Math.random() * 100 );
    $(e)
        .addClass('table')

    // Crea i tasti avanti ed indietro, se non "mini"
    if ( !$(e).data('mini') ) {
        var x = $(
            '<div class="row-fluid">' +
                '<div class="span8 allinea-sinistra">' +
                    'Pagina <span id="' + _eid + '_a">X</span> di ' +
                    '<span id="' + _eid + '_b">Y</span>  ' +
                '</div>' +
                '<div class="span4 allinea-destra">' +
                    '<div class="btn-group" id="'+ _eid + '">' +
                        '<a class="btn ' + _eid + '_indietro">' +
                            '<i class="icon-chevron-left"></i> ' +
                        '</a>' +
                        '<a class="btn ' + _eid + '_avanti">' +
                            '<i class="icon-chevron-right"></i>' +
                        '</a>' +
                    '</div>' +
                '</div>' +
            '</div>'
        );
        $(e).before(x); 
    }
    
    $(e).data('eid', _eid);
    // Avvia senza ricerca...
    //_email_ricerca(e, null, $('#' + _eid + '_ricerca').find('input').first());
    _posta_ricerca(e);
}

function _posta_ricerca ( e, pagina ) {
    _tabella_caricamento(e);
    //_tabella_blocca_input(input);
    if ( !pagina || pagina < 0 ) {
        pagina = 1;
    }
    var perPagina = $(e).data('perpagina');
    var _eid      = $(e).data('eid');
    if (!perPagina) {
        perPagina = 10;
    }
    
    api('posta:cerca', {
        'direzione':    $(e).data('direzione'),
        'pagina':       pagina,
        'perPagina':    perPagina
    }, function (dati) {
        _tabella_posta_ridisegna(e, dati.risposta);
         /* Pulsante indietro... */
        if ( pagina == 1 ) {
            $('.' + _eid + '_indietro')
                .unbind('click')
                .addClass('disabled');
        } else {
            $('.' + _eid + '_indietro')
                .unbind('click')
                .removeClass('disabled')
                .click ( function () {
                    _posta_ricerca(e, pagina - 1);
                });
        }   
        /* Pulsante avanti... */
        if ( pagina == dati.risposta.pagine ) {
            $('.' + _eid + '_avanti')
                .unbind('click')
                .addClass('disabled');
        } else {
            $('.' + _eid + '_avanti')
                .unbind('click')
                .removeClass('disabled')
                .click ( function () {
                    _posta_ricerca(e, pagina + 1);
                });
        }

    });

}

function _tabella_posta_ridisegna( e, dati, input ) {
    var _eid         = $(e).data('eid');
    var direzione    = $(e).data('direzione');  
    var persona      = '';
    var destinatario = '';

    /* Aggiorna i totali (pagina x di y, tot risultati) */
    $('#' + _eid + '_a').text( dati.pagina );
    $('#' + _eid + '_b').text( dati.pagine );

    $(e).html(
        '<table class="table table-condensed">' +
            '<thead class="allinea-centro">' +
                '<th class="allinea-centro"><i class="icon-user"></i></th>' +
                '<th class="allinea-centro">Messaggio</th>' +
            '</thead>' +
            '<tbody>' +
            '</tbody>' +
        '</table>'
    );
    var tbody = $(e).find('tbody');
    $.each( dati.risultati, function (i, email) {
        var ogg = '';
        if (email.oggetto.length > 35) {
            ogg = email.oggetto.substring(0, 35) + '...'
        } else {
            ogg = email.oggetto;
        }
        if ( email.mittente !== false  ) {
            // MITTENTE CONOSCIUTO
            //
            if ( direzione == 'ingresso' ) {
                $(tbody).append(
                    '<tr data-utente="' + email.mittente.id + '">' +
                        '<td>' +
                            '<img width="50" height="50" class="img-circle" src="{avatar}" title="{nomeCompleto}" alt="{nomeCompleto}" />' +
                        '</td>' +
                        '<td><strong>' + ogg + '</strong><br />{nomeCompleto}</td>' +
                    '</tr>'
                );
                persona  = '<i class="icon-user"></i> Da <span data-utente="' + email.mittente.id + '">{nomeCompleto}</span>';
            }
            mittente = '<i class="icon-user"></i> <span data-utente="' + email.mittente.id + '">{nomeCompleto}</span>';
        } else {
            // DA GAIA
            if ( direzione == 'ingresso' ) {
                $(tbody).append(
                    '<tr>' +
                        '<td>' +
                            '<img width="50" height="50" class="img-circle" src="https://gaia.cri.it/upload/avatar/placeholder/20.jpg" />' +
                        '</td>' +
                        '<td><strong>' + ogg + '</strong><br />Notifica da Gaia</td>' +
                    '</tr>'
                );
                persona  = '<i class="icon-info-sign"></i> <span>Notifica Gaia</span>';
            }
            mittente = '<i class="icon-info-sign"></i> Notifica di sistema Gaia';
        }
        
        if ( email.destinatari.length > 1 ) {

            // DESTINATARI MULTIPLI
            if ( direzione == 'uscita' ) {
                $(tbody).append(
                    '<tr>' +
                        '<td>' +
                            '<img width="50" height="50" class="img-circle" src="https://gaia.cri.it/upload/avatar/placeholder/20.jpg" />' +
                        '</td>' +
                        '<td><strong>' + ogg + '</strong><br />Destinatari multipli (' + email.destinatari.length + ')</td>' +
                    '</tr>'
                );
                persona      = '<i class="icon-group"></i> A <span>Destinatari multipli (' + email.destinatari.length + ')</span>';
            }

            destinatario = '<ul>';
            $.each(email.destinatari, function(y, q) {
                destinatario += '<li data-utente="' + q.id + '">{nomeCompleto}';
                if ( q.inviato ) {
                    destinatario += ' (<i class="icon-ok text-success"></i> inviato: ' + stampaDataOra(new Date(q.inviato * 1000)) + ')';
                } else {
                    destinatario += ' (<i class="icon-time text-warning"></i> in coda di invio)';
                }
                destinatario += '</li>';
            });
            destinatario += '</ul>';


        } else if ( email.destinatari.length > 0 ) {

            // DESTINATARIO SINGOLO
            if ( direzione == 'uscita' ) {
                $(tbody).append(
                    '<tr data-utente="' + email.destinatari[0].id + '">' +
                        '<td>' +
                            '<img width="50" height="50" class="img-circle" src="{avatar}" title="{nomeCompleto}" alt="{nomeCompleto}" />' +
                        '</td>' +
                        '<td><strong>' + ogg + '</strong><br />{nomeCompleto}</td>' +
                    '</tr>'
                );
                persona      = '<i class="icon-user"></i> <span data-utente="' + email.destinatari[0].id + '" data-conAvatar="false">{nomeCompleto}</span>';
            }

            destinatario = '<i class="icon-user"></i> <span data-utente="' + email.destinatari[0].id + '" data-conAvatar="false">{nomeCompleto}</span>';
            if ( email.invio.terminato ) {
                destinatario += ' (<i class="icon-ok text-success"></i> inviato: ' + stampaDataOra(new Date(email.invio.terminato * 1000)) + ')';
            } else {
                destinatario += ' (<i class="icon-time text-warning"></i> in coda di invio)';
            }


        } else {
            // AL SUPPORTO
            if ( direzione == 'uscita' ) {
                $(tbody).append(
                    '<tr>' +
                        '<td>' +
                            '<img width="50" height="50" class="img-circle" src="https://gaia.cri.it/upload/avatar/placeholder/20.jpg" />' +
                        '</td>' +
                        '<td><strong>' + ogg + '</strong><br />Squadra di Supporto Gaia</td>' +
                    '</tr>'
                );
                persona      = '<i class="icon-ambulance"></i> Squadra di Supporto</span>';
            }

            destinatario = '<i class="icon-ambulance"></i> Squadra di Supporto di Gaia</span>';
            if ( email.invio.terminato ) {
                destinatario += ' (<i class="icon-ok text-success"></i> inviato: ' + stampaDataOra(new Date(email.invio.terminato * 1000)) + ')';
            } else {
                destinatario += ' (<i class="icon-time text-warning"></i> in coda di invio)';
            }

        }      
        
        $(tbody).find('tr:last')
            .data('persona',        persona)
            .data('destinatario',   destinatario)
            .data('mittente',       mittente)
            .data('codice',         email.id)
            .addClass('riga-cliccabile')
            .click(
                function() {

            $('tr').removeClass("success");
            $(this).addClass("success");
            if ( $(e).data('messaggio') ) {
                var output = $(e).data('messaggio');
                $(output).html(
                    '<h4><i class="icon-comments"></i> ' + email.oggetto + '</h4>' +
                    '<div class="row-fluid" style="font-size: smaller;">' + 
                        '<span class="span6"><strong>' + $(this).data('persona') + '</strong> <a data-modale="(mostra dettagli)" data-titolo="Dettagli messaggio">' +
                            '<ul><li><strong>Mittente:</strong> ' + $(this).data('mittente') +
                            '</li><li><strong>Destinatario:</strong> ' + $(this).data('destinatario') +
                            '</li><li><strong>Creato:</strong> <i class="icon-time"></i> ' + stampaDataOra(new Date(email.timestamp*1000)) +
                            '</li><li><strong>Oggetto:</strong> ' + email.oggetto +
                            '</li></ul></a>'+ 
                        '</span>' +
                        '<span class="span3"><i class="icon-calendar"></i> ' + stampaData(new Date(email.timestamp*1000)) + '</span>' +
                        '<span class="span3"><i class="icon-time"></i> ' + stampaOra(new Date(email.timestamp*1000)) + '</span>' +

                    '</div>' +
                    '<p class="alert alert-info"><i class="icon-info-sign"></i>Per poter rispondere a questo messagio dovrai collegarti alla tua casella di posta.</p>' +
                    '<hr />' +
                    '<blockquote style="font-size: 12px !important;">' +
                      email.corpo +
                    '</blockquote>'


                );
                _render_utenti(true);
                _render_modali();
            } else {
                window.location = 'https://gaia.cri.it/?p=utente.posta&id=' + email.id;
            }

        });
    });

    if ( $(e).data('contatore') ) {
        $($(e).data('contatore')).text(dati.totale);
    }

    if ( dati.risultati.length == 0 ) {
        $(tbody).append(
            '<tr class="error">' +
                '<td colspan="2" class="allinea-centro">' +
                    '<h4><i class="icon-frown"></i> Nessuna comunicazione</h4>' +
                    '<p>Niente paura! Qui verranno salvate tutte le comunicazioni future inviate o ricevute tramite Gaia.</p>' +
                '</td>' +
            '</tr>'
        );
    }
    _render_utenti(); // Render mittenti e destinatari
    //_tabella_sblocca_input(input);
}

function _email_sostituzioni (testo, email) {
    testo = testo.replace(/{id}/g,       email.id);
    testo = testo.replace(/{oggetto}/g,  email.oggetto);
    return testo;
}

/**
 * Rendering dei Like
 */
function _render_like(oggetto) {
    var oggetti = [];
    var richieste = [];
    var str = '';
    str += '<div class="btn btn-small btn-like btn-0" data-tipo="0">';
    str += '  <i class="icon-thumbs-up icon-large"></i>';
    str += '  <span class="numero-like numero-like-0 badge badge-success"></span>';
    str += '</div>';
    str += '<div class="btn btn-small btn-like btn-1" data-tipo="1">';
    str += '  <i class="icon-thumbs-down  icon-large"></i>';
    str += '  <span class="numero-like numero-like-1 badge badge-important"></span>';
    str += '</div>';
    $("[data-like]").each( function(i, e) {
        var oggetto = $(e).data('like');
        $(e).addClass('contenitore-like').addClass('btn-group');
        if ( $(e).data('piccolo') ) {
            $(e).html(str.replace(/btn-small/g, 'btn-mini'));
        } else {
            $(e).html(str);
        }
        console.log($(e).children('.numero-like'));
        $(e).find('.numero-like').html('<i class="icon-spin icon-spinner"></i>');
        oggetti.push(oggetto);
        richieste.push({
            metodo      : 'like',
            parametri   : {oggetto: oggetto}
        });
        $(e).children('.btn').each(function(k,y) {
            $(y).click(function(){_like_click(oggetto, y);});
        });
    });

    api('multi', {richieste: richieste}, function(x) {
        $(x.risposta.risultato).each( function(i, r) {
            _render_like_singolo(oggetti[i], r.risposta);
        });
    });
}

function _like_click(oggetto, pulsante) {
    $(pulsante).attr('disabled', 'disabled').addClass('disabled');
    var tipo = $(pulsante).data('tipo');
    api('like', {
        oggetto: oggetto,
        tipo: tipo
    }, function(x) {
        if (x.risposta.hasOwnProperty('errore')) {
            alert('Devi effettuare l\'accesso su Gaia per poter esprimere giudizi su questo oggetto.');
        } else {
            _render_like_singolo(oggetto, x.risposta);
        }
        $(pulsante).removeAttr('disabled').removeClass('disabled');
    });

}

function _render_like_singolo(oggetto, dati) {
    var e = $("[data-like='" + oggetto + "']");
    $(e).find('.btn').removeClass('active');
    for ( i in dati ) {
        var x = $("[data-like='" + oggetto + "'] .btn-" + i);
        if ( dati[i].apposto ) {
            $(x).addClass('active');
        }
        $(x).find('.numero-like').text(dati[i].numero);
    }
}

/**
 * Rendering utenti 
 */
function _render_utenti( senzaAvatar ) {
    var riassunto = [];
    var richieste = [];

    var conAvatar = (senzaAvatar === undefined);
    $("[data-utente]").each( function(i, e) {
        var id = $(e).data('utente')
        $(e).attr('data-contenuto', $(e).html());
        var tConAvatar = conAvatar;
        if ($(e).data('conAvatar') !== undefined)
            tConAvatar = ($(e).data('conAvatar') == true);
        riassunto.push({elemento: e, id: id});
        richieste.push({
            metodo      : 'utente',
            parametri   : {id: id, conAvatar: tConAvatar}
        });
    });

    api('multi', {richieste: richieste}, function(x) {
        $(x.risposta.risultato).each( function(i, r) {
            _render_utente(riassunto[i].elemento, r.risposta);
        });
    });
}

function _render_utente(elemento, dati) {
    var testo = '' + $(elemento).attr('data-contenuto');
    testo = testo.replace(/{id}/gi,              dati.id);
    testo = testo.replace(/{nome}/gi,            dati.nome);
    testo = testo.replace(/{cognome}/gi,         dati.cognome);
    testo = testo.replace(/{nomeCompleto}/gi,    dati.nomeCompleto);
    if ( dati.hasOwnProperty('avatar') ) {
        testo = testo.replace(/{avatar}/gi,          dati.avatar["20"]);
    }
    $(elemento).removeAttr('data-utente');
    $(elemento).html(testo);
}

/**
 * Modale inlinea 
 */

function _render_modali() {
    $("[data-modale]").each( _modale_inline );
}

function _modale_inline(i, e) {
    $(e).attr('role', 'button').data('toggle', 'modal');
    var contenuto = $(e).html();
    $(e).html($(e).data('modale'));
    $(e).removeAttr('data-modale');
    var _mid = 'modale_' + Math.floor( Math.random() * 10000 );
    $(e).attr('href', '#' + _mid);
    $("body").append(
        '<div id="' + _mid + '" class="modal hide fade" role="dialog">' +
            '<div class="modal-header">' +
                '<button type="button" class="close" data-dismiss="modal"><i class="icon-remove"></i></button>' +
                '<h3>' + $(e).data('titolo') + '</h3>' +
            '</div><div class="modal-body">' +
                contenuto +
            '</div><div class="modal-footer">' +
                '<button class="btn" data-dismiss="modal"><i class="icon-remove"></i> Okay</button>' +
            '</div>' +
        '</div>'
    );
    $(e).click( function() {
        $('#' + _mid).modal('show');
        _render_utenti();
        return false;
    });

}

/**
 * Stampa la data in modalita it-IT con extra 0 
 */
function stampaData(data) {
    var d = ("0" + data.getDate()).slice(-2) + '/' + 
            ("0" + (data.getMonth()+1)).slice(-2) + '/' + 
            data.getFullYear();
    return d;
}
/**
 * Stampa l'ora in modalita it-IT con extra 0 
 */
function stampaOra(data) {
    var d = ("0" + data.getHours()).slice(-2) + ':' +  
            ("0" + data.getMinutes()).slice(-2) + ':' +
            ("0" + data.getSeconds()).slice(-2);
    return d;
}

/**
 * Bhe... non ci vuole un genio per capire cosa fa questa
 */
function stampaDataOra(data) {
    return stampaData(data) + ' ' + stampaOra(data);
}
